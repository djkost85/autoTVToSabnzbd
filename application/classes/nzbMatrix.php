<?php defined('SYSPATH') or die('No direct script access.');
class NzbMatrix extends Tv_Info {

    protected $searchUrl = "http://nzbmatrix.com/api-nzb-search.php";
    protected $searchResult = array();
    protected $downloadUrl = "http://nzbmatrix.com/api-nzb-download.php";
    protected $detailsUrl = "http://nzbmatrix.com/api-nzb-details.php";
    private $_apiKey = '';

    public function  __construct($apiKey) {
        $this->_apiKey = $apiKey;
    }

    public function search($search, $catId = "6") {
        $query = array(
                'search' => $search,
                'catid' => $catId,
                'num' => '15',
                'age' => '',
                'region' => '',
                'group' => '',
                'username' => 'morre95',
                'apikey' => $this->_apiKey,
        );

        $url = $this->searchUrl . '?' . http_build_query($query);

        $result = $this->send($url);
        $this->searchResult = $this->parseResult($result);
        return $this->searchResult;
    }

    protected function parseResult($result) {
        $return = array();
        foreach(explode('|', $result) as $parts) {
            $res = array();
            $parts = str_replace(array('&amp;gt;', '&amp;', '  ') , array('', '', ' '), $parts);
            foreach (explode(';', $parts) as $part) {
                $expl = explode(':', trim($part));
                if (count($expl) == 2) {
                    list($key, $value) = $expl;
                    $res[strtolower($key)] = $value;
                } else if (preg_match('#^(IMAGE|WEBLINK):http://#', trim($part))) {
                    $expl = explode(':', trim($part), 2);
                    list($key, $value) = $expl;
                    $res[strtolower($key)] = $value;
                } else if (preg_match('#^(INDEX_DATE|USENET_DATE)#', trim($part))) {
                    $expl = explode(':', trim($part), 2);
                    list($key, $value) = $expl;
                    $res[strtolower($key)] = $value;
                } else {
                    //var_dump(trim($parts));
                    //var_dump(trim($part));
                    //var_dump($expl);
                }
            }
            if (!empty($res)) {
                $return[] = $res;
            }
        }
        return $return;
    }

    public function buildDownloadUrl($id) {
        $query = array(
                'id' => $id,
                'username' => 'morre95',
                'apikey' => $this->_apiKey,
        );

        return $this->downloadUrl . '?' . http_build_query($query);
    }

    public static function cat2string($num) {
        $return = array(
            5 => 'TV > DVD',
            6 => 'TV > Divx/Xvid',
            7 => 'TV > Sport/Event',
            8 => 'TV > Other',
            41 => 'TV > HD',
            'tv-all' => 'TV > All',
        );

        if (isset($return[$num])) {
            return $return[$num];
        }
        return false;
    }

    public static function catStr2num ($str) {
        $regexp = array(
            5 => '/(tv)[\s><\-]+(dvd)/i',
            6 => '/(tv)[\s><\-]+(divx\/xvid)/i',
            7 => '/(tv)[\s><\-]+(sport\/ent)/i',
            8 => '/(tv)[\s><\-]+(other)/i',
            41 => '/(tv)[\s><\-]+(hd)/i',
            'tv-all' => '/(tv)[\s><\-]+(all)/i',
            );

        foreach ($regexp as $key => $pattern) {
            if (preg_match($pattern, $str)) {
                return $key;
            }
        }
    }
    
}

?>
