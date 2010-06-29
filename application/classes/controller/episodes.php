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
class Controller_Episodes extends Controller_Xhtml {

    public function before() {
        parent::before();
//        $film = "avatar";
//        $thumnet = new Thumnet();
//        var_dump($thumnet->search($film));
//        $title = 'tt0499549';
//        var_dump($thumnet->getByTitle($title));
        //I18n::lang('se-se');
    }
    public function after() {
        parent::after();
    }

    public function action_listAll($id) {
        if (!is_numeric($id)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }
        $series = ORM::factory('series', $id);

        $total = $series->episodes->where('season', '>', 0)->count_all(); // Pagination

        $pagination = Pagination::factory( array (
                'base_url' => 'episodes/listAll/'.$id,
                'total_items' => $total,
                'items_per_page' => 15 // default 10
        ));

        //var_dump(Request::$is_ajax);

        $name = $series->series_name;
        Head::instance()->set_title('Visa alla avsnitt från ' . $name);

        $xhtml = Xhtml::instance('episode/listAll');
        $xhtml->body->set('title', 'Home Page')
        ->set('menu', new View('menu'))
        ->set('seriesName', $name)
        ->set('id', $series->id)
        ->set('pagination', $pagination->render())
        ->set('banner', $series->banner)
        ->set('episodes', $series->episodes->where('season', '>', 0)->order_by('first_aired', 'desc')->limit($pagination->items_per_page)->offset($pagination->offset)->find_all())
        //->set('episodes', $series->episodes->find_all())
        ->set('matrix_cat', NzbMatrix::cat2string($series->matrix_cat));

        //var_dump($series->last_query());
        $this->request->response = $xhtml;

    }

    public function action_listSpecials($id) {
        if (!is_numeric($id)) {
            $this->request->redirect('' . URL::query(array('msg' => 'Error: no id')));
        }
        $series = ORM::factory('series', $id);

        $total = $series->episodes->where('season', '=', 0)->count_all(); 

        $pagination = Pagination::factory( array (
                'base_url' => 'episodes/listAll/'.$id,
                'total_items' => $total,
                'items_per_page' => 15
        ));

        $name = $series->series_name;
        Head::instance()->set_title('Visa alla avsnitt från ' . $name);

        $xhtml = Xhtml::instance('episode/listAll');
        $xhtml->body->set('title', 'Home Page')
        ->set('menu', new View('menu'))
        ->set('seriesName', $name)
        ->set('id', $series->id)
        ->set('pagination', $pagination->render())
        ->set('banner', $series->banner)
        ->set('episodes', $series->episodes->where('season', '=', 0)->order_by('first_aired', 'desc')->limit($pagination->items_per_page)->offset($pagination->offset)->find_all())
        ->set('matrix_cat', NzbMatrix::cat2string($series->matrix_cat));

        $this->request->response = $xhtml;
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

        Head::instance()->set_title('Visa alla avsnitt från ' . $name);

        $xhtml = Xhtml::instance('episode/delete');
        $xhtml->body->set('title', 'Home Page')
        ->set('menu', new View('menu'))
        ->set('seriesName', $name)
        ->set('id', $series->id)
        ->set('banner', $series->banner)
        ->set('epId', $epId)
        ->set('ep', ORM::factory('episode')->where('id', '=', $epId)->find())
        //->set('ep', $series->episodes->where('id', '=', $epId)->find())
        //->set('episodes', $series->episodes->find_all())
        ->set('matrix_cat', NzbMatrix::cat2string($series->matrix_cat));

        //var_dump($series->last_query());
        $this->request->response = $xhtml;
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

        $matrix = new NzbMatrix_Rss(Kohana::config('default.default.NzbMatrix_api_key'));

        $result = $matrix->search($search);

        foreach ($result->item as $res) {
            //var_dump($res->title);
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
