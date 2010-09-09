<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Movie_Download extends Controller_Movie_Page {

    public function action_movie($id) {
        $this->auto_render = false;
        $movie = ORM::factory('movie', $id);

//        $search = (is_null($movie->alternative_name)) ? $movie->name : $movie->alternative_name;
        $search = $movie->name;

        $config = Kohana::config('default');
        if ($config->default['useNzbSite'] == 'nzbs') {
            $nzbs = new Nzbs($config->nzbs, Nzbs::matrixNum2Nzbs($movie->matrix_cat));
            $xml = $nzbs->search($search);
            if (!$this->handleNZBsResults($xml, $search, $movie)) {
                MsgFlash::set("Nothing found \"$search\"");
                $this->request->redirect("movie/list");
                return;
            } else {
                MsgFlash::set("Download: " . $search);
                $this->request->redirect('movie/list');
                return;
            }

        }

        if ($config->default['useNzbSite'] == 'both') {
            $nzbs = new Nzbs($config->nzbs);
            $xml = $nzbs->search($search, Nzbs::matrixNum2Nzbs($movie->matrix_cat));
            if ($this->handleNZBsResults($xml, $search, $movie)) {
                MsgFlash::set("Download: " . $search);
                $this->request->redirect('movie/list');
                return;
            }
        }


        $matrix = new NzbMatrix(Kohana::config('default.default'));
        $results = $matrix->search($search, $movie->matrix_cat);
        

        if (isset($results[0]['error']) or is_numeric($results)) {
            if (is_numeric($results)) {
                if ($results == 404) {
                    if ($config->default['useNzbSite'] == 'both') {
                        $nzbs = new Nzbs($config->nzbs);

                        $searchAlt = (is_null($movie->alternative_name)) ? $movie->original_name : $movie->alternative_name;

                        $xml = $nzbs->search($searchAlt, Nzbs::matrixNum2Nzbs($movie->matrix_cat));
                        if (!$this->handleNZBsResults($xml, $search, $movie)) {
                            MsgFlash::set("Nothing found \"$search\"");
                            $this->request->redirect("movie/list");
                            return;
                        } else {
                            MsgFlash::set("Download: " . $search);
                            $this->request->redirect('movie/list');
                            return;
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
            $this->request->redirect("movie/list");
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
                MsgFlash::set("Download: " . $result['nzbname']);
                $this->request->redirect("movie/list");
                return;
            }
        }

        MsgFlash::set("Nothing found \"$search\"");
        $this->request->redirect("movie/list");
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
}

?>
