<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of series
 *
 * @author Morre95
 */
class Controller_Series extends Controller_Xhtml {
    
    private $TheTvDB_api_key;

    public function before() {
        parent::before();
        $this->TheTvDB_api_key = Kohana::config('default.default.TheTvDB_api_key');
    }

    public function action_add() {
        Head::instance()->set_title(__('Add new series'));
        $menu = new View('menu');

        Head::$scripts['jquery autocomplete js'] = 'js/jquery.autocomplete.pack.js';
        Head::$styles['jquery autocomplete css'] = 'css/jquery.autocomplete.css';

        $autocomplete = Kohana::config('series.autocomplete');

        Head::$codes['jquery autocomplete code'] = "var data = ".json_encode($autocomplete).";";

        $xhtml = Xhtml::instance('series/add');
        $xhtml->body->set('title', __('Add new series'))
                ->set('menu', $menu)
                ->set('languages', ORM::factory('language')->find_all());

        $this->request->response = $xhtml;
    }

    public function action_doAdd() {
        if (empty($_POST['name'])) {
            $this->request->redirect(URL::query(array('save' => 'Error')));
        }

        $lang = ORM::factory('language')->find($_POST['language']);

        try {
            $tv = new TheTvDB($this->TheTvDB_api_key, $_POST['name'], $lang->abbreviation);

            $series = ORM::factory('series');
            $arr = $tv->toArray();
            if ($series->isAdded($arr['seriesName'])) {
                $this->request->redirect('series/add' . URL::query(array('msg' => $_POST['name'] . ' ' . __('alredy exists'))));
            }

            $info = $tv->getSeriesInfo();
        } catch (InvalidArgumentException $e) {
            $this->request->redirect(URL::query(array('error' => $e->getMessage())));
        }

        $saveAsNew = Kohana::config('default.default.saveImagesAsNew');
        $series = $this->saveInfo($series, $info, $saveAsNew);
        $series->language_id = $_POST['language'];
        $lastId = $series->save();
        if (!$lastId) {
            $this->request->redirect('series/add' . URL::query(array('msg' => 'Error: databas series error')));
        }

        $poster = new Posters();
        $i = 1;
        foreach ($info->Episode as $ep) {
            if (!empty($ep->filename) && $i <= 5) {
                $i++;
                $path = "images/episode/";
                $image = $posterFile = 'http://thetvdb.com/banners/' . (string) $ep->filename;
                $newPosterName = $poster->ifFileExist(basename($image), $path);
                if ($newPosterName) {
                    $posterFile = $path . $newPosterName;
                    if (!file_exists($posterFile))
                    $poster->saveImage($image, $posterFile);
                }
            } else {
                $posterFile = 'http://thetvdb.com/banners/' . (string) $ep->filename;
            }

            $first_aired = (string) $ep->FirstAired;

            $epData = array(
                    'ep_id' => (int) $ep->id,
                    'director' => (string) $ep->Director,
                    'ep_img_flag' => (string) $ep->EpImgFlag,
                    'episode_name' => (string) $ep->EpisodeName,
                    'episode' => (string) $ep->EpisodeNumber,
                    'first_aired' => empty($first_aired) ? null : $first_aired,
                    'guest_stars' => (string) $ep->GuestStars,
                    'IMDB_ID' => (string) $ep->IMDB_ID,
                    'language' => (string) $ep->Language,
                    'overview' => (string) $ep->Overview,

                    'rating' => (string) $ep->Rating,
                    'season' => (string) $ep->SeasonNumber,
                    'writer' => (string) $ep->Writer,
                    'filename' => $posterFile,
                    'lastupdated' => (int) $ep->lastupdated,
                    'seasonid' => (int) $ep->seasonid,
                    'seriesid' => (int) $ep->seriesid,
            );

            $episodes = ORM::factory('episode');
            $episodes->values($epData);
            $episodes->series_id = $lastId;
            $episodes->save();
        }

	Cache::instance('default')->delete('series');

        $this->request->redirect('series/add' . URL::query(array('msg' => $_POST['name'] . ' ' . __('is saved'))));
    }

