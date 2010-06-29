<?php defined('SYSPATH') or die('No direct script access.');

function getStatusCode($response){
    if (preg_match('@^HTTP/[0-9]\.[0-9] ([0-9]{3})@', $response, $matches)) {
        return $matches[1];
    }
    return null;
} 

class Sabnzbd {

    protected $_apiKey = "";
    protected $_sabUrl = "";
    protected $_result = "";


    public function  __construct(array $options) {
        $this->_sabUrl = $options['url'] . '/sabnzbd/api';
        $this->_apiKey = $options['api_key'];
        if (getStatusCode($this->send($this->_sabUrl . "?apikey=$this->_apiKey", array(CURLOPT_HEADER => true))) != 200) {
            throw new RuntimeException('Url to SABNzbd is not ok. Returns header code ' . getStatusCode($this->send($this->_sabUrl, array(CURLOPT_HEADER => true))));
        }
    }

    function sendNzb($url, $name) {
        $query = array(
            'mode' => 'addurl',
            'name' => $url,
            'cat' => 'tv',
            'nzbname' => $name,
            'apikey' => $this->_apiKey,
            'script' => 'tvDeleteUnnecessaryFiles.py',
            'priority' => 0,
        );

//        http://localhost:8080/sabnzbd/api?mode=addurl&name=http://www.example.com/example.nzb&pp=3&script=customscript.cmd&cat=Example&priority=-1&nzbname=NiceName

        $sendTo = $this->_sabUrl . '?' . http_build_query($query);
        return $this->send($sendTo);
    }

    function getHistory() {

        $query = array(
                'mode' => 'history',
                'output' => 'json',
                'apikey' => $this->_apiKey
        );
        $sendTo = $this->_sabUrl . '?' . http_build_query($query);
        $json = json_decode($this->send($sendTo));
        if (isset($json->status) && !$json->status) {
            throw new RuntimeException($json->error);
        }
        
        return $json->history;
    }

    public function get($item) {
        $allowed = array('version', 'warnings', 'cats', 'scripts', 'queue', 'history');
        if (in_array($item, $allowed)) {
            $mode = $item;
            if ($item == 'cats' || $item == 'scripts') {
                $mode = 'get_' . $mode;
                $item = ($item == 'cats') ? 'categories' : $item;
            }
            
            $query = array(
                'mode' => $mode,
                'output' => 'json',
                'apikey' => $this->_apiKey
            );
            $json = json_decode($this->send($this->_sabUrl . '?' . http_build_query($query)));
//            if (isset($json->$item)) return $json->$item;
            return $json->$item;
        }
        return null;
    }

    public function getUrl($mode, array $options = array()) {
        $allowed = array('pause', 'resume', 'restart', 'shutdown', 'queue');
        if (in_array($mode, $allowed)) {
            $query = array(
                'mode' => $mode,
                'apikey' => $this->_apiKey
            );
            $query = array_merge($query, $options);
            return $this->_sabUrl . '?' . http_build_query($query);
        }
        return null;
    }

    public function setPause($min) {
        $query = array(
            'mode' => 'config',
            'value' => ($min * 60),
            'name' => 'set_pause',
            'apikey' => $this->_apiKey
        );
        return $this->_sabUrl . '?' . http_build_query($query);
    }

    public function getDelete($delete = "all") {
        $query = array(
            'mode' => 'queue',
            'value' => $delete,
            'name' => 'delete',
            'apikey' => $this->_apiKey
        );
        return $this->_sabUrl . '?' . http_build_query($query);
    }

    function isDownloaded($name) {
        foreach ($this->getHistory()->slots as $history) {
            if (strcmp($name . '.nzb', $history->nzb_name) == 0) {
                return true;
            }
        }

        return false;
    }

    protected function send($sendTo, array $options = array()) {
        $ch = curl_init();
        curl_setopt_array($ch, $options + array(
            CURLOPT_URL => $sendTo,
            CURLOPT_USERAGENT => 'Morres Test Script',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => 0
        ));

        $this->_result = curl_exec($ch);
        return $this->_result;
    }
}

?>
