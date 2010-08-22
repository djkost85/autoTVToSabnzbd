<?php defined('SYSPATH') or die('No direct script access.');

class Model_SortFirstAired extends Model {

    public static function getWelcomeSeries($limit, $offset) {
        $series = ORM::factory('series');

        $return = array();
        foreach ($series->getByFirtAired($limit, $offset) as $ser) {
            $return[] = self::getSeriesInfo($ser);
        }

        return $return;
    }

    protected static function getSeriesInfo($ser) {
        $ep = ORM::factory('episode')
                ->where('series_id', '=', $ser->id)
                ->and_where('first_aired', '<=', DB::expr('CURDATE()'))
                ->and_where('season', '>', '0')
                ->order_by('first_aired', 'desc')
                ->find();

        $std = new stdClass();
        $std->series_id = $ser->id;
        $std->id = $ser->id;
        $std->episode_id = $ep->id;
        $std->first_aired = $ep->first_aired;
        $std->series_name = $ser->series_name;
        $std->download_link = "download/episode/$ep->id";
        $std->episode = $ep->episode;
        $std->season = $ep->season;
        $std->poster = ($ser->poster != "") ? $ser->poster : $ser->fanart;
        $std->status = $ser->status;
        $std->airs_day = $ser->airs_day;
        $std->airs_time = $ser->airs_time;
        $std->network = $ser->network;
        $std->overview = $ser->overview;
        $std->tvdb_id = $ser->tvdb_id;
        $std->next_episode = $ep->getNext($ep->id);
        $std->airs_time = $ser->airs_time;
        $std->matrix_cat = $ser->matrix_cat;

        return $std;
    }


    public static function getSeries() {
        $series = ORM::factory('series');

        $return = array();
        foreach ($series->getFirtAiredNoLimit() as $ser) {
            $return[] = self::getSeriesInfo($ser);
        }

        return $return;
    }

}

?>
