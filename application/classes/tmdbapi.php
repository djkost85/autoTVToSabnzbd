<?php defined('SYSPATH') or die('No direct script access.');
/**
 * http://api.themoviedb.org/2.1
 */
class TmdbApi extends Tv_Info {

    protected $_searchUrl = "http://api.themoviedb.org/2.1/Movie.search/en/json/%s/%s";
    protected $_imdbUrl = "http://api.themoviedb.org/2.1/Movie.imdbLookup/en/json/%s/%s";
    protected $_url = "http://api.themoviedb.org/2.1/%s/en/json/%s/%d";
    protected $_getLatestUrl = "http://api.themoviedb.org/2.1/Movie.getLatest/en/json/%s";
    private $_apiKey;


    public function  __construct(array $options) {
        $this->_apiKey = $options['apiKey'];
    }

    public function search($search) {
        $imdbId = false;
        if(preg_match("/^tt[\d]+/", trim($search), $match)) {
            $imdbId = $match[0];
        }
        
        $url = ($imdbId) ? sprintf($this->_imdbUrl, $this->_apiKey, urlencode($imdbId)) : sprintf($this->_searchUrl, $this->_apiKey, urlencode(trim($search)));
        return $this->getJson($url);
    }

    public function getInfo($id) {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException('No id');
        }
        $url = sprintf($this->_url, 'Movie.getInfo', $this->_apiKey, $id);
        return $this->getJson($url);
    }
    
    public function getVersion($id) {
        $ids = preg_grep("/^\d+$/", array_map('trim', explode(',', $id)));
        $id = implode(',', $ids);
        $url = sprintf($this->_url, 'Movie.getVersion', $this->_apiKey, $id);
        return $this->getJson($url);
    }

    public function getTranslations($id) {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException('No id');
        }
        $url = sprintf($this->_url, 'Movie.getTranslations', $this->_apiKey, $id);
        return $this->getJson($url);
    }
    
    public function getLatest() {
        $url = sprintf($this->_getLatestUrl, 'Movie.getLatest', $this->_apiKey);
        return $this->getJson($url);
    }

    public function getImages($id) {
        $imdbId = false;
        if(preg_match("/^tt[\d]+/", trim($id), $match)) {
            $imdbId = $match[0];
        }

        if (!is_numeric($id) && !$imdbId) {
            throw new InvalidArgumentException('No id');
        } else if($imdbId) {
            $id = $imdbId;
        }


        $url = sprintf($this->_url, 'Movie.getImages', $this->_apiKey, $id);
        return $this->getJson($url);
    }

    protected function getJson($url) {
        try {
            return parent::getJson($url);
        } catch (RuntimeException $e) {
            $msg = self::getStatusMsg($e->getCode());
            if (!is_null($msg)) {
                throw new Movie_Exception($msg, 401);
            }

            if ($this->getContent() == "") {
                throw new Movie_Exception($e->getMessage(), $e->getCode());
            }
        }
    }

    public static function getStatusMsg($code) {
        $statusMsg = array(
            1 => 'Success',
            2 => 'Invalid service - This service does not exist.',
            3 => 'Authentication Failed - You do not have permissions to access the service.',
            4 => 'Invalid format - This service doesn`t exist in that format.',
            5 => 'Invalid parameters - Your request is missing a required parameter.',
            6 => 'Invalid pre-requisite id - The pre-requisite id is invalid or not found.',
            7 => 'Invalid API key - You must be granted a valid key.',
            8 => 'Duplicate entry - The data you tried to submit already exists.',
            9 => 'Service Offline - This service is temporarily offline. Try again later.',
            10 => 'Suspended API key - Access to your account has been suspended, contact TMDb.',
            11 => 'Internal error - Something went wrong. Contact TMDb.',
        );
        return (isset($statusMsg[$code])) ? $statusMsg[$code] : null;
    }
}

?>