    public function action_update($id) {
        if (!is_numeric($id)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }

        $menu = new View('menu');

        $series = ORM::factory('series', $id);

        Head::instance()->set_title(__('update') . ' ' . $series->series_name);

        $xhtml = Xhtml::instance('series/update');
        $xhtml->body->set('title', __('update') . ' ' . $series->series_name)
                ->set('series', $series)
                ->set('url', URL::site('series/doUpdate/' . $id))
                ->set('banners', array())
                ->set('menu', $menu);

        $this->request->response = $xhtml;
    }

    public function action_doUpdate($id) {
        if (!is_numeric($id)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }

        $series = ORM::factory('series', $id);

        $name = $series->series_name;

        try {
            $tv = new TheTvDB($this->TheTvDB_api_key, $series->series_name);
            $info = $tv->getSeriesInfo();
        } catch (InvalidArgumentException $e) {
            $this->request->redirect(URL::query(array('error' => $e->getMessage())));
        } catch (ErrorException $e) {
            $this->request->redirect(URL::query(array('error' => $e->getMessage())));
        }

        $overwrite = Kohana::config('default.default.saveImagesAsNew');

        $matrix_cat = $series->matrix_cat;

        $series = $this->saveInfo($series, $info, $overwrite);

        if (isset($_POST['matrix_cat'])) $series->matrix_cat = $_POST['matrix_cat'];
        else $series->matrix_cat = $matrix_cat;

        $lastId = $series->save();
        if (!$lastId) {
            $this->request->redirect(URL::query(array('msg' => 'Error: databas series error')));
        }

        foreach ($series->episodes->find_all() as $ep) {
            $episode = ORM::factory('episode', $ep);
            //$series->remove('episodes', $ep);
            $episode->delete();
        }

        $poster = new Posters();
        $i = 0;
        $path = "images/episode/";
        foreach ($info->Episode as $ep) {
            $posterFile = 'http://thetvdb.com/banners/' . (string) $ep->filename;

            $first_aired = (string) $ep->FirstAired;
            $epData = array(
                    'ep_id' => $ep->id,
                    'director' => $ep->Director,
                    'ep_img_flag' => $ep->EpImgFlag,
                    'episode_name' => $ep->EpisodeName,
                    'episode' => $ep->EpisodeNumber,
                    'first_aired' => empty($first_aired) ? null : $first_aired,
                    'guest_stars' => $ep->GuestStars,
                    'IMDB_ID' => $ep->IMDB_ID,
                    'language' => $ep->Language,
                    'overview' => $ep->Overview,

                    'rating' => $ep->Rating,
                    'season' => $ep->SeasonNumber,
                    'writer' => $ep->Writer,
                    //'filename' => $posterFile,
                    'lastupdated' => $ep->lastupdated,
                    'seasonid' => $ep->seasonid,
                    'seriesid' => $ep->seriesid,
            );

            if (!file_exists($path . basename($ep->filename)) && $i < 7) {
                $i++;
                $image = 'http://thetvdb.com/banners/' . (string) $ep->filename;
                $posterFile = $path . $poster->ifFileExist(basename($image), $path);
                $poster->saveImage($image, $posterFile);

                $epData = array_merge($epData, array('filename' => $posterFile));
            } else {
                $epData = array_merge($epData, array('filename' => $path . basename($ep->filename)));
            }

            $episodes = ORM::factory('episode');
            $episodes->values($epData);
            $episodes->series_id = $lastId;
            $episodes->save();

            Cache::instance('default')->delete("series_ep_id_$id");
            Cache::instance('default')->delete("episodes_id_$id");

            $i = 2;
            while (Cache::instance('default')->get('episodes_id_'.$id.'_page_'.$i)) {
                Cache::instance('default')->delete('episodes_id_'.$id.'_page_'.$i);
                $i++;
            }
        }

        Cache::instance('default')->delete('series');
        /** Only update if the reques is not internaly **/
        if ($this->request == Request::instance()) {
            $this->request->redirect('' . URL::query(array('msg' => $name . ' ' . __('is updated'))));
        }

    }

