<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of download
 *
 * @author Morre95
 */
class Controller_Download extends Controller_Page {

    public function action_episode($id) {
        $this->auto_render = false;
        
        $ep = ORM::factory('episode', array('id' => $id));
        $series = $ep->getSeriesInfo();
        $search = sprintf('%s S%02dE%02d', $series->series_name, $ep->season, $ep->episode);

        $config = Kohana::config('default');
        if ($config->default['useNzbSite'] == 'nzbs') {
            $nzbs = new Nzbs($config->nzbs);
            $xml = $nzbs->search($search);
            if (!$this->handleNZBsResults($xml, $search, $ep, $series)) {
                MsgFlash::set("Nothing found \"$search\"");
//                $this->request->redirect("episodes/$series->id/" . URL::query(array('msg' => "Nothing found \"$search\"")));
                $this->request->redirect("episodes/$series->id/");
                return;
            } else {
                MsgFlash::set("Download: " . $search);
                $this->request->redirect('');
            }
            
        } else {
            $matrix = new NzbMatrix(Kohana::config('default.default'));
            $results = $matrix->search($search, $series->matrix_cat);
        }

        if (isset($results[0]['error']) or is_numeric($results)) {
            if (is_numeric($results)) {
                if ($results == 404) {
                    if ($config->default['useNzbSite'] == 'both') {
                        $nzbs = new Nzbs($config->nzbs);
                        $xml = $nzbs->search($search);
                        if (!$this->handleNZBsResults($xml, $search, $ep, $series)) {
                            MsgFlash::set("Nothing found \"$search\"");
//                            $this->request->redirect("episodes/$series->id/" . URL::query(array('msg' => "nothing found [$search]")));
                            $this->request->redirect("episodes/$series->id/");
                            return;
                        } else {
                            MsgFlash::set("Download: " . $search);
                            $this->request->redirect('');
                        }
                    }
                }
                $msg = Helper::getHttpCodeMessage($results);
            } else if (preg_match('#^(.*)_(?P<num>\d{1,2})$#', $results[0]['error'], $matches)) {
                $msg = sprintf(__('please_wait_x'), $matches['num']);
            } else {
                $msg = __($results[0]['error']);
            }

            MsgFlash::set("Mzb Matrix error: $msg");
//            $this->request->redirect("episodes/$series->id/" . URL::query(array('msg' => "Mzb Matrix error: $msg")));
            $this->request->redirect("episodes/$series->id/");
        }

        $sab = new Sabnzbd(Kohana::config('default.Sabnzbd'));
        $searchResult = array();
        foreach ($results as $result) {
            $parse = new NameParser($result['nzbname']);
            $parsed = $parse->parse();
            $isDownload = $sab->isDownloaded($result['nzbname']);

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

                MsgFlash::set("Download: " . $search);
//                $this->request->redirect(URL::query(array('msg' => "Download: " . $search)));
                $this->request->redirect('');
                return;
            }

            $session = Session::instance();
            $session->set('seachResults', $searchResult);
            $this->request->redirect("download/no_match/$ep->id");
            return;
        }

