<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of info
 *
 * @author Morre95
 */
abstract class Tv_Info {

    private $_ch;
    protected $_httpCode = 200;
    private $_content;


    /**
     *
     * Uses CURL to get answers from an external site
     * 
     * @param string $url
     * @param array $options
     * @return string if http code is 200 otherwise it returns the http code
     */
    protected function send($url, array $options = array()) {
        $this->_ch = curl_init();
        curl_setopt_array($this->_ch, $options + array(
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; nl; rv:1.9.2) Gecko/20100115 Firefox/3.6',
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HEADER => 1,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 5,
        ));

        $this->_content = curl_exec($this->_ch);

        $this->_httpCode = curl_getinfo($this->_ch, CURLINFO_HTTP_CODE);
        
        return ($this->_httpCode == 200) ? $this->_content : $this->_httpCode;
    }

    public function getXml($url, array $options = array()) {
        $str = $this->send($url, $options + array(CURLOPT_HEADER => false));

        if (is_numeric($str)) {
            $this->_httpCode = $str;
            throw new RuntimeException(Helper::getHttpCodeMessage($str), $str);
        }

        $data = simplexml_load_string($str);
        return $data;
    }


    public function getJson($url) {
        $res = $this->send($url, array(CURLOPT_HEADER => false));
        if (is_numeric($res)) {
            $this->_httpCode = $res;
            throw new RuntimeException(Helper::getHttpCodeMessage($res), $res);
        }

        return json_decode($res);
    }

    public function error() {
        return curl_error($this->_ch);
    }

    public function getHttpCode() {
        return $this->_httpCode;
    }

    public function getInfo() {
        if (!is_null($this->_ch))
        return curl_getinfo($this->_ch);
    }

    public function getContent() {
        if (!is_null($this->_content)) {
            return $this->_content;
        }
        return false;
    }
}
?>
