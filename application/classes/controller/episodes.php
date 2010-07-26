<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of episodes
 *
 * @author Morre95
 */
class Controller_Episodes extends Controller_Page {

    public function before() {
        parent::before();
    }
    public function after() {
        parent::after();
    }

    public function action_listAll($id) {
        if (!is_numeric($id)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }
        
        $cacheName = "series_ep_id_$id";

        $series = Cache::instance('default')->get($cacheName);

        if (is_null($series)) {
            $series = ORM::factory('series', $id);
            Cache::instance('default')->set($cacheName, $series);
        }

        $cacheName = "episodes_id_$id";

        if (isset($_GET['page'])) {
            $cacheName .= '_page_'.$_GET['page'];
        }

        $epRes = Cache::instance('default')->get($cacheName);

        if (is_null($epRes)) {

            $total = $series->episodes->where('season', '>', 0)->count_all(); // Pagination

            $pagination = Pagination::factory( array (
                    'base_url' => 'episodes/listAll/'.$id,
                    'total_items' => $total,
                    'items_per_page' => 15 // default 10
            ));

            $episodes = $series->episodes
                        ->where('season', '>', 0)
                        ->order_by('first_aired', 'desc')
                        ->limit($pagination->items_per_page)
                        ->offset($pagination->offset)
                        ->find_all();

            $epRes = array();
            foreach ($episodes as $ep) {
                $poster = new Posters();

                $posterMsg = "";
                if (preg_match('#^http:\/\/#', $ep->filename)) {
                    $path = "images/episode/";
                    $image = $posterFile = $ep->filename;
                    $newPosterName = $poster->ifFileExist(basename($image), $path);
                    if ($newPosterName) {
                        $posterFile = $path . $newPosterName;
                        $poster->saveImage($image, $posterFile);

                        $epORM = ORM::factory('episode', array('id' => $ep->id));
                        $epORM->filename = $posterFile;

                        if (!$epORM->save()) {
                            $posterMsg = '<div class="errorMsg">Ett fel med uppdaterningen av filnamnet har inträffat</div>';
                        } else {
                            $posterMsg = '<div class="successMsg">'.__('The image is downloaded').'</div>';
                        }
                    }
                } else if(is_readable($ep->filename)) {
                    $posterFile = $ep->filename;
                } else {
                    $posterFile = "images/poster.png";
                }
                
                $res = new stdClass;
                $res->id = $ep->id;
                $res->ep_id = $ep->ep_id;
                $res->filename = $ep->filename;
                $res->season = $ep->season;
                $res->episode = $ep->episode;
                $res->episode_name = $ep->episode_name;
                $res->first_aired = (is_null($ep->first_aired)) ? 'N/A' : $ep->first_aired;
                $res->overview = Text::limit_chars(HTML::entities($ep->overview), 280);
                $res->isDownloaded = ($ep->isDownloaded($ep->id)) ? ' <em>' . __('is downloaded') . '</em>' : '';
                $res->posterFile = $posterFile;
                $res->posterMsg = $posterMsg;
                $epRes[] = $res;
            }
            if ($posterMsg == "") {
                Cache::instance('default')->set($cacheName, $epRes);
            }
            Cache::instance('default')->set($cacheName.'_pagination', $pagination->render());

        }

        $name = $series->series_name;
        $this->template->title = $name;
        $xhtml = View::factory('episode/listAll');
        $xhtml->set('title', $name)
        ->set('seriesName', $name)
        ->set('id', $series->id)
        ->set('pagination', Cache::instance('default')->get($cacheName.'_pagination'))
        ->set('banner', $series->banner)
        ->set('episodes', $epRes)
        ->set('matrix_cat', NzbMatrix::cat2string($series->matrix_cat));

        $this->template->content = $xhtml;

    }