        MsgFlash::set("Nothing found \"$search\"");
//        $this->request->redirect("episodes/$series->id/" . URL::query(array('msg' => "nothing found [$search]")));
        $this->request->redirect("episodes/$series->id/");
    }

    protected function handleNZBsResults($xml, $search, $ep, $series) {
        $sab = new Sabnzbd(Kohana::config('default.Sabnzbd'));
        if (isset($xml->channel->item)) {
            foreach($xml->channel->item as $item) {
                $parse = new NameParser((string) $item->title);
                $parsed = $parse->parse();

                $parsed['name'] = str_replace('.', ' ', $parsed['name']);

                if (sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
                    sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
                    strtolower($parsed['name']) == strtolower($series->series_name) &&
                    $series->matrix_cat == Nzbs::cat2MatrixNum((string) $item->category)) {

                    $sab->sendNzb((string) $item->link, (string) $item->title);

//                    MsgFlash::set("Download: " . $search);
//                    $this->request->redirect('');
                    return true;
                }

            }
        }

        return false;
    }

    public function action_no_match($id) {
        $ep = ORM::factory('episode', array('id' => $id));
        $series = $ep->getSeriesInfo();

        $session = Session::instance();
        $results = $session->get('seachResults');

        if (!$results) {
            MsgFlash::set('Nothing found');
            $this->request->redirect('');
            exit;
        }

        $this->template->title = __('Click to download') . '?';

        $xhtml = View::factory('download/no_match');
        $xhtml->set('title', __('Click to download'))
                ->set('results', $results)
                ->set('series', $series)
                ->set('ep', $ep);

        $this->template->content = $xhtml;
    }

    public function action_doDownload($id) {
        $this->auto_render = false;
        
        $session = Session::instance();
        $results = $session->get('seachResults');

        if (!isset($results[$id])) {
            MsgFlash::set('Nothing found');
            $this->request->redirect('');
        }

        $result = $results[$id];
        $session->delete('seachResults');

        $parse = new NameParser($result['nzbname']);
        $parsed = $parse->parse();
        $name = sprintf('%s S%02dE%02d', $parsed['name'], $parsed['season'], $parsed['episode']);

        $config = Kohana::config('default.default');
        $sab = new Sabnzbd(Kohana::config('default.Sabnzbd'));
        $matrix = new NzbMatrix($config);
        $sab->sendNzb($matrix->buildDownloadUrl($id), $name);

        $d = ORM::factory('download');
        $d->episode_id = $result['episode_id'];
        $d->search = $name;
        $d->found = $result['nzbname'];
        $d->save();

        MsgFlash::set("Downloading $name");
        $this->request->redirect('');
//        $this->request->redirect(URL::query(array('msg' => "Downloading $name")));
    }

    public function action_listAll() {
        try {
            $sab = new Sabnzbd_History(Kohana::config('default.Sabnzbd'));
        } catch (RuntimeException $e) {
            Kohana::exception_handler($e);
            return;
        }

        $history = $sab->getHistory();

        $this->template->title = __('Show all downloads');
        $xhtml = View::factory('download/listAll');

        $xhtml->set('history', $history);

        $this->template->content = $xhtml;
    }

    public function action_multiEp() {
        ignore_user_abort(true);
        set_time_limit(0);
        $this->auto_render = false;

        if (isset($_GET['episodes'])) {
            $resultMsg = array();
            $config = Kohana::config('default');
            foreach ($_GET['episodes'] as $id) {
//                $downloadUrl = URL::site(Route::get('download')->uri(array('id' => $id)), true);
//                Helper::backgroundExec($downloadUrl);

                $ep = ORM::factory('episode', array('id' => $id));
                $series = $ep->getSeriesInfo();
                $search = sprintf('%s S%02dE%02d', $series->series_name, $ep->season, $ep->episode);

                if ($config->default['useNzbSite'] == 'nzbs') {
                    $nzbs = new Nzbs($config->nzbs);
                    $xml = $nzbs->search($search);
                    if (!$this->handleNZBsResults($xml, $search, $ep, $series)) {
                        $search = 'Found no ' . $search;
                    }
                } else {

                    if ($config->default['useNzbSite'] == 'both') {
                        $nzbs = new Nzbs($config->nzbs);
                        $xml = $nzbs->search($search);
                        if ($this->handleNZBsResults($xml, $search, $ep, $series)) {
                            continue;
                        }
                    }

                    $matrix = new NzbMatrix(Kohana::config('default.default'));
                    $results = $matrix->search($search, $series->matrix_cat);

                    if (isset($results[0]['error']) or is_numeric($results)) {
                        if (is_numeric($results)) {
                            $msg = Helper::getHttpCodeMessage($results);
                        } else if (preg_match('#^(.*)_(?P<num>\d{1,2})$#', $results[0]['error'], $matches)) {
                            $msg = sprintf(__('please_wait_x'), $matches['num']);
                        } else {
                            $msg = __($results[0]['error']);
                        }
                        $search = $msg . ' ' . $search;
                    } else {
                        try {
                            $sab = new Sabnzbd(Kohana::config('default.Sabnzbd'));
                        } catch (RuntimeException $e) {
                            Kohana::exception_handler($e);
                            return;
                        }

                        foreach ($results as $result) {
                            $parse = new NameParser($result['nzbname']);
                            $parsed = $parse->parse();
                            $isDownload = $sab->isDownloaded($result['nzbname']);
                            if (
                                    sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
                                    sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
                                    strtolower($parsed['name']) == strtolower($series->series_name) &&
                                    NzbMatrix::catStr2num($result['category']) == $series->matrix_cat &&
                                    !$isDownload
                            ) {

                                $sab->sendNzb($matrix->buildDownloadUrl($result['nzbid']), $search);

                                $d = ORM::factory('download');
                                $d->episode_id = $ep->id;
                                $d->search = $search;
                                $d->found = $result['nzbname'];
                                $d->save();
                                break;
                            }
                        }
                    }
                }

                $resultMsg[] = $search;
                sleep(10);
            }
            MsgFlash::set("Trying to download: " . implode(', ', $resultMsg));
            $this->request->redirect("episodes/$series->id/");
            return;
        }

        MsgFlash::set("You have to tick the episodes you want to download");
        $this->request->redirect("");
    }

