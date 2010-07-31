<?php defined('SYSPATH') or die('No direct script access.');

class TheTvDB extends Tv_Info {
    
    protected $getServerTime = "http://www.thetvdb.com/api/Updates.php?type=none";
    protected $getLanguages = "%s/api/%s/languages.xml";
    protected $languageFile = "xml/theTvDBLanguages.xml";
    protected $serverTime = "";
    protected $mirror = array();
    private $apiKey = "";
    protected $seriealInfo;
    protected $xmlLanguages = array();

    public function  __construct($apiKey, $tvShow, $language = 'en') {
        $this->apiKey = $apiKey;
        $this->setMirror();
        $this->language = $language;
        if (!is_null($tvShow))
        $this->setSeries($tvShow);
    }

    protected function setSeries($tvShow, $lang = null) {
        if ($lang === null) $lang = 'all';
        $url = "http://www.thetvdb.com/api/GetSeries.php?seriesname=" . urlencode($tvShow). '&language=' . $lang;
        $this->seriealInfo = $this->getXml($url);
        foreach ($this->seriealInfo->Series as $series) {
            $this->xmlLanguages[] = (string)$series->language;
        }

        if (!in_array($this->language, $this->xmlLanguages)) {
            $this->language = $this->xmlLanguages[0];
        }
        return $this;
    }

    function getSeries() {
        return $this->seriealInfo;
    }

    function getLanguages() {
        return (empty($this->xmlLanguages)) ? array($this->language): $this->xmlLanguages;
    }

    function getLanguagesFromTvDb() {
        $url = sprintf("http://www.thetvdb.com/api/%s/languages.xml", $this->apiKey);
        return $this->getXml($url);
    }

    function setLanguage($language) {
        if (in_array($language, $this->xmlLanguages)) {
            $this->language = $language;
        }
    }

    function getSeriesInfo($showEp = true) {
        $url = sprintf(
                'http://www.thetvdb.com/api/%s/series/%s/%s%s.xml',
                $this->apiKey,
                (string)$this->seriealInfo->Series->seriesid,
                ($showEp) ? 'all/' : '',
                $this->language
                );

        return $this->getXml($url);
    }

    function getEpisodeInfo($epId) {
        $url = sprintf(
                'http://www.thetvdb.com/api/%s/episodes/%d/%s.xml',
                $this->apiKey,
                $epId,
                $this->language
                );

        return $this->getXml($url);
    }

    function getBanners() {
        $url = sprintf('http://www.thetvdb.com/api/%s/series/%s/banners.xml', $this->apiKey, (string)$this->seriealInfo->Series->seriesid);
        return $this->getXml($url);
    }

    function getActorsInfo() {
        $url = sprintf('http://www.thetvdb.com/api/%s/series/%s/actors.xml', $this->apiKey, (string)$this->seriealInfo->Series->seriesid);
        return $this->getXml($url);
    }

    protected function setMirror() {
        $url = sprintf('http://www.thetvdb.com/api/%s/mirrors.xml', $this->apiKey);
        $mirror = simplexml_load_file($url);

        $this->mirror['id'] = (int)$mirror->Mirror->id;
        $this->mirror['path'] = (string)$mirror->Mirror->mirrorpath;
        $this->mirror['type'] = (int)$mirror->Mirror->typemask;
    }

    function theTvDbLanguages() {
        $xml = simplexml_load_file(sprintf($this->getLanguages, $this->mirror['path'], $this->apiKey));
        $xml->asXML($this->languageFile);
    }

    function toArray($tvShow = null) {
        if (empty($this->seriealInfo)) {
            if (is_null($tvShow)) {
                throw new InvalidArgumentException('No show name!');
            }
            
            $this->getSeriesInfo($tvShow);
        }

        if (count($this->seriealInfo) > 1) {
            $arr = array();
            foreach ($this->seriealInfo as $xml) {
                $arr = $this->xmlToArray($xml, $this->language);
                if ($arr) {
                    return $arr;
                }
            }
        }

        return $this->xmlToArray($this->seriealInfo->Series);

    }

    protected function xmlToArray(SimpleXMLElement $obj, $lang = null) {
        $result = array();
        $result['seriesid'] = (string)$obj->seriesid;
        $result['language'] = (string)$obj->language;
        $result['seriesName'] = (string)$obj->SeriesName;
        $result['banner'] = 'http://thetvdb.com/banners/' . (string)$obj->banner;
        $result['content'] = (string)$obj->Overview;
        $result['firstAired'] = (string)$obj->FirstAired;

        $imdb = (string)$obj->IMDB_ID;
        if (!empty($imdb)) $result['imdb'] = "http://www.imdb.com/title/$imdb";

        $result['zap2it_id'] = (string)$obj->zap2it_id;
        $result['id'] = (string)$obj->id;

        if (!is_null($lang) && $result['language'] != $lang) {
            return false;
        }

        return array_map('trim', $result);
    }

}

/*
if self.config['search_all_languages']:
            self.config['url_getSeries'] = u"%(base_url)s/api/GetSeries.php?seriesname=%%s&language=all" % self.config
        else:
            self.config['url_getSeries'] = u"%(base_url)s/api/GetSeries.php?seriesname=%%s&language=%(language)s" % self.config

        self.config['url_epInfo'] = u"%(base_url)s/api/%(apikey)s/series/%%s/all/%%s.xml" % self.config

        self.config['url_seriesInfo'] = u"%(base_url)s/api/%(apikey)s/series/%%s/%%s.xml" % self.config
        self.config['url_actorsInfo'] = u"%(base_url)s/api/%(apikey)s/series/%%s/actors.xml" % self.config

        self.config['url_seriesBanner'] = u"%(base_url)s/api/%(apikey)s/series/%%s/banners.xml" % self.config
        self.config['url_artworkPrefix'] = u"%(base_url)s/banners/%%s" % self.config


 */
?>
