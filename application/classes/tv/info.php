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
    
    protected function send($url, array $options = array()) {
        $this->_ch = curl_init();
        curl_setopt_array($this->_ch, $options + array(
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'morresTest/0.2',
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => 0
            
        ));
        
        return curl_exec($this->_ch);
    }

    protected function getXml($url) {
        $data = simplexml_load_file($url);
        if (count($data) <= 0) {
            throw new InvalidArgumentException('No data');
        }
        return $data;
    }

    public function error() {
        return curl_error($this->_ch);
    }
}
?>
