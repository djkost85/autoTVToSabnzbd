<?php defined('SYSPATH') or die('No direct script access.');
class Nzbs extends Tv_Info {

    protected $searchUrl = "http://nzbs.org/rss.php";

    protected $_queryString = "";


    public function  __construct(array $config) {
        $this->_queryString = '&' . ltrim($config['queryString'], '&');
    }

    //&i=38103&h=bdfda388ee862671d683864d0aba9935
    public function search($q, $cat = null) {
        $query = array(
            'q' => $q,
            'dl' => '1',
            'num' => '25',
        );

        if (is_null($cat)) $query['type'] = 1;
        else $query['catid'] = $cat;

        $url = $this->searchUrl . '?' . http_build_query($query) . $this->_queryString;

        try {
            $xml = $this->getXml($url);
        } catch (InvalidArgumentException $e) {
            Kohana::exception_handler($e);
            return;
        }

        return $xml;
    }

    public function getNzb() {
        //http://nzbs.org/index.php?action=getnzb&nzbid=204518
    }

    public static function cat2MatrixNum ($str) {
        $regexp = array(
            5 => '/(tv)[\s><\-]+(dvd)/i',
            6 => '/(tv)[\s><\-]+(xvid)/i',
            7 => '/(tv)[\s><\-]+(sport\/ent)/i',
            8 => '/(tv)[\s><\-]+(other|swe)/i',
            41 => '/(tv)[\s><\-]+([x|h]264)/i',
            'tv-all' => '/(tv)[\s><\-]+(all)/i',
            );

        foreach ($regexp as $key => $pattern) {
            if (preg_match($pattern, $str)) {
                return $key;
            }
        }

        return 'tv-all';
    }

    public static function matrixNum2Nzbs($num) {
        $return = 0;
        switch ($num) {
            case 5: $return = 11; break;
            case 6: $return = 1; break;
            case 7: $return = null; break;
            case 8: $return = null; break;
            case 41: $return = 14; break;
            case 'tv-all': $return = null; break;
        }

        return $return;
    }
}

?>