//    public function action_multiEp() {
//        $this->auto_render = false;
//        ignore_user_abort(true);
//        set_time_limit(0);
//
//        //http://dev/autoTvToSab/index.php/download/episode/6659
//
//        //Request::factory('download/episode/6659')->execute()->response;
//
//        if (isset($_GET['episodes'])) {
//            $downloadUrl = URL::site('download/doMultiEp/?' . http_build_query($_GET), true);
//            Helper::backgroundExec($downloadUrl);
//            $resultMsg = array();
//            foreach ($_GET['episodes'] as $id) {
////                $downloadUrl = URL::site("download/oneEp/$id", true);
////                Helper::backgroundExec($downloadUrl);
////                return;
////                Request::factory("download/oneEp/$id")->execute()->response;
////                var_dump($downloadUrl);
//
////                $downloadUrl = URL::site(Route::get('download')->uri(array('id' => $id)), true);
////                Helper::backgroundExec($downloadUrl);
////                sleep(10);
//
//                $ep = ORM::factory('episode', array('id' => $id));
//                $series = $ep->getSeriesInfo();
//                $search = sprintf('%s S%02dE%02d', $series->series_name, $ep->season, $ep->episode);
//
//                $resultMsg[] = $search;
//            }
//
////            MsgFlash::set("Trying to download: " . implode(', ', $resultMsg));
////            $this->request->redirect("episodes/$series->id/");
//            return;
//        }
//        MsgFlash::set("You have to tick the episodes you want to download");
//        $this->request->redirect("");
//    }
//
//    public function action_oneEp($id) {
//        $this->auto_render = false;
//        ignore_user_abort(true);
//        set_time_limit(0);
//
//        $ep = ORM::factory('episode', array('id' => $id));
//        $series = $ep->getSeriesInfo();
//        $search = sprintf('%s S%02dE%02d', $series->series_name, $ep->season, $ep->episode);
//
//        $results = array();
//
//        $config = Kohana::config('default');
//        if ($config->default['useNzbSite'] == 'nzbs') {
//            $nzbs = new Nzbs($config->nzbs);
//            $xml = $nzbs->search($search);
//            if (!$this->handleNZBsResults($xml, $search, $ep, $series)) {
//                MsgFlash::set("Nothing found \"$search\"");
//                var_dump("Nothing found \"$search\"");
////                $this->request->redirect("episodes/$series->id/");
//                return;
//            }
//
//        } else {
//            $matrix = new NzbMatrix(Kohana::config('default.default'));
//            $results = $matrix->search($search, $series->matrix_cat);
//        }
//
//        if (isset($results[0]['error']) or is_numeric($results)) {
//            if (is_numeric($results)) {
//                if ($results == 404) {
//                    if ($config->default['useNzbSite'] == 'both') {
//                        $nzbs = new Nzbs($config->nzbs);
//                        $xml = $nzbs->search($search);
//                        if (!$this->handleNZBsResults($xml, $search, $ep, $series)) {
//                            MsgFlash::set("Nothing found \"$search\"");
//                            var_dump("Nothing found \"$search\"");
////                            $this->request->redirect("episodes/$series->id/");
//                            return;
//                        }
//                    }
//                }
//                $msg = Helper::getHttpCodeMessage($results);
//            } else if (preg_match('#^(.*)_(?P<num>\d{1,2})$#', $results[0]['error'], $matches)) {
//                $msg = sprintf(__('please_wait_x'), $matches['num']);
//            } else {
//                $msg = __($results[0]['error']);
//            }
//
//            MsgFlash::set("Mzb Matrix error: $msg");
//            var_dump("Mzb Matrix error: $msg");
////            $this->request->redirect("episodes/$series->id/");
//            return;
//        }
//
//        try {
//            $sab = new Sabnzbd_History(Kohana::config('default.Sabnzbd'));
//        } catch (RuntimeException $e) {
//            Kohana::exception_handler($e);
//            return;
//        }
//
//        $history = $sab->getHistory();
//
//        if (count($history->slots) > 0) {
//            sleep(10);
//        }
//
//        $searchResult = array();
//        foreach ($results as $result) {
//            $parse = new NameParser($result['nzbname']);
//            $parsed = $parse->parse();
//            $isDownload = $sab->isDownloaded($result['nzbname']);
//            if (
//                    sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
//                    sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
//                    strtolower($parsed['name']) == strtolower($series->series_name) &&
//                    NzbMatrix::catStr2num($result['category']) == $series->matrix_cat &&
//                    !$isDownload
//            ) {
//
//                $sab->sendNzb($matrix->buildDownloadUrl($result['nzbid']), $search);
//
//                $d = ORM::factory('download');
//                $d->episode_id = $result['episode_id'];
//                $d->search = $search;
//                $d->found = $result['nzbname'];
//                $d->save();
//                MsgFlash::set("Download: " . $search);
//                var_dump("Download: " . $search);
////                $this->request->redirect('');
//                return;
//            }
//        }
//
//        MsgFlash::set("Nothing found \"$search\"");
//        var_dump("Nothing found \"$search\"");
////        $this->request->redirect("episodes/$series->id/");
//    }

}
?>
         