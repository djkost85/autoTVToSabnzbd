<?php defined('SYSPATH') or die('No direct script access.');
class NzbMatrix extends Tv_Info {

    protected $searchUrl = "http://api.nzbmatrix.com/v1.1/search.php";
    protected $searchResult = array();
    protected $downloadUrl = "http://api.nzbmatrix.com/v1.1/download.php";
    protected $detailsUrl = "http://api.nzbmatrix.com/v1.1/details.php";
    private $_apiKey = null;
    private $_apiUser = null;

    public function  __construct(array $options) {
        $this->_apiKey = $options['NzbMatrix_api_key'];
        $this->_apiUser = $options['NzbMatrix_api_user'];
    }

    public function search($search, $catId = "6") {
        $query = array(
                'search' => $search,
                'catid' => $catId,
                'num' => '15',
                'age' => '',
                'region' => '',
                'group' => '',
                'username' => $this->_apiUser,
                'apikey' => $this->_apiKey,
        );

        $url = $this->searchUrl . '?' . http_build_query($query);

        $result = $this->send($url);

        if (is_numeric($result)) {
            return $result;
        }

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

                    /**
                     * provisionally until it is patched
                     */
                    if (strtolower($key) == 'link') {
                        parse_str(parse_url($value, PHP_URL_QUERY));
                        $res['nzbid'] = $id;
                        unset ($id);
                        unset ($hit);
                    }
                    $res[strtolower($key)] = $value;
                } else if (preg_match('#^(IMAGE|WEBLINK):http://#', trim($part))) {
                    $expl = explode(':', trim($part), 2);
                    list($key, $value) = $expl;
                    $res[strtolower($key)] = $value;
                } else if (preg_match('#^(INDEX_DATE|USENET_DATE)#', trim($part))) {
                    $expl = explode(':', trim($part), 2);
                    list($key, $value) = $expl;
                    $res[strtolower($key)] = $value;
                } else if (preg_match('#error:(.*)#', trim($part), $matches)) {
                    $res['error'] = $matches[1];
                }else {
//                    var_dump(trim($parts));
//                    var_dump(trim($part));
//                    var_dump($expl);
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
                'username' => $this->_apiUser,
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
            'movies-all' => 'Movies > ALL',
            1 => 'Movies > DVD',
            2 => 'Movies > Divx/Xvid',
            54 => 'Movies > BRRip',
            42 => 'Movies > HD (x264)',
            50 => 'Movies > HD (Image)',
            48 => 'Movies > WMV-HD',
            3 => 'Movies > SVCD/VCD',
            4 => 'Movies > Other',
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

            'movies-all' => '/movies[\s><\-]+(all)/i',
            1 => '/movies[\s><\-]+(dvd)/i',
            2 => '/movies[\s><\-]+(divx\/xvid)/i',
            54 => '/movies[\s><\-]+(brrip)/i',
            42 => '/movies[\s><\-]+(hd \(x264\))/i',
            50 => '/movies[\s><\-]+(hd \(Image\))/i',
            48 => '/movies[\s><\-]+(wmv\-hd)/i',
            3 => '/movies[\s><\-]+(svcd\/vcd)/i',
            4 => '/movies[\s><\-]+(other)/i',
            );

        foreach ($regexp as $key => $pattern) {
            if (preg_match($pattern, $str)) {
                return $key;
            }
        }
    }

    public static function determinCat($title) {
        $hdArr = array(
            '720p',
            '1080p',
            '1080i',
            'x264',
            'mkv',
        );

        foreach ($hdArr as $hd) {
            if (strpos($title, $hd)) {
                return 41;
            }
        }

        $divxArr = array(
            'divx',
            'xvid',
        );

        foreach ($divxArr as $divx) {
            if (strpos($title, $divx)) {
                return 6;
            }
        }

        return null;
    }
    
}

?>
