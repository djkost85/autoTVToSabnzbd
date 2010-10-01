<?php

class Helper_Search {

    public static function escapeSeriesName($search) {
        $search = str_replace(array(':', ' -', '(', ')'), '', $search);
        return preg_replace('#\s[a-z]\s#i', ' ', $search);
    }

    public static function searchName($seriesName, $season, $episode) {
        return sprintf('%s S%02dE%02d', self::escapeSeriesName($seriesName), $season, $episode);
    }
}

?>