    public function action_edit($id) {
        if (!is_numeric($id)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }

        $menu = new View('menu');

        $series = ORM::factory('series', $id);

        $bannerArray = $this->getBanners($series->series_name);
        
        Head::instance()->set_title(__('edit') . ' ' . $series->series_name);

        $xhtml = Xhtml::instance('series/update');
        $xhtml->body->set('title', __('edit') . ' ' . $series->series_name)
                ->set('series', $series)
                ->set('url', URL::site('series/doEdit/' . $id))
                ->set('banners', $bannerArray)
                ->set('menu', $menu);

        $this->request->response = $xhtml;
    }

    public function action_doEdit($id) {
        if (!is_numeric($id)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }

        $series = ORM::factory('series', $id);
        $series->matrix_cat = $_POST['matrix_cat'];
        $poster = new Posters();
        if (!empty($_POST['fanart'])) {
            $path = "images/fanart/";
            if (file_exists($series->fanart))
            unlink($series->fanart);
            $fanartFile = $path . basename($_POST['fanart']);
            $poster->saveImage($_POST['fanart'], $fanartFile);
            $series->fanart = $fanartFile;
        }
        if (!empty($_POST['poster'])) {
            $path = "images/poster/";
            if (file_exists($series->poster))
            unlink($series->poster);
            $posterFile = $path . basename($_POST['poster']);
            $poster->saveImage($_POST['poster'], $posterFile);
            $series->poster = $posterFile;
        }
        if (!empty($_POST['banner'])) {
            $path = "images/banner/";
            if (file_exists($series->banner))
            unlink($series->banner);
            $bannerFile = $path . basename($_POST['banner']);
            $poster->saveImage($_POST['banner'], $bannerFile);
            $series->banner = $bannerFile;
        }

        if (!$series->save()) {
            $this->request->redirect(URL::query(array('msg' => 'Error: databas series error')));
        }
		
	Cache::instance('default')->delete('series');
        $this->request->redirect('' . URL::query(array('msg' => $series->series_name . ' ' . __('is updated'))));
    }

    public function action_ajax_searchNew($name) {
//    public function action_search($name) {
        try {
            $series = ORM::factory('series');
            if ($series->isAdded($name)) {
                $this->request->response = $name . ' ' . __('alredy exists');
                return;
            }
            $tv = new TheTvDB($this->TheTvDB_api_key, $name);

            $seriesXml = $tv->getSeries();
        } catch (InvalidArgumentException $e) {
            $this->request->response = $e->getMessage() . '. Serach string: ' . $name;
            return;
        }

        $html = '<label for="select-ep">'.__("Select").':</label>
                <select id="select-ep" name="select-ep">
                <option>'.__("Select").'</option>';
        foreach ($seriesXml->Series as $xml) {
            $html .= "<option value='$xml->SeriesName'>$xml->SeriesName</option>";
        }
        $html .= "</select>";
        $this->request->response = $html;
    }

    public function action_ajax_getBanners($name) {
        try {
            $tv = new TheTvDB($this->TheTvDB_api_key, $name);

            $series = ORM::factory('series');
            $tvArray = $tv->toArray();
            if ($series->isAdded($tvArray['seriesName'])) {
                $this->request->response = $name . ' ' . __('alredy exists');
                return;
            }
            $banners = $tv->getBanners();
        } catch (InvalidArgumentException $e) {
            $this->request->response = $e->getMessage();
            return;
        }

        $this->clearCache();

        $response = "";

        $i = 1;
        $poster = new Posters();
        foreach ($banners as $banner) {
            if ($banner->BannerType == 'poster' && $i <= 5) {
                $savePath = 'images/__cache/' . basename($banner->BannerPath);
                if (!file_exists($savePath)) {
                    $poster->saveImage('http://thetvdb.com/banners/' . $banner->BannerPath, $savePath);
                    $i++;
                }
                $response .= HTML::anchor('#' ,HTML::image('index.php/' . $savePath . '/125',
                        array(
                        'alt' => 'Series banner for ' . $tvArray['seriesName'],
                        'title' => $savePath,
                        'class' => 'select-img'
                        )) . "\n");
            }
        }
        $response .= "<br />";
        if (isset($tvArray['imdb']))
        $response .= HTML::anchor($tvArray['imdb'], $tvArray['seriesName'] . ' ' . __('on Imdb'));
        $response .= " | ";
        $response .= HTML::anchor('http://www.thetvdb.com/?tab=series&id=' . $tvArray['id'], $tvArray['seriesName'] . ' ' . __('on The Tv DB'));

        $this->request->response = $response;
    }

