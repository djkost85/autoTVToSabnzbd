<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of downloads
 *
 * @author Morre95
 */
class Queue_Downloads {
    
    protected $_items = array();

    public function __set($key, $value) {
        $this->_items[$key] = $value;
    }

    public function __get($key) {
        if (isset($this->_items[$key]))
        return $this->_items[$key];
    }

    public function  __isset($name) {
        return isset($this->_items[$name]);
    }

    public function  __unset($name) {
        unset($this->_items[$name]);
    }

    public function execute() {
        $sab = new Sabnzbd(Kohana::config('default.Sabnzbd'));
        $matrix = new NzbMatrix(Kohana::config('default.default'));
        foreach ($this->_items as $nzbid => $name) {
            $sab->sendNzb($matrix->buildDownloadUrl($nzbid), $name);
        }
    }
}
?>
