<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nzbs extends Controller {

    public function action_index() {
        $config = Kohana::config('default.nzbs');
        $nzbs = new Nzbs($config);
//        $xml = $nzbs->search('Top Gear S15E04');
        $xml = $nzbs->search('Entourage S07E03');
//        $xml = $nzbs->search('Star.Trek.Voyager.s01e01');

        var_dump($xml);

        foreach($xml->channel->item as $item) {
            $parse = new NameParser((string) $item->title);
            $parsed = $parse->parse();
            var_dump($parsed);
            
//            $namespaces = $item->getNamespaces(true);
//            $item->registerXPathNamespace('report', $namespaces['report']);
            $result = $item->xpath('report:size');

            var_dump($result);
//            var_dump($namespaces);
            var_dump($item);
        }
    }

    public function action_fillRss() {
        set_time_limit(0);
        $config = Kohana::config('default');
        $rss = ORM::factory('rss');

        $rss->truncate();

        $series = Model_SortFirstAired::getSeries();

        $nzbs = new Nzbs($config->nzbs);
        foreach ($series as $ep) {
            if ($rss->count_all() >= $config->rss['numberOfResults']) {
                break;
            }
            //if (strtotime($ep->first_aired) < strtotime($config->rss['howOld']) && $ep->season > 0) {
            if ($ep->season > 0) {
                $search = sprintf('%s S%02dE%02d', $ep->series_name, $ep->season, $ep->episode);

                $search = Helper_Search::escapeSeriesName($search);

                if (!$rss->alreadySaved($search)) {
                    $xml = $nzbs->search($search, Nzbs::matrixNum2Nzbs($series->matrix_cat));

                    $this->handleResults($search, $xml, $ep);
                    sleep(10);
                }
            }
        }

        $this->request->response = __('Updated');
    }

    public function action_oneResult($id) {
        set_time_limit(0);
        $config = Kohana::config('default');
        $rss = ORM::factory('rss');
        
        $ep = ORM::factory('episode', array('id' => $id));
        $series = $ep->getSeriesInfo();

        $search = sprintf('%s S%02dE%02d', $series->series_name, $ep->season, $ep->episode);

        $search = Helper_Search::escapeSeriesName($search);

        $nzbs = new Nzbs($config->nzbs);
        $xml = $nzbs->search($search, Nzbs::matrixNum2Nzbs($series->matrix_cat));

        $std = new stdClass();
        $std->season = $ep->season;
        $std->episode = $ep->episode;
        $std->series_name = $series->series_name;
        $std->matrix_cat = $series->matrix_cat;
        if ($this->handleResults($search, $xml, $std)) {
            $this->request->response = 'true';
        } else {
            $this->request->response = 'false';
        }
        sleep(3);
    }

    protected function handleResults($search, $xml, $ep) {
        foreach($xml->channel->item as $item) {
            $rss = ORM::factory('rss');
            $parse = new NameParser((string) $item->title);
            $parsed = $parse->parse();

            $parsed['name'] = str_replace('.', ' ', $parsed['name']);

            $seriesName = Helper_Search::escapeSeriesName($ep->series_name);

            if (sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
                sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
                strtolower($parsed['name']) == strtolower($seriesName) &&
                $ep->matrix_cat == Nzbs::cat2MatrixNum((string) $item->category) &&
                !$rss->alreadySaved((string) $item->title)) {
                
                //$rss->title = (string) $item->title;
                $rss->title = $search;
                $rss->guid = (string) $item->link;
                $rss->link = (string) $item->link;
                $rss->description = (string) $item->description;
                $rss->category = $item->category;
                $rss->pubDate = (string) $item->pubDate;
                $rss->enclosure = serialize(array(
                            'url' => (string) $item->link,
                            'length' => round((int) $item->xpath('report:size')),
                            'type' => (string) "text/xml"
                    ));

                $rss->save();
                return true;
            }
        }
        return false;
    }
    
}

?>
