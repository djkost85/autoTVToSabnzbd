<?php

class ImdbApi extends Tv_Info {

    protected $_searchUrl = "http://imdbapi.poromenos.org/json/";
    protected $_url = "http://imdbapi.poromenos.org/js/";

    public function search($search, $year = null) {
        $queryArr = array(
            'name' => $search,
        );

        if (is_numeric($year)) {
            $queryArr = array_merge($queryArr, array('year' => $year));
        }

        $url = $this->_searchUrl . '?' . http_build_query($queryArr);
        $res = $this->send($url, array(CURLOPT_HEADER => false));
        if (is_numeric($res)) {
            throw new RuntimeException(Helper::getHttpCodeMessage($res), $res);
        }

        return json_decode($res);
    }
}
?>
