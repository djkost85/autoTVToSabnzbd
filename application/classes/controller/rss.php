<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Rss extends Controller {

    public function action_index() {
        $config = Kohana::config('default.rss');
        $info = array(
            'title' => 'AutoTvToSab RSS ',// . Request::factory('rss/update')->execute()->response,
            'link' => URL::base(true, true),
            'description' => sprintf('AutoTvToSab shows the %d last aired episodes', $config['numberOfResults']),
        );

        $items = array();
        foreach (ORM::factory('rss')->find_all() as $rss) {
            $item = array();
            $item['title'] = $rss->title;
            $item['link'] = htmlspecialchars($rss->link);
            $item['guid'] = htmlspecialchars($rss->guid);
            $item['description'] = $rss->description;
            $item['pubDate'] = $rss->pubDate;
            $item['category'] = $rss->category;
            $item['enclosure'] = unserialize($rss->enclosure);

            $items[] = $item;
        }

        $this->request->headers['Content-Type'] = 'application/xml; charset=UTF-8';
        $this->request->response = Rss::create($info, $items)->__toString();
    }

    public function action_update() {
        $config = Kohana::config('default');
        $rss = ORM::factory('rss');

        ignore_user_abort(true);
        set_time_limit(0);

        if ($config->default['useNzbSite'] == 'nzbs' && !empty($config->nzbs['queryString'])) {
            $this->request->response = Request::factory('nzbs/fillRss')->execute()->response;
            return;
        }

        $rss->truncate();

        $matrix = new NzbMatrix_Rss($config->default);
        $series = Model_SortFirstAired::getSeries();

        $i = 0;
        foreach ($series as $ep) {
            if ($rss->count_all() >= $config->rss['numberOfResults']) {
                break;
            }
            if ($ep->season > 0) {
                $search = sprintf('%s S%02dE%02d', $ep->series_name, $ep->season, $ep->episode);

                if (!$rss->alreadySaved($search)) {
                    if ($config->default['useNzbSite'] == 'both') {
                        $response = trim(Request::factory('nzbs/oneResult/'.$ep->episode_id)->execute()->response);

                        if ($response == 'true') {
                            continue;
                        }
                    }

                    $result = $matrix->search($search, $ep->matrix_cat);

                    if (isset($result[0]['error']) or is_numeric($result)) {
                        if (is_numeric($result)) {
                            $msg = Helper::getHttpCodeMessage($result);
                            if ($config->default['useNzbSite'] == 'nzbMatrix') {
                                $this->request->response = $msg;
                                return;
                            }
                        } else if (preg_match('#^(.*)_(?P<num>\d{1,2})$#', $result[0]['error'], $matches)) {
                            $msg = sprintf(__('please_wait_x'), $matches['num']);
                            sleep($matches['num']);
                        } else if ('nothing_found' == $result[0]['error']) {
                            $search = sprintf('%s %02dx%02d', $ep->series_name, $ep->season, $ep->episode);
                            $result = $matrix->search($search, $ep->matrix_cat);
                            if (isset($result[0]['error']) && 'nothing_found' == $result[0]['error']) {
                                continue;
                            }
                        } else {
                            $this->request->response .= __($result[0]['error']);
                            continue;
                        }

                        if (isset($msg)) {
                            $this->request->response .= $msg;
                            unset($msg);
                        }

                    }

                    $this->handleResult($search, $result, $ep, $i);
                    sleep(3);
                }
            }
        }

        $rssCount = $rss->count_all();
        if ($rssCount < $config->rss['numberOfResults']) {
            $this->request->response .= Request::factory('nzbindex/fillRss')->execute()->response;
            return;
        }

        $this->request->response .= __('Updated');
    }

//    public function action_update() {
//        $config = Kohana::config('default');
//
//        $rss = ORM::factory('rss');
////        if ($this->request != Request::instance()) {
////            $expr = 'DATE_SUB(NOW(),INTERVAL ' . Inflector::singular(ltrim($config->rss['howOld'], '-')) . ')';
////
////            $result = $rss->where(DB::expr($expr), '>=', DB::expr('updated'));
////
////            if ($result->count_all() <= 0) {
////                if ($rss->count_all() == $config->rss['numberOfResults']) {
////                    $this->request->response = __('Already updated');
////                    return;
////                }
////            }
////        }
//        ignore_user_abort(true);
//        set_time_limit(0);
//
//        if ($config->default['useNzbSite'] == 'nzbs' && !empty($config->nzbs['queryString'])) {
//            $this->request->response = Request::factory('nzbs/fillRss')->execute()->response;
//            return;
//        }
//
////        if ($config->default['useNzbSite'] == 'nzbMatrix') {
//            $rss->truncate();
////        }
//
//        $matrix = new NzbMatrix_Rss($config->default);
//        $series = Model_SortFirstAired::getSeries();
//
////        echo '<pre>';
//
//        $i = 0;
//        $secToSleep = 10;
//        foreach ($series as $ep) {
////            if (strtotime($ep->first_aired) < strtotime($config->rss['howOld']) && $ep->season > 0) {
//            if ($ep->season > 0) {
//                $search = sprintf('%s S%02dE%02d', $ep->series_name, $ep->season, $ep->episode);
////                var_dump($rss->alreadySaved($search));
////                return;
//                if (!$rss->alreadySaved($search)) {
//                    $result = $matrix->search($search, $ep->matrix_cat);
//
//                    # If NzbMatrix is not alive use NzbIndex instead
//                    if (is_numeric($result)) {
//                        if ($config->default['useNzbSite'] == 'both' && !empty($config->nzbs['queryString'])) {
//                            $this->request->response = Request::factory('nzbs/fillRss')->execute()->response;
//                            return;
//                            //$this->request->redirect('nzbs/fillRss');
//                        } else if ($config->default['useNzbSite'] == 'nzbMatrix') {
//                            $this->request->response = Request::factory('nzbindex/fillRss')->execute()->response;
//                            return;
//                            //$this->request->redirect('nzbindex/fillRss');
//                        } else {
//                            $this->request->response = Request::factory('nzbindex/fillRss')->execute()->response;
//                            return;
//                            //$this->request->redirect('nzbindex/fillRss');
//                        }
//
//
//                        break;
//                    }
//
//                    $time = time();
//
////                    echo("/******** New Search *********/ \n");
////                    var_dump($search);
//
////                    var_dump($result);
////                    var_dump($ep);
////                    break;
//
//                    if (isset($result[0]['error'])) {
//
////                        echo("/******** ERROR *********/ \n");
////                        var_dump($result[0]['error']);
////                        echo("/******** END ERROR *********/ \n");
//
//                        if (preg_match('#^(.*)_(?P<num>\d{1,2})$#', $result[0]['error'], $matches)) {
//                            $secToSleep = $matches['num'];
//                        } else {
//                            $search = sprintf('%s %02dx%02d', $ep->series_name, $ep->season, $ep->episode);
//                        }
//
//                        sleep($secToSleep + 3);
//                        $result = $matrix->search($search, $ep->matrix_cat);
//                        $time = time();
//
////                        echo("/******** New Search *********/ \n");
////                        var_dump($search);
//
//                        if (isset($result[0]['error'])) {
//
////                            echo("/******** ERROR *********/ \n");
////                            var_dump($result[0]['error']);
////                            echo("/******** END ERROR Continue!!!! *********/ \n");
//                            if ('nothing_found' == $result[0]['error']) {
//                                continue;
//                            } else {
//                                break;
//                            }
//                        }
//                    }
//
//                    $this->handleResult($search, $result, $ep, $i);
//                    if ($i >= $config->rss['numberOfResults']) {
////                    if ($rss->count_all() >= $config->rss['numberOfResults']) {
//                        break;
//                    }
//
//                    //$seconds = $secToSleep - (time() - $time);
//                    $seconds = $secToSleep;
//                    sleep($seconds);
//
////                    echo("/******** Search END *********/ \n");
//                }
//            }
//        }
//
////        Cache::instance('default')->delete('series');
////        Cache::instance('default')->delete_all();
//
////        if ($rss->count_all() <= $config->rss['numberOfResults']) {
////            $this->request->redirect('nzbindex/fillRss');
////            exit;
////        }
//
//        $rssCount = $rss->count_all();
//        if ($rssCount < $config->rss['numberOfResults'] && $config->default['useNzbSite'] == 'both' && !empty($config->nzbs['queryString'])) {
//            $this->request->response = Request::factory('nzbs/fillRss')->execute()->response;
//            return;
//        } else if ($rssCount < $config->rss['numberOfResults']) {
//            $this->request->response = Request::factory('nzbindex/fillRss')->execute()->response;
//            return;
//        }
//
//        $this->request->response = __('Updated');
//    }
    
    protected function handleResult($search, $result, $ep, &$i) {
        foreach ($result as $res) {
            $rss = ORM::factory('rss');

            $parse = new NameParser($res['nzbname']);
            $parsed = $parse->parse();

            if (sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
                sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
                strtolower($parsed['name']) == strtolower($ep->series_name) &&
                $ep->matrix_cat == NzbMatrix::catStr2num($res['category'])) {
                if (!$rss->alreadySaved($search)) {
                    $rss->title = $search;
                    $rss->guid = 'http://nzbmatrix.com/' . $res['link'];
                    $rss->link = 'http://nzbmatrix.com/' . $res['link'];
                    $rss->description = $this->description($res['nzbid'], $res['nzbname'], $res['category'], $res['size'], $res['index_date'], $res['group']);
                    $rss->category = $res['category'];
                    $rss->pubDate = date(DATE_RSS, strtotime($res['usenet_date']));
                    $rss->enclosure = serialize(array(
                                'url' => 'http://nzbmatrix.com/' . $res['link'],
                                'length' => round($res['size']),
                                'type' => 'application/x-nzb')
                            );

                    if ($rss->save()) {
                        $i++;
                    }
                }
            }
        }

        return true;
    }


    /**
     *
     * @param integer $id
     * @param string $name
     * @param string $cat
     * @param string $size
     * @param string $added
     * @param string $group
     * @return string
     * <b>Name:</b> Burn Notice S04E06 HDTV XviD XII<br />
     * <b>Category:</b> TV: Divx/Xvid<br />
     * <b>Size:</b> 395.72 MB<br />
     * <b>Added:</b> 2010-07-16 05:37:24<br />
     * <b>Group:</b> alt.binaries.multimedia <BR />
     * <b>NFO:</b> <a href="http://nzbmatrix.com/viewnfo.php?id=691833">View NFO</a>
     */
    protected function description($id, $name, $cat, $size, $added, $group) {
        $size = Text::bytes($size, 'MB');
        $html = "";
        $html .= "<b>Name:</b> $name <br />";
        $html .= "<b>Category:</b> $cat <br />";
        $html .= "<b>Size:</b> $size <br />";
        $html .= "<b>Added:</b> $added <br />";
        $html .= "<b>Group:</b> $group <br />";
        $html .= "<b>NFO:</b> <a href=\"http://nzbmatrix.com/viewnfo.php?id=$id\">View NFO</a>";
        return $html;
    }

}
?>
