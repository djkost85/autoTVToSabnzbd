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


    protected function send($url, array $options = array()) {
        $this->_ch = curl_init();
        curl_setopt_array($this->_ch, $options + array(
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; nl; rv:1.9.2) Gecko/20100115 Firefox/3.6',
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HEADER => 1
        ));

        $content = curl_exec($this->_ch);

        $this->_httpCode = curl_getinfo($this->_ch, CURLINFO_HTTP_CODE);
        
        return ($this->_httpCode == 200) ? $content : $this->_httpCode;
    }

    protected function getXml($url, array $options = array()) {
        $str = $this->send($url, $options + array(CURLOPT_HEADER => false));

        if (is_numeric($str)) {
            $this->_httpCode = $str;
            throw new RuntimeException(Helper::getHttpCodeMessage($xml), $str);
        }

        $data = simplexml_load_string($str);
//        $data = @simplexml_load_file($url);
//
//        if (!$data or count($data) <= 0) {
//            $this->_httpCode = 500;
//            throw new InvalidArgumentException('No data');
//        }
        return $data;
    }

    public function error() {
        return curl_error($this->_ch);
    }

    public function getHttpCode() {
        return $this->_httpCode;
    }
}
?>
