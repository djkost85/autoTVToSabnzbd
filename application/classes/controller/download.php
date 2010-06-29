<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of download
 *
 * @author Morre95
 */
class Controller_Download extends Controller_Xhtml {

    public function action_episode($id) {
        $ep = ORM::factory('episode', array('id' => $id));
        $series = $ep->getSeriesInfo();
        $search = sprintf('%s S%02dE%02d', $series->series_name, $ep->season, $ep->episode);

        $matrix = new NzbMatrix(Kohana::config('default.default.NzbMatrix_api_key'));

        //$series = $ep->getSeriesInfo();
        $results = $matrix->search($search, $series->matrix_cat);

//        var_dump($search);
//        var_dump($results);
//        var_dump($ep->downloads->find_all());
//        var_dump(NzbMatrix::catStr2num($results[0]['category']));
//        var_dump($series->series_name);
//        return;

        if (isset($results[0]['error'])) {
            if (preg_match('#^(.*)_(?P<num>\d{1,2})$#', $results[0]['error'], $matches)) {
                $msg = sprintf(__('please_wait_x'), $matches['num']);
            } else {
                $msg = __($results[0]['error']);
            }
            
            $this->request->redirect("episodes/$series->id/" . URL::query(array('msg' => "Mzb Matrix error: $msg")));
        }
        
        $sab = new Sabnzbd(Kohana::config('default.Sabnzbd'));
        $searchResult = array();
        foreach ($results as $result) {
            $parse = new NameParser($result['nzbname']);
            $parsed = $parse->parse();
            $isDownload = $sab->isDownloaded($result['nzbname']);

//            var_dump($isDownload);
//            var_dump($parsed);
//            var_dump(strtolower(NzbMatrix::cat2string($series->matrix_cat)));
//            var_dump(strtolower($result['category']));


            if ($isDownload) {
                $result = array_merge($result, array('episode_id' => $ep->id, 'downloaded' => true));
                $searchResult[$result['nzbid']] = $result;
                continue;
            }

            if (
                sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
                sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
                strtolower($parsed['name']) == strtolower($series->series_name)
                ) {

                if (NzbMatrix::catStr2num($result['category']) != $series->matrix_cat) {
                    $result = array_merge($result, array('episode_id' => $ep->id, 'noCatMatch' => true));
                    $searchResult[$result['nzbid']] = $result;
                    continue;
                }

                $result = array_merge($result, array('episode_id' => $ep->id, 'good' => true));
                $searchResult[$result['nzbid']] = $result;
                continue;

            }
            $result = array_merge($result, array('episode_id' => $ep->id, 'noMatch' => true));
            $searchResult[$result['nzbid']] = $result;
        }

        if (!empty($searchResult)) {
            if (count($searchResult) == 1 && array_key_exists('good', $searchResult[key($searchResult)])) {
                $result = $searchResult[key($searchResult)];

                $sab->sendNzb($matrix->buildDownloadUrl($result['nzbid']), $search);

                $d = ORM::factory('download');
                $d->episode_id = $result['episode_id'];
                $d->search = $search;
                $d->found = $result['nzbname'];
                $d->save();

                //$this->request->redirect("episodes/$series->id/" . URL::query(array('msg' => "Download: " . $search)));
                $this->request->redirect(URL::query(array('msg' => "Download: " . $search)));
            }
            
            $session = Session::instance();
            $session->set('seachResults', $searchResult);
            $this->request->redirect("download/no_match/$ep->id");
        }

        $this->request->redirect("episodes/$series->id/" . URL::query(array('msg' => "nothing found [$search]")));
    }

    public function action_no_match($id) {
        $ep = ORM::factory('episode', array('id' => $id));
        $series = $ep->getSeriesInfo();

        $session = Session::instance();
        $results = $session->get('seachResults');
//        $session->delete('seachResults');

        if (!$results) {
            $this->request->redirect(URL::query(array('msg' => "nothing found")));
        }

        Head::instance()->set_title(__('Click to download') . '?');
        $menu = new View('menu');

        $xhtml = Xhtml::instance('download/no_match');
        $xhtml->body->set('title', __('Click to download'))
                ->set('menu', $menu)
                ->set('results', $results)
                ->set('series', $series)
                ->set('ep', $ep);

        $this->request->response = $xhtml;
    }

    public function action_doDownload($id) {
        $session = Session::instance();
        $results = $session->get('seachResults');

//        var_dump($results);
//        var_dump(isset($results[$id]));
//        return;

        if (!isset($results[$id])) {
            $this->request->redirect(URL::query(array('msg' => "nothing found")));
        }

        $result = $results[$id];
        $session->delete('seachResults');

        $parse = new NameParser($result['nzbname']);
        $parsed = $parse->parse();
        $name = sprintf('%s S%02dE%02d', $parsed['name'], $parsed['season'], $parsed['episode']);

        $config = Kohana::config('default.default');
        $sab = new Sabnzbd(Kohana::config('default.Sabnzbd'));
        $matrix = new NzbMatrix($config['NzbMatrix_api_key']);
        $sab->sendNzb($matrix->buildDownloadUrl($id), $name);

        $d = ORM::factory('download');
        $d->episode_id = $result['episode_id'];
        $d->search = $name;
        $d->found = $result['nzbname'];
        $d->save();

        $this->request->redirect(URL::query(array('msg' => "Downloading $name")));
    }

    public function action_listAll() {
        try {
            $sab = new Sabnzbd_Queue(Kohana::config('default.Sabnzbd'));
        } catch (RuntimeException $e) {
            Kohana::exception_handler($e);
            return;
        }

        $history = $sab->getHistory();
        
        Head::instance()->set_title('Visa alla nerladdningar');
        $menu = new View('menu');
        $xhtml = Xhtml::instance('download/listAll');

        $xhtml->body->set('menu', $menu)
            ->set('history', $history);

        $this->request->response = $xhtml;
    }
}
?>
         