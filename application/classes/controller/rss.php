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

        foreach ($series as $ep) {
            if ($rss->count_all() >= $config->rss['numberOfResults']) {
                break;
            }
            if ($ep->season > 0) {
                $search = Helper_Search::searchName(Helper_Search::escapeSeriesName($ep->series_name), $ep->season, $ep->episode);




//                echo '****** NEW *******';
//                var_dump($search);




                if (!$rss->alreadySaved($search)) {
                    if ($config->default['useNzbSite'] == 'both') {
                        $response = trim(Request::factory('nzbs/oneResult/'.$ep->episode_id)->execute()->response);

                        if ($response == 'true') {
                            continue;
                        }
                    }

                    $result = $matrix->search($search, $ep->matrix_cat);

                    if (isset($result[0]['error']) or is_numeric($result)) {



//                        echo '****** ERROR *******';
//                        var_dump($result);



                        if (is_numeric($result)) {
                            $msg = Helper::getHttpCodeMessage($result);
                            if ($config->default['useNzbSite'] == 'nzbMatrix') {
                                $this->request->response = $msg;
                                return;
                            }
                        } else if (preg_match('#^(.*)_(?P<num>\d{1,3})$#', $result[0]['error'], $matches)) {
                            $msg = sprintf(__('please_wait_x'), $matches['num']);
                            sleep($matches['num']);
                        } else if ('nothing_found' == $result[0]['error']) {
                            sleep(1);
                            $search = sprintf('%s %02dx%02d', Helper_Search::escapeSeriesName($ep->series_name), $ep->season, $ep->episode);
                            $result = $matrix->search($search, $ep->matrix_cat);


//                            var_dump($search);
//                            var_dump($result);


                            if (isset($result[0]['error']) && 'nothing_found' == $result[0]['error']) {
                                $name = preg_replace('/[0-9]/', '', Helper_Search::escapeSeriesName($ep->series_name));
                                $name = rtrim($name);
                                $search = sprintf('%s %dx%02d', $name, $ep->season, $ep->episode);
                                unset ($name);

                                sleep(1);
                                $result = $matrix->search($search, $ep->matrix_cat);

//                                var_dump($search);
//                                var_dump($result);
//                                exit;

                                
                                if (isset($result[0]['error']) && 'nothing_found' == $result[0]['error']) {
                                    Request::factory('nzbindex/fillOneRss/' . $ep->episode_id)->execute()->response;
                                    continue;
                                } else {
                                    $this->handleResult($search, $result, $ep, true);
                                    continue;
                                }
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

                    $this->handleResult($search, $result, $ep);




//                    echo '******* Result *******';
//                    var_dump($result);




                    sleep(3);
                }
            }
        }

        $rssCount = $rss->count_all();
        if ($rssCount < $config->rss['numberOfResults']) {
            $this->request->response .= Request::factory('nzbindex/fillRss')->execute()->response;
            return;
        }

        $this->setRssSubFile();

        $this->request->response .= __('Updated');
    }

    protected function setRssSubFile() {
        $filename = APPPATH.'cache/' . md5('subtitles').'.sub';
        $rss = ORM::factory('rss');
        $series = ORM::factory('series');

        $lang = Kohana::config('subtitles.lang');
        $result = array();
        foreach ($rss->find_all() as $row) {
            $sub = Subtitles::facory($row->guid, $lang);
            if (count($sub) == 1) {
                $parse = new NameParser($row->title);
                $parsed = $parse->parse();
                $ser = $series->where('series_name', '=', $parsed['name'])->find()->episodes
                        ->where('episode', '=', $parsed['episode'])
                        ->and_where('season', '=', $parsed['season'])
                        ->find();

    //            $ser = $series->where('series_name', '=', str_replace('.', ' ', $parsed['name']))->find();
                $result[$ser->id] = array('guid' => $row->guid, 'file' => $sub->file, 'title' => $row->title);
            }
        }

        if (count($result) > 0) {
            $data = serialize($result);
            file_put_contents($filename, $data);
        }
    }


    protected function handleResult($search, $result, $ep, $escapeNum = false) {
        foreach ($result as $res) {
            $rss = ORM::factory('rss');

            if (!isset($res['nzbname'])) {
                Kohana::$log->add(Kohana::ERROR, "Undefined index 'nzbname' for search: $search \n Result array: " . var_export($res, true));
                continue;
            }

            $parse = new NameParser($res['nzbname']);
            $parsed = $parse->parse();

            $seriesName = Helper_Search::escapeSeriesName($ep->series_name);

            if ($escapeNum) {
                $seriesName = preg_replace('/[0-9]/', '', $seriesName);
                $seriesName = rtrim($seriesName);
            }

            if (sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
                sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
                Helper_Search::escapeSeriesName(strtolower($parsed['name'])) == strtolower($seriesName) &&
                $ep->matrix_cat == NzbMatrix::catStr2num($res['category'])) {
                if (!$rss->alreadySaved($search)) {
                    $rss->title = sprintf("%s S%02dE%02d", $ep->series_name, $ep->season, $ep->episode);
                    //$rss->guid = 'http://nzbmatrix.com/' . $res['link'];
                    $rss->guid = $res['nzbname'];
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
                        return true;
                    }
                }
            }
        }

        return false;
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
