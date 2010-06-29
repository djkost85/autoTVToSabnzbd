<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Rss extends Controller {

    public function action_index() {
        $config = Kohana::config('default.rss');
        $info = array(
            'title' => 'AutoTvToSab RSS ' . Request::factory('rss/update')->execute()->response,
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
//        var_dump($items);

        $this->request->headers['Content-Type'] = 'application/xml; charset=UTF-8';
        //var_dump(Rss::create($info, $items)->__toString());
        $this->request->response = Rss::create($info, $items)->__toString();
    }

    public function action_update() {
        $config = Kohana::config('default');

        $matrix = new NzbMatrix_Rss($config->default['NzbMatrix_api_key']);

        $series = Model_SortFirstAired::getSeries();
        $rss = ORM::factory('rss');
//        $expr = 'DATE_SUB(CURDATE(),INTERVAL ' . Inflector::singular(ltrim($config->rss['howOld'], '-')) . ')';
//        $expr = 'DATE_SUB(CURDATE(),INTERVAL ' . Inflector::singular($config->rss['howOld']) . ')';
//        $result = $rss->where(DB::expr($expr), '<=', DB::expr('updated'));
//        var_dump($result->count_all());
//        var_dump($result->last_query());
//        var_dump($rss->count_all());

        $expr = 'DATE_SUB(NOW(),INTERVAL ' . Inflector::singular(ltrim($config->rss['howOld'], '-')) . ')';
//        $expr = 'DATE_SUB(CURDATE(),INTERVAL ' . Inflector::singular($config->rss['howOld']) . ')';
        $result = $rss->where(DB::expr($expr), '>=', DB::expr('updated'));

        if ($result->count_all() <= 0) {
//            var_dump($result->last_query());;
            if ($rss->count_all() == $config->rss['numberOfResults']) {
                $this->request->response = __('Already updated');
                return;
            }
        }

        $rss->truncate();
        $i = 0;

        foreach ($series as $ep) {
            if (strtotime($ep->first_aired) < strtotime($config->rss['howOld']) && $ep->season > 0) {
                $search = sprintf('%s S%02dE%02d', $ep->series_name, $ep->season, $ep->episode);

                $rss = ORM::factory('rss');
                if (!$rss->alreadySaved($search)) {
                    $result = $matrix->search($search);
                    foreach ($result->item as $res) {
                        $parse = new NameParser((string) $res->title);
                        $parsed = $parse->parse();
                        if (sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
                            sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
                            strtolower($parsed['name']) == strtolower($ep->series_name) &&
                            $ep->matrix_cat == $res->categoryid) {

//                        var_dump($search);
//                        var_dump($res);
                            if (!$rss->alreadySaved($search)) {
                                $rss->title = (string) $res->title;
                                $rss->guid = (string) $res->guid;
                                $rss->link = (string) $res->link;
                                $rss->description = (string) $res->description;
                                $rss->category = (string) $res->category;
                                $rss->pubDate = date(DATE_RSS, strtotime($ep->first_aired));
                                $rss->enclosure = serialize(array(
                                            'url' => (string) $res->enclosure['url'],
                                            'length' => (string) $res->enclosure['length'],
                                            'type' => (string) $res->enclosure['type']));

                                $rss->save();
                                $i++;
                            }
                        }
                    }
                    if ($i >= $config->rss['numberOfResults']) {

                        break;
                    }
                }
            }
        }

        $this->request->response = __('Updated');
    }

}
?>