    public function action_delete($id) {
        if (!is_numeric($id)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }
        $series = ORM::factory('series', $id);

        $name = $series->series_name;
        foreach ($series->episodes->find_all() as $ep) {
            if (file_exists($ep->filename) && !preg_match('/^http:\/\//', $ep->filename)) {
                unlink($ep->filename);
            }
            $episode = ORM::factory('episode', $ep);

            $episode->delete();
        }

        if (file_exists($series->poster) && !preg_match('/^http:\/\//', $series->poster)) {
            unlink($series->poster);
        }
        if (file_exists($series->fanart) && !preg_match('/^http:\/\//', $series->fanart)) {
            unlink($series->fanart);
        }
        if (file_exists($series->banner) && !preg_match('/^http:\/\//', $series->banner)) {
            unlink($series->banner);
        }


        $series->delete();
		Cache::instance('default')->delete('series');
        $this->request->redirect('' . URL::query(array('msg' => $name . ' ' . __('is deleted'))));
    }

    public function action_ajax_getInfo($id) {
        if (!is_numeric($id)) {
            return;
        }

        $series = ORM::factory('series', $id);
        $seriesName = $series->series_name;
        $html = "";
        $html .= "<h2>" . $series->series_name . "</h2>";
        $html .= "<em>" . __('Airs') . ': ' . __($series->airs_day) . ' ' . __('at') . ' ' . date('H:i', strtotime($series->airs_time)) . "</em>";
        $html .= "<br /><em>" . __('Status') . ': ' . __($series->status) . "</em>";
        $html .= "<br /><em>" . __('Network') . ': ' . $series->network . "</em>";
        $html .= "<br /><em>" . __('Runtime') . ': ' . $series->runtime . ' ' . __('minutes') . "</em>";
        $html .= "<br /><em>" . __('Rating') . ': ' . $series->rating . "</em>";
        $html .= "<br /><em>" . __('Genre') . ': ' . $series->genre . "</em>";
        $html .= "<br /><em>" . __('Actors') . ': ' . $series->actors . "</em>";

        $this->request->response = $html;
    }

