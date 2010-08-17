<?php defined('SYSPATH') or die('No direct script access.');

class Model_SortFirstAired extends Model {

    public static function getWelcomeSeries($limit, $offset) {
        $series = ORM::factory('series');

        $return = array();
        foreach ($series->getByFirtAired($limit, $offset) as $ser) {
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

            $return[] = $std;
        }

        return $return;
    }

    /**
     *
     * Ska ersättas av funktionen åvan
     *
     * @return object
     */
    public static function getSeries() {
       $episodes = array();

        foreach (ORM::factory('series')->find_all() as $series) {
            $seriesName = $series->series_name;
            $id = $series->id;
            $res = array();
            foreach($series->episodes->where('first_aired', '<=', DB::expr('CURDATE()'))->and_where('season', '>', '0')->order_by('first_aired', 'desc')->find_all() as $ep) {
                $std = new stdClass();
                //if (strtotime($ep->first_aired) < time() && $ep->season > 0) {
                if (strtotime($ep->first_aired) < time() && $ep->season > 0) {
                    $std->series_id = $id;
                    $std->id = $id;
                    $std->episode_id = $ep->id;
                    $std->first_aired = $ep->first_aired;
                    $std->series_name = $seriesName;
                    $std->download_link = "download/episode/$ep->id";
                    $std->episode = $ep->episode;
                    $std->season = $ep->season;
                    $std->poster = ($series->poster != "") ? $series->poster : $series->fanart;
                    $std->status = $series->status;
                    $std->airs_day = $series->airs_day;
                    $std->airs_time = $series->airs_time;
                    $std->network = $series->network;
                    $std->overview = $series->overview;
                    $std->tvdb_id = $series->tvdb_id;
                    $std->next_episode = $ep->getNext($ep->id);
                    $std->airs_time = $series->airs_time;
                    $std->matrix_cat = $series->matrix_cat;
                    //$std->airs_at = __($series->airs_day) . ' ' . __('at') . ' ' . date('H:i', strtotime($series->airs_time));
                    break;
                }
            }
            if (isset($std->id))
            $episodes[] = $std;
        }
//        var_dump(ORM::factory('series')->last_query());

        $sorted = usort($episodes, array('Model_SortFirstAired', 'sortFirstAired'));
//        $sorted = true;
        return ($sorted) ? new ArrayIterator($episodes) : array();
    }

    public static function sortFirstAired($a, $b) {
        $a = strtotime($a->first_aired . ' ' . $a->airs_time);
        $b = strtotime($b->first_aired . ' ' . $b->airs_time);
//        $a = strtotime($a->first_aired);
//        $b = strtotime($b->first_aired);
        if ($a == $b) {
            return 0;
        }
        return ($a > $b) ? -1 : 1;
    }

}

?>
