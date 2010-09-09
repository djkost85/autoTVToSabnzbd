<?php defined('SYSPATH') or die('No direct script access.');

class Posters {
    protected $smallPoster = 'http://thetvdb.com/banners/_cache/posters/';
    protected $largePoster = 'http://thetvdb.com/banners/posters/';
    protected $showInfo = 'http://www.thetvdb.com/api/GetSeries.php?seriesname=';
    protected $apiKey = 'A6D11F92201EEBFA';
    protected $showName = null;

    public function  __construct($showName = null) {
        if (!is_null($showName))
            $this->showName = trim($showName);
    }

    protected function getXml() {
        $show_xml = file_get_contents($this->showInfo . urlencode($this->showName));
        $xml = simplexml_load_string($show_xml);
        return $xml;
    }

    public function getPosters($size = null) {
        $series = $this->getXml()->xpath('/Data/Series');
        if(sizeof($series) > 0) {
            //1 match found
            if(sizeof($series) == 1) {
                $series_id = $series[0]->seriesid;
            }
            //2+ matches found, use first match with an exact name match
            else {
                foreach($series as $show) {
                    if(strtolower($show->SeriesName) == strtolower($this->showName)) {
                        $series_id = $show->seriesid;
                        break;
                    }
                }
            }

            //exact match found
            if($series_id > 0) {
                $posters = array();
                for($i = 1; $i <= 10; $i++) {
                    $poster_url = ($size == 'large') ? $this->largePoster : $this->smallPoster . $series_id . '-' . $i . '.jpg';
                    if(@fopen($poster_url, 'r')) {
                        $posters[] = $poster_url;
                    }
                }
                return $posters;
                //print implode(',', $posters);
            }
            //nothing exact, so present a list

            else {
                print $this->showName . ' NAMES ';
                $names = array();
                foreach($series as $show) {
                    $names[] = $show->SeriesName;
                }
                print implode(',', $names);
            }

        }
        return array();
    }

    public function get() {
        $series = $this->getXml()->xpath('/Data/Series');
    }

    function saveImage($inPath, $outPath) {
        $in=    fopen($inPath, "rb");
        $out=   fopen($outPath, "wb");
        while ($chunk = fread($in,8192)) {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }

    public static function save($inPath, $outPath) {
        $p = new Posters();
        $p->saveImage($inPath, $outPath);
    }


//    function saveImage($img, $savePath) {
//        if (!file_exists($img)) {
//            //throw new InvalidArgumentException('Error: No file at: ' . $img);
//        }
//
//        $ch = curl_init ($img);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
//        $rawdata = curl_exec($ch);
//        if ($rawdata === false) {
//            throw new InvalidArgumentException('Error: No image at: ' . $img . '. Msg: ' . curl_error($ch));
//        }
//        curl_close ($ch);
//
//        if(file_exists($savePath)) {
//            unlink($savePath);
//        }
//
//        $fp = fopen($savePath, 'x');
//        fwrite($fp, $rawdata);
//        fclose($fp);
//    }

    function ifFileExist($file, $path) {
        if (!preg_match("/(.+)\.[a-z]{2,4}$/i", $file)) {
            return false;
        }
        
        if (!is_readable($path . $file)) {
            return $file;
        }
        $i = 1;
        do {
            $newFile = "[$i]_" . $file;
            $i++;
        } while(is_readable($path . $newFile));
        return $newFile;
    }


}

?>
