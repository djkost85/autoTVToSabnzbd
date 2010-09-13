<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Movie_Download extends Controller_Movie_Page {

    public function action_movie($id) {
        $this->auto_render = false;
        $movie = ORM::factory('movie', $id);

//        $search = (is_null($movie->alternative_name)) ? $movie->name : $movie->alternative_name;
        $search = $movie->name;

        $isAjax = Session::instance()->get('ajax_no_rederect', FALSE);

        if ($isAjax) {
            $this->action_setToList($id);
            Session::instance()->delete('ajax_no_rederect');
        }

        $config = Kohana::config('default');
        if ($config->default['useNzbSite'] == 'nzbs') {
            $nzbs = new Nzbs($config->nzbs, Nzbs::matrixNum2Nzbs($movie->matrix_cat));
            $xml = $nzbs->search($search);
            if (!$this->handleNZBsResults($xml, $search, $movie)) {
                if (!$isAjax) {
                    Helper::backgroundExec(URL::site('movie/download/setToList/' . $movie->id, true));
                    MsgFlash::set("Nothing found \"$search\". Added to download queue list");
                    $this->request->redirect("movie/list");
                    return;
                }
            } else {
                $this->deleteFromList($id);
                if (!$isAjax) {
                    MsgFlash::set("Download: " . $search);
                    $this->request->redirect("movie/list");
                    return;
                }
            }

        }

        if ($config->default['useNzbSite'] == 'both') {
            $nzbs = new Nzbs($config->nzbs);
            $xml = $nzbs->search($search, Nzbs::matrixNum2Nzbs($movie->matrix_cat));
            if ($this->handleNZBsResults($xml, $search, $movie)) {
                $this->deleteFromList($id);
                if (!$isAjax) {
                    MsgFlash::set("Download: " . $search);
                    $this->request->redirect("movie/list");
                    return;
                }
            }
        }


        $matrix = new NzbMatrix(Kohana::config('default.default'));
        $results = $matrix->search($search, $movie->matrix_cat);
        

        if (isset($results[0]['error']) or is_numeric($results)) {
            $msg = "";
            if (is_numeric($results)) {
                if ($results == 404) {
                    if ($config->default['useNzbSite'] == 'both') {
                        $nzbs = new Nzbs($config->nzbs);

                        $searchAlt = (is_null($movie->alternative_name)) ? $movie->original_name : $movie->alternative_name;

                        $xml = $nzbs->search($searchAlt, Nzbs::matrixNum2Nzbs($movie->matrix_cat));
                        if (!$this->handleNZBsResults($xml, $search, $movie)) {
                            if (!$isAjax) {
                                Helper::backgroundExec(URL::site('movie/download/setToList/' . $movie->id, true));
                                MsgFlash::set("Nothing found \"$search\". Added to download queue list");
                                $this->request->redirect("movie/list");
                                return;
                            }
                        } else {
                            $this->deleteFromList($id);
                            if (!$isAjax) {
                                MsgFlash::set("Download: " . $search);
                                $this->request->redirect("movie/list");
                                return;
                            }
                        }
                    }
                }
                $msg = Helper::getHttpCodeMessage($results);
            } else if (preg_match('#^(.*)_(?P<num>\d{1,2})$#', $results[0]['error'], $matches)) {
                $msg = sprintf(__('please_wait_x'), $matches['num']);
            } else if ($results[0]['error'] == 'nothing_found') {
                MsgFlash::set(__("Nothing Found"));
                if (!$isAjax) {
                    Helper::backgroundExec(URL::site('movie/download/setToList/' . $movie->id, true));
                    $this->request->redirect("movie/list");
                    return;
                }
            } else {
                $msg = __($results[0]['error']);
            }

            MsgFlash::set("Mzb Matrix error: $msg");
            if (!$isAjax) {
                Helper::backgroundExec(URL::site('movie/download/setToList/' . $movie->id, true));
                $this->request->redirect("movie/list");
                return;
            }
        }

        $sab = new Sabnzbd(Kohana::config('default.Sabnzbd'));
        $searchResult = array();
        foreach ($results as $result) {
            $parse = new NameParser_Movie($result['nzbname']);
            $parsed = $parse->parse();

            $parsed['name'] = str_replace('.', ' ', $parsed['name']);
            if (strtolower($movie->name) == strtolower($parsed['name']) && NzbMatrix::catStr2num($result['category']) == $movie->matrix_cat) {
                $category = Kohana::config('movie.sabnzbd.category');
                $sab->sendNzb($matrix->buildDownloadUrl($result['nzbid']), $result['nzbname'], (!is_null($category)) ? $category : 'movies');

                $this->deleteFromList($id);
                if (!$isAjax) {
                    MsgFlash::set("Download: " . $result['nzbname']);
                    $this->request->redirect("movie/list");
                    return;
                }
            }
        }


        if (!$isAjax) {
            Helper::backgroundExec(URL::site('movie/download/setToList/' . $movie->id, true));
        }

        if (!$isAjax) {
            MsgFlash::set("Nothing found \"$search\". Added to download queue list");
            $this->request->redirect("movie/list");
            return;
        }
    }

    protected function deleteFromList($id) {
        $filename = APPPATH . 'cache/' . md5('download_list') . '.list';
        $data = array();
        if (is_readable($filename)) {
            $data = unserialize(file_get_contents($filename));
            if (isset ($data[$id])) {
                unset($data[$id]);
                file_put_contents($filename, serialize($data));
            }
        }
    }

    public function action_rmFromList($id) {
        $this->auto_render = false;
        $this->deleteFromList($id);
    }

    protected function handleNZBsResults($xml, $search, $movie) {
        $sab = new Sabnzbd(Kohana::config('default.Sabnzbd'));
        if (isset($xml->channel->item)) {
            foreach($xml->channel->item as $item) {
                $parse = new NameParser_Movie((string) $item->title);
                $parsed = $parse->parse();

                $parsed['name'] = str_replace('.', ' ', $parsed['name']);

                if (strtolower($parsed['name']) == strtolower($movie->name) &&
                    $movie->matrix_cat == Nzbs::cat2MatrixNum((string) $item->category)) {

                    $category = Kohana::config('movie.sabnzbd.category');
                    $sab->sendNzb((string) $item->link, (string) $item->title, (!is_null($category)) ? $category : 'movies');

                    return true;
                }

            }
        }
        return false;
    }

    public function action_setToList($id) {
        $this->auto_render = false;
        $movie = ORM::factory('movie', $id);

        if (!$movie->loaded()) {
            throw new RuntimeException('No movie with that id', 404);
        }
        
        $filename = APPPATH . 'cache/' . md5('download_list') . '.list';
        $data = array();
        if (is_readable($filename)) {
            $data = unserialize(file_get_contents($filename));
        }


        $data[$movie->id] = time();
//        $data[$movie->id] = date('Y-m-d H:i:s');

        file_put_contents($filename, serialize($data));
    }

    public function action_ajax_checkList() {
        $this->auto_render = false;
        
        $filename = APPPATH . 'cache/' . md5('download_list') . '.list';
        $data = array();
        if (is_readable($filename)) {
            $data = unserialize(file_get_contents($filename));
        } else {
            Kohana::$log->add(Kohana::INFO, "No File Found: [".__METHOD__."]");
        }

        if (empty ($data)) {
            $this->request->headers['Status'] = 404;
            $this->request->response = Helper::getHttpCodeMessage(404);
            Kohana::$log->add(Kohana::INFO, "No Data Found: [".__METHOD__."]");
            return;
        }

        Kohana::$log->add(Kohana::INFO, 'Loading... ' . var_export($data, true));

        $movie = ORM::factory('movie');

        foreach ($data as $id => $time) {
            if ((time() - $time) > 3600) {
                Kohana::$log->add(Kohana::INFO, 'Trying to download: ' . $movie->find($id)->name . "[".__METHOD__."]");
                $movie->clear();
                Request::factory('movie/download/movie/' . $id)->execute()->response;
            }
        }
    }

    public function action_ajax_movie($id) {
        Session::instance()->set('ajax_no_rederect', TRUE);
        $this->action_movie($id);
    }
}

?>
