<?php defined('SYSPATH') or die('No direct script access.'); 

class Sabnzbd {

    protected $_apiKey = "";
    protected $_sabUrl = "";
    protected $_result = "";
    protected $_login = array();


    public function  __construct(array $options) {
        $this->_sabUrl = $options['url'] . '/sabnzbd/api';
        $this->_apiKey = $options['api_key'];

        if (isset($options['username']) && isset($options['password'])) {
            $this->_login['user'] = urlencode($options['username']);
            $this->_login['pass'] = urlencode($options['password']);
        }
    }

    function sendNzb($url, $name, $cat = 'tv') {
        $query = array(
            'mode' => 'addurl',
            'name' => $url,
            'cat' => $cat,
            'nzbname' => $name,
            'apikey' => $this->_apiKey,
//            'script' => 'tvDeleteUnnecessaryFiles.py',
            'priority' => 0,
        );
//        var_dump($query);

        $sendTo = $this->_sabUrl . '?' . http_build_query($query);
        return $this->send($sendTo);
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

    public function getAuthAnswer() {
        $query = array(
            'mode' => 'auth',
        );
        $sendTo = $this->_sabUrl . '?' . http_build_query($query);
        return $this->send($sendTo);
    }

    public function isDownloaded($name) {
        foreach ($this->get('history')->slots as $history) {
            if (strcmp($name . '.nzb', $history->nzb_name) == 0) {
                return true;
            }
        }

        return false;
    }

    public static function confirmAuthAnswer($sabReturn) {
        $sabAnswer = array(
            'apikey',
            'login',
            'None',
        );

        return in_array(trim($sabReturn), $sabAnswer);
    }

    protected function send($sendTo, array $options = array()) {
        $options = $options + array(
            CURLOPT_URL => $sendTo,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; nl; rv:1.9.2) Gecko/20100115 Firefox/3.6',
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
        );

        $options[CURLOPT_RETURNTRANSFER] = 1;

        if (!empty($this->_login)) {
            $sendTo .= "&ma_username={$this->_login['user']}&ma_password={$this->_login['pass']}";
        }

        $ch = curl_init();
        if (!curl_setopt_array($ch, $options)) {
            throw new RuntimeException("Failed to set CURL options, check CURL documentation: http://php.net/curl_setopt_array");
        }

        $this->_result = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode < 200 OR $httpCode > 299) {
            $error = $this->_result;
        } else if ($this->_result === false) {
            $error = curl_error($ch);
        }

        curl_close($ch);

        if (isset($error)) {
            var_dump($error);
        }

        return ($httpCode == 200) ? $this->_result : $httpCode;
    }
}

?>