    protected function saveInfo(ORM $series, SimpleXMLElement $info, $saveAsNew = false) {
        $poster = new Posters();

        $fanartFile = "";
        $bannerFile = "";
        $posterFile = "images/poster.png";
        if (!empty($info->Series->poster)) {
            $path = "images/poster/";
            $image = 'http://thetvdb.com/banners/' . (string) $info->Series->poster;

            if (empty($_POST['poster'])) {
                if (isset($series->poster) && file_exists($series->poster)) {
                    $posterFile = $series->poster;
                } else {
                    if ($saveAsNew) {
                        $posterFile = $path . $poster->ifFileExist(basename($image), $path);
                    } else {
                        $posterFile = $path . basename($image);
                    }

                    if (!file_exists($posterFile))
                    $poster->saveImage($image, $posterFile);
                }
            } else {
                $posterFile = $path . basename($_POST['poster']);
                if (!rename($_POST['poster'], $posterFile)) {
                    $this->request->redirect('' . URL::query(array('msg' => 'Error: can´t move image')));
                }
                $this->clearCache();
            }

        }

        if (!empty($info->Series->banner)) {
            $path = "images/banner/";
            $image = 'http://thetvdb.com/banners/' . (string) $info->Series->banner;
            if ($saveAsNew) {
                $bannerFile = $path . $poster->ifFileExist(basename($image), $path);
            } else {
                $bannerFile = $path . basename($image);
            }

            if (!file_exists($bannerFile))
            $poster->saveImage($image, $bannerFile);
        }

        if (!empty($info->Series->fanart)) {
            $path = "images/fanart/";
            $image = 'http://thetvdb.com/banners/' . (string) $info->Series->fanart;
            if ($saveAsNew) {
                $fanartFile = $path . $poster->ifFileExist(basename($image), $path);
            } else {
                $fanartFile = $path . basename($image);
            }

            if (!file_exists($fanartFile))
            $poster->saveImage($image, $fanartFile);
        }

        $data = array(
                'tvdb_id'        => (int) $info->Series->id,
                'actors'         => (string) $info->Series->Actors,
                'airs_day'       => (string) $info->Series->Airs_DayOfWeek,
                'airs_time'      => (string) $info->Series->Airs_Time,
                'content_rating' => (string) $info->Series->ContentRating,
                'first_aired'    => (string) $info->Series->FirstAired,
                'genre'          => (string) $info->Series->Genre,
                'IMDB_ID'        => (string) $info->Series->IMDB_ID,
                'language'       => (string) $info->Series->Language,
                'network'        => (string) $info->Series->Network,

                'network_id'     => (string) $info->Series->NetworkID,
                'overview'       => (string) $info->Series->Overview,
                'rating'         => (string) $info->Series->Rating,
                'runtime'        => (string) $info->Series->Runtime,
                'series_id'      => (int) $info->Series->SeriesID,
                'series_name'    => (empty($info->Series->SeriesName) && isset($_POST['name'])) ? $_POST['name'] : (string) $info->Series->SeriesName,
                'status'         => (string) $info->Series->Status,
                'added'          => (string) $info->Series->added,
                'added_by'       => (string) $info->Series->addedBy,
                'banner'         => $bannerFile,

                'fanart'         => $fanartFile,
                'lastupdated'    => (string) $info->Series->lastupdated,
                'poster'         => $posterFile,
                'zap2it_id'      => (string) $info->Series->zap2it_id,
                'matrix_cat'     => (isset($_POST['cat'])) ? $_POST['cat'] : 'tv-all'
        );

        $series->values($data);

        return $series;
    }

    protected function getBanners($series_name) {
        try {
            $tv = new TheTvDB($this->TheTvDB_api_key, $series_name);
            $banners = $tv->getBanners();
        } catch (InvalidArgumentException $e) {
            $this->request->redirect(URL::query(array('error' => $e->getMessage())));
        }


        $bannerArray = array();
        foreach($banners as $banner) {
            if ($banner->BannerType == 'poster') {
                $savePath = 'http://thetvdb.com/banners/' . $banner->BannerPath;
                $bannerArray['Poster'][] = HTML::anchor(URL::base() . 'images/thetvdb/125?image=' . $savePath ,HTML::image(URL::base() . 'index.php/images/thetvdb/125?image=' . $savePath, array(
                    'alt' => 'Series banner for ' . $series_name,
                    'title' => $savePath,
                    'class' => 'select-poster'
                    )) . "\n");
            }

            if ($banner->BannerType == 'fanart') {
                $savePath = 'http://thetvdb.com/banners/' . $banner->BannerPath;
                $bannerArray['Fanart'][] = HTML::anchor('#' ,HTML::image(URL::base() . 'images/thetvdb/125?image=' . $savePath, array(
                    'alt' => 'Series banner for ' . $series_name,
                    'title' => $savePath,
                    'class' => 'select-fanart'
                    )) . "\n");
            }

            if ($banner->BannerType == 'series') {
                $savePath = 'http://thetvdb.com/banners/' . $banner->BannerPath;
                $bannerArray['Banner'][] = HTML::anchor('#' ,HTML::image(URL::base() . 'images/thetvdb/125?image=' . $savePath, array(
                    'alt' => 'Series banner for ' . $series_name,
                    'title' => $savePath,
                    'class' => 'select-banner'
                    )) . "\n");
            }
        }

        return $bannerArray;
    }

    protected function clearCache() {
        foreach (glob("images/__cache/*") as $filename) {
            if (filemtime($filename) < (time() - Kohana::config('default.default.cacheTimeImages')))
                unlink($filename);
        }
    }
}
?>
