<?php

defined('SYSPATH') or die('No direct script access.');

class TvRageInfo extends Tv_Info {

    protected $_searchUrl = "http://services.tvrage.com/myfeeds/search.php";
    protected $_showInfoUrl = "http://services.tvrage.com/myfeeds/showinfo.php";
    protected $_epListUrl = "http://services.tvrage.com/myfeeds/episode_list.php";
    protected $_epInfoUrl = "http://services.tvrage.com/myfeeds/episodeinfo.php";
    protected $_getItemUrl = "http://services.tvrage.com/myfeeds/%s.php";
    private $_apiKey;

    public function __construct(array $config) {
        $this->_apiKey = $config['api_key'];
    }

    public function search($name) {
        $url = $this->_searchUrl . "?";
        $url .= http_build_query(array(
                    'key' => $this->_apiKey,
                    'show' => $name,
                ));

        return $this->getXml($url);
    }

    public function getInfo($id) {
        $url = $this->_showInfoUrl . "?";
        $url .= http_build_query(array(
                    'key' => $this->_apiKey,
                    'sid' => $id,
                ));

        return $this->getXml($url);
    }

    public function getEpList($id) {
        $url = $this->_epListUrl . "?";
        $url .= http_build_query(array(
                    'key' => $this->_apiKey,
                    'sid' => $id,
                ));

        return $this->getXml($url);
    }

    public function getEpInfo($id, $ep) {
        $url = $this->_epInfoUrl . "?";
        $url .= http_build_query(array(
                    'key' => $this->_apiKey,
                    'sid' => $id,
                    'ep' => $ep,
                ));

        return $this->getXml($url);
    }

    /**
     *
     * Get currentshows, fullschedule or countdown
     *
     * @example $tv->get('currentshows');
     * @param string $item
     * @return string xml
     */
    public function get($item) {
        $allowed = array('currentshows', 'countdown', 'fullschedule');
        if (in_array($item, $allowed)) {
            $url = sprintf($this->_getItemUrl . "?", $item);
            $url .= http_build_query(array(
                        'key' => $this->_apiKey,
                    ));

            return $this->getXml($url);
        }

        return null;
    }

}

?>
