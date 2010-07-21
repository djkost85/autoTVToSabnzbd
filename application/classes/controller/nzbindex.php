<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Nzbindex extends Controller {

    public function action_index() {
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
//        $xml = $nzb->search('Stargate Universe S01E20');
        $xml = $nzb->search('Glee S01E22');
//        var_dump($xml);
        foreach ($xml->channel->item as $item) {
            $parse = new NameParser_Nzbindex((string) $item->title);
            $parsed = $parse->parse();

            var_dump($item);
            var_dump($parsed);
//            if (is_null($parsed)) var_dump($item);
//            else var_dump($parsed);

            var_dump(NzbMatrix::determinCat((string) $item->title));
        }
    }

    public function action_fillRss() {
        set_time_limit(0);
        $config = Kohana::config('default');
        $rss = ORM::factory('rss');

        $rss->truncate();

        $series = Model_SortFirstAired::getSeries();
        
        $nzb = new Nzbindex();
        foreach ($series as $ep) {
            if ($rss->count_all() >= $config->rss['numberOfResults']) {
                break;
            }
            if (strtotime($ep->first_aired) < strtotime($config->rss['howOld']) && $ep->season > 0) {
                $search = sprintf('%s S%02dE%02d', $ep->series_name, $ep->season, $ep->episode);

                if (!$rss->alreadySaved($search)) {
                    $xml = $nzb->search($search);

                    echo "******* Search Name ******** <br />";
                    var_dump($search);

                    $this->handleResults($search, $xml, $ep);
                    sleep(10);
                }
            }
        }

        $this->request->response = __('Updated');
    }

    protected function handleResults($search, $xml, $ep) {
        foreach ($xml->channel->item as $item) {
            $rss = ORM::factory('rss');
            $parse = new NameParser_Nzbindex((string) $item->title);
            $parsed = $parse->parse();

            echo "******* Parsd name ******** <br />";
            var_dump($parsed);
            echo "******* Title ********* <br />";
            var_dump((string) $item->title);

            if (sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
                sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
                strtolower($parsed['name']) == strtolower($ep->series_name)) {
                if (!$rss->alreadySaved($search)) {
                    if ($ep->matrix_cat == NzbMatrix::catStr2num(NzbMatrix::determinCat((string) $item->title))) {
                        $category = NzbMatrix::catStr2num(NzbMatrix::determinCat((string) $item->title));
                    } else {
                        $category = (string) $item->category;
                    }

                    echo "******* Saving Result ******** <br />";
                    var_dump($item);

                    $rss->title = $search;
                    $rss->guid = (string) $item->link;
                    $rss->link = (string) $item->link;
                    $rss->description = (string) $item->description;
                    $rss->category = $category;
                    $rss->pubDate = (string) $item->pubDate;
                    $rss->enclosure = serialize(array(
                                'url' => (string) $item->enclosure['url'],
                                'length' => round((int) $item->enclosure['length']),
                                'type' => (string) $item->enclosure['type'])
                            );

                    $rss->save();
                    return;
                }
            }
        }
    }

}

?>
