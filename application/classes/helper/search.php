<?php

class Helper_Search {

    public static function escapeSeriesName($search) {
        $search = str_replace(array(':', ' -', '(', ')'), '', $search);
//        $search = preg_replace('#(\s\([0-9]+\))#', '', $search);
        return $search;
    }

    public static function searchName($seriesName, $season, $episode) {
        return sprintf('%s S%02dE%02d', $seriesName, $season, $episode);
    }
}

?>
