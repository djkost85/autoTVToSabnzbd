<?php

class Helper_Search {

    public static function escapeSeriesName($search) {
        $search = str_replace(array(':', ' -', '(', ')', ' 2008'), '', $search);
        return preg_replace('#\s[a-z]\s#i', ' ', $search);
    }

    public static function searchName($seriesName, $season, $episode, $format = "%s S%02dE%02d") {
        return sprintf($format, $seriesName, $season, $episode);
    }
}

?>
