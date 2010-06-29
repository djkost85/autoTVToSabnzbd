<?php defined('SYSPATH') or die('No direct script access.');


/**
 * Thumnet is an IMDB scraper
 * http://scraper.thumnet.com/
 *
 * @author Morre95
 */
class Thumnet extends Tv_Info {
    protected $type = "";

    public function  __construct($type = "json") {
        $this->type = $type;
    }

    public function search($q) {
        $url = sprintf('http://scraper.thumnet.com/%s/imdb-title-search/%s', urlencode($this->type), urlencode($q));
        $content = $this->send($url);
        //return json_decode($content);
        return json_decode($content)->thumnet->Data->PopularResults;
    }

    public function getByTitle($title) {
        $url = sprintf('http://scraper.thumnet.com/%s/imdb-title/%s', urlencode($this->type), urlencode($title));
        $content = $this->send($url);
        return json_decode($content);
    }

}
?>
