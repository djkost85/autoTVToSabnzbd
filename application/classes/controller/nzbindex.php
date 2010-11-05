<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Nzbindex extends Controller {

    public function action_index() {
        var_dump(is_dir('G:\usenet\test'));
        $nzb = new Nzbindex();
//        $xml = $nzb->search('Top Gear S15E04');
//        $xml = $nzb->search('Top Gear 15x04');
//        $xml = $nzb->search('Entourage S07E03');
//        $xml = $nzb->search('The Ultimate Fighter S11E13');
//        $xml = $nzb->search('White Collar S02E02');
//        $xml = $nzb->search('Ice Road Truckers S04E06');
//        $xml = $nzb->search('True Blood S03E05');
//        $xml = $nzb->search('Family Guy S08E21');
//        $xml = $nzb->search('The Ultimate Fighter S11E13');
//        $xml = $nzb->search('Arga snickaren S03E11');
//        $xml = $nzb->search('Breaking Bad S03E13');
        $xml = $nzb->search('Stargate Universe S01E20');
//        $xml = $nzb->search('Glee S01E22');
//        var_dump($xml);
        foreach ($xml->channel->item as $item) {
            $parse = new NameParser_Nzbindex((string) $item->title);
            $parsed = $parse->parse();

            $filename = (string)$item->enclosure['url'];

//            var_dump($item);
            var_dump(basename($filename));
            var_dump($parsed);

            $name = sprintf('%s S%02dE%02d.nzb', $parsed['name'], $parsed['season'], $parsed['episode']);

            NzbFile::saveNzb($filename, 'G:\usenet\test');

            var_dump(NzbMatrix::determinCat((string) $item->title));
        }
    }

    public function action_fillRss() {
        set_time_limit(0);
        $config = Kohana::config('default');
        $rss = ORM::factory('rss');

        //$rss->truncate();

        $series = Model_SortFirstAired::getSeries();
        
        $nzb = new Nzbindex();
        foreach ($series as $ep) {
            if ($rss->count_all() >= $config->rss['numberOfResults']) {
                break;
            }
            //if (strtotime($ep->first_aired) < strtotime($config->rss['howOld']) && $ep->season > 0) {
            if ($ep->season > 0) {
                $search = sprintf('%s S%02dE%02d', $ep->series_name, $ep->season, $ep->episode);

                if (!$rss->alreadySaved($search)) {
                    $xml = $nzb->search($search);

//                    echo "******* Search Name ******** <br />";
//                    var_dump($search);

                    $this->handleResults($search, $xml, $ep);
                }
            }
        }

        $this->request->response = __('Updated');
    }

    public function action_fillOneRss($id) {
        set_time_limit(0);
        $rss = ORM::factory('rss');

        $ep = ORM::factory('episode', array('id' => $id));
        $series = $ep->getSeriesInfo();

        $search = Helper_Search::searchName(Helper_Search::escapeSeriesName($series->series_name), $ep->season, $ep->episode);

        $nzb = new Nzbindex();
        if (!$rss->alreadySaved($search)) {
            $xml = $nzb->search($search);

            $std = new stdClass();
            $std->season = $ep->season;
            $std->episode = $ep->episode;
            $std->series_name = $series->series_name;
            $std->matrix_cat = $series->matrix_cat;

            $this->handleResults($search, $xml, $std);
        }
    }

    protected function handleResults($search, $xml, $ep) {
        foreach($xml->channel->item as $item) {
            $rss = ORM::factory('rss');
            $parse = new NameParser_Nzbindex((string) $item->title);
            $parsed = $parse->parse();

            if (sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
                sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
                strtolower($parsed['name']) == strtolower($ep->series_name) &&
                $ep->matrix_cat == NzbMatrix::determinCat((string) $item->title)) {

                $category = NzbMatrix::cat2string(NzbMatrix::determinCat((string) $item->title));
                $rss->title = $search;
//                $rss->guid = (string) $item->link;
                $rss->guid = (string) $item->title;
                $rss->link = (string) $item->link;
                $rss->description = (string) $item->description;
                $rss->category = $category;
                $rss->pubDate = (string) $item->pubDate;
                $rss->enclosure = serialize(array(
                            'url' => (string) $item->enclosure['url'],
                            'length' => round((int) $item->enclosure['length']),
                            'type' => (string) $item->enclosure['type'])
                        );

                if ($rss->save())
                    return true;
            }
        }

        return false;

    }

}

?>