    public function action_listSpecials($id) {
        if (!is_numeric($id)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }
        $cacheName = "series_specials_ep_id_$id";

        $series = Cache::instance('default')->get($cacheName);

        if (is_null($series)) {
            $series = ORM::factory('series', $id);
            Cache::instance('default')->set($cacheName, $series);
        }

        $cacheName = "episodes_specials_id_$id";

        if (isset($_GET['page'])) {
            $cacheName .= '_page_'.$_GET['page'];
        }

        $epRes = Cache::instance('default')->get($cacheName);

        if (is_null($epRes)) {

            $total = $series->episodes->where('season', '=', 0)->count_all(); // Pagination

            $pagination = Pagination::factory( array (
                    'base_url' => 'episodes/listAll/'.$id,
                    'total_items' => $total,
                    'items_per_page' => 15 // default 10
            ));

            $episodes = $series->episodes
                        ->where('season', '=', 0)
                        ->order_by('first_aired', 'desc')
                        ->limit($pagination->items_per_page)
                        ->offset($pagination->offset)
                        ->find_all();

            $epRes = array();
            foreach ($episodes as $ep) {
                $poster = new Posters();

                $posterMsg = "";
                if (preg_match('#^http:\/\/#', $ep->filename)) {
                    $path = "images/episode/";
                    $image = $posterFile = $ep->filename;
                    $newPosterName = $poster->ifFileExist(basename($image), $path);
                    if ($newPosterName) {
                        $posterFile = $path . $newPosterName;
                        $poster->saveImage($image, $posterFile);

                        $epORM = ORM::factory('episode', array('id' => $ep->id));
                        $epORM->filename = $posterFile;

                        if (!$epORM->save()) {
                            $posterMsg = '<p class="msg error">Ett fel med uppdaterningen av filnamnet har inträffat</p>';
                        } else {
                            $posterMsg = '<p class="msg">Bilden är uppdaerad</p>';
                        }
                    }
                } else if(is_readable($ep->filename)) {
                    $posterFile = $ep->filename;
                } else {
                    $posterFile = "images/poster.png";
                }

                $res = new stdClass;
                $res->id = $ep->id;
                $res->ep_id = $ep->ep_id;
                $res->filename = $ep->filename;
                $res->season = $ep->season;
                $res->episode = $ep->episode;
                $res->episode_name = $ep->episode_name;
                $res->first_aired = (is_null($ep->first_aired)) ? 'N/A' : $ep->first_aired;
                $res->overview = Text::limit_chars(HTML::entities($ep->overview), 280);
                $res->isDownloaded = ($ep->isDownloaded($ep->id)) ? ' <em>' . __('is downloaded') . '</em>' : '';
                $res->posterFile = $posterFile;
                $res->posterMsg = $posterMsg;
                $epRes[] = $res;
            }

            Cache::instance('default')->set($cacheName, $epRes);
            Cache::instance('default')->set($cacheName.'_pagination', $pagination->render());

        }

        $name = $series->series_name;
        $this->template->title = 'Visa alla avsnitt från ' . $name;

        $xhtml = View::factory('episode/listAll');
        $xhtml->set('title', 'Home Page')
        ->set('seriesName', $name)
        ->set('id', $series->id)
        ->set('pagination', Cache::instance('default')->get($cacheName.'_pagination'))
        ->set('banner', $series->banner)
        ->set('episodes', $epRes)
        ->set('matrix_cat', NzbMatrix::cat2string($series->matrix_cat));

        $this->template->content = $xhtml;
    }

    public function action_update($id) {
        if (!is_numeric($id)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }
        $ep = ORM::factory('episode', array('ep_id' => $id));

        $tv = new TheTvDB(Kohana::config('default.default.TheTvDB_api_key'), null, $ep->language);

        try {
            $info = $tv->getEpisodeInfo($id);
        } catch (InvalidArgumentException $e) {
            $this->request->redirect(URL::query(array('error' => $e->getMessage())));
        } catch (ErrorException $e) {
            $this->request->redirect(URL::query(array('error' => $e->getMessage())));
        }
//        var_dump($info);

        $posterFile = 'http://thetvdb.com/banners/' . (string) $info->Episode->filename;

        $epData = array(
                'ep_id' => $info->Episode->id,
                'director' => $info->Episode->Director,
                'ep_img_flag' => $info->Episode->EpImgFlag,
                'episode_name' => $info->Episode->EpisodeName,
                'episode' => $info->Episode->EpisodeNumber,
                'first_aired' => $info->Episode->FirstAired,
                'guest_stars' => $info->Episode->GuestStars,
                'IMDB_ID' => $info->Episode->IMDB_ID,
                'language' => $info->Episode->Language,
                'overview' => $info->Episode->Overview,

                'rating' => $info->Episode->Rating,
                'season' => $info->Episode->SeasonNumber,
                'writer' => $info->Episode->Writer,
                'lastupdated' => $info->Episode->lastupdated,
                'seasonid' => $info->Episode->seasonid,
                'seriesid' => $info->Episode->seriesid,
        );

        if (!file_exists($ep->filename)) {
            $poster = new Posters();
            $path = "images/episode/";
            $image = 'http://thetvdb.com/banners/' . (string) $info->Episode->filename;
            $newPosterName = $poster->ifFileExist(basename($image), $path);
            if ($newPosterName) {
                $posterFile = $path . $newPosterName;
                $poster->saveImage($image, $posterFile);
            }

            $epData = array_merge($epData, array('filename' => $posterFile));
        }

        $ep->values($epData);
        if (!$ep->save()) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: databas episodes error')));
        }

        if (!isset($_GET['series_id']) && !is_numeric($_GET['series_id'])) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }

        $series = ORM::factory('series', $_GET['series_id']);

        $msg =  sprintf('%s S%02dE%02d "%s" is updated',
                $series->series_name,
                (int) $info->Episode->SeasonNumber,
                (int) $info->Episode->EpisodeNumber,
                (string) $info->Episode->EpisodeName
                );

        $this->request->redirect('episodes/' . $_GET['series_id'] . URL::query(array('msg' => $msg)));
    }

    public function action_delete($id, $epId) {
        if (!is_numeric($id) || !is_numeric($epId)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }
        $series = ORM::factory('series', $id);
        $name = $series->series_name;

        if (isset($_GET['delete'])) {
            $this->delete($id, $epId);
            $this->request->redirect('' . URL::query(array('msg' => $name . ' ' . __('is deleted'))));
        }

        $this->template->title = __('Delete') . ' ' . $name;

        $xhtml = View::factory('episode/delete');
        $xhtml->set('title', 'Home Page')
        ->set('seriesName', $name)
        ->set('id', $series->id)
        ->set('banner', $series->banner)
        ->set('epId', $epId)
        ->set('ep', ORM::factory('episode')->where('id', '=', $epId)->find())

        ->set('matrix_cat', NzbMatrix::cat2string($series->matrix_cat));

        $this->template->content = $xhtml;
    }

    public function action_ajax_getLasAired() {
        if (!Request::$is_ajax) {
            return;
        }
        
        $sorted = Model_SortFirstAired::getSeries();

        $modelEp = ORM::factory('episode');
        $html = "";
        foreach ($sorted as $ep) {
            $html .= "<li>";
            $html .= "<h2>" . HTML::anchor($ep->download_link, $ep->series_name) . "</h2>";
            if ($modelEp->isDownloaded($ep->episode_id)) {
                $html .= "<em style='color:red;'>".__('is downloaded')."</em> ";
            } else {
                $html .= "<em>" . HTML::anchor($ep->download_link, sprintf("S%02dE%02d",$ep->season, $ep->episode)) . "</em> ";
                $html .= "<span>$ep->first_aired</span>";
            }
            $html .= "</li>";
        }

        $this->request->response = $html;
    }

    public function action_ajax_readyDownload($id) {
        $ep = ORM::factory('episode', array('id' => $id));

        if ($ep->downloadable !== null) {
            $this->request->headers['Content-Type'] = 'text/json';
            $this->request->response = json_encode(
                array( 'text' => __('ready to download') )
                    );
            return;
        }

        $series = $ep->getSeriesInfo();
        $search = sprintf('%s S%02dE%02d', $series->series_name, $ep->season, $ep->episode);

        $matrix = new NzbMatrix_Rss(Kohana::config('default.default'));

        $result = $matrix->search($search);

        if (is_numeric($result)) {
            $this->request->headers['Status'] = $result . ' ' . Helper::getHttpCodeMessage($result);
        }

        foreach ($result->item as $res) {
            $parse = new NameParser($res->title);
            $parsed = $parse->parse();
            if ($series->series_name == $parsed['name']) {
                $this->request->headers['Content-Type'] = 'text/json';
                $this->request->response = json_encode(
                    array( 
                        'text' => __('ready to download'),
                        'id' => $id
                        )
                        );
                return;
            }
        }

        $this->request->headers['Status'] = '404 Not Found';
    }
    
    protected function delete($id, $epId) {
        if (!is_numeric($id) || !is_numeric($epId)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }
        $series = ORM::factory('series', $id);

        $ep = ORM::factory('episode', array('id' => $epId));
        $series->remove('episodes', $ep);
        $ep->delete();
    }

}
?>
