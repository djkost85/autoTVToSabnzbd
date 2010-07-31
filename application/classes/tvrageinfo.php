<?php defined('SYSPATH') or die('No direct script access.');

class TvRageInfo extends Tv_Info {

    protected $infoUrl = "http://services.tvrage.com/tools/quickinfo.php";
    protected $episodeListUrl = "http://services.tvrage.com/feeds/episode_list.php";

    public function  __construct() {

    }

    public function getInfo($name, $ep="", $exact="") {
        $url = $this->infoUrl . "?show=" . urlencode($name) . '&ep=' . urlencode($ep) . '&exact=' . urlencode($exact);
        $lines = file($url);
        $showInfo = array();
        foreach($lines as $line) {
            if(strlen($line) == 0) continue; //line is empty
            if (strpos($line, 'No Show Results Were') !== false) {
                continue;
            }
            list($prop, $val) = explode('@', $line, 2);
            //var_dump($prop);
            //var_dump($line);
            switch($prop) {
                case 'Latest Episode':
                case 'Episode Info':
                case 'Next Episode':
                    list ($ep, $title, $airdate) = explode('^', $val);
                    $val = array(
                            'episode' => trim($ep),
                            'title' => trim($title),
                            'airdate' => $this->timeAirDate(trim($airdate))
                    );
                    $showInfo[$prop] = $val;
                    break;
                case 'RFC3339':
                    $showInfo['next_timestamp'] = strtotime($val);
                    break;
                case 'Show Name':
                    $showInfo['name'] = trim($val);
                    break;
                case 'Show ID':
                case '<pre>Show ID':
                    $showInfo['tvrageid'] = intval(trim($val));
                    break;
                case 'Show URL':
                    $showInfo['url'] = trim($val);
                    break;
                case 'Status':
                    $showInfo['status'] = trim($val);
                    break;
                case 'Genres':
                    $showInfo['genres'] = trim($val);
                    break;
                case 'Network':
                    $showInfo['network'] = trim($val);
                    break;
                case 'Country':
                    $showInfo['country'] = trim($val);
                    break;
                case 'Airtime':
                    $val = str_replace(' at', '', trim($val));
                    $showInfo['airtime'] = strtotime($val);
                    break;
                case 'Runtime':
                    $showInfo['runtime'] = trim($val);
                    break;
            }
        }

        if(!empty($showInfo['tvrageid'])) {
            $showInfo = array_merge($showInfo, $this->getEpisodeLis($showInfo['tvrageid']));
        }

        return $showInfo;
    }

    function getEpisodeLis($tvrageid) {
        $showInfo = array();

        $tvrage_sxe = simplexml_load_string($this->send($this->episodeListUrl . '?sid=' . $tvrageid));

        //loop over each season
        $seasons = $tvrage_sxe->xpath('/Show/Episodelist/Season');
        foreach($seasons as $season) {
            $showInfo['episodelist'][intval($season['no'])] = array();
            foreach($season->episode as $episode) {
                $showInfo['episodelist'][intval($season['no'])][] = array(
                        'num' => strval($episode->seasonnum),
                        'aired' => strtotime($episode->airdate),
                        'title' => strval($episode->title)
                );
            }
        }

        return $showInfo;
    }

    function timeAirDate($date) {
        $airDate = $date;
        if(substr_count($airDate, '/') == 2) {
            $dateParts = explode('/', $airDate);
            //$airDate = date('(l) F j, Y', strtotime($dateParts[1] . ' ' . $dateParts[0] . ' ' . $dateParts[2]));
            $airDate = strtotime($dateParts[1] . ' ' . $dateParts[0] . ' ' . $dateParts[2]);
        }
        return $airDate;
    }

    function formatEpisode($ep) {
        return 'S' . str_replace('x', 'E', $ep);
    }
}
/*
$tv = new TvRageInfo();
var_dump($tv->getInfo('Breaking Bad'));

$config['tvrage'] = array(
        'quickinfo' => 'http://services.tvrage.com/tools/quickinfo.php',
        'episode_list' => 'http://services.tvrage.com/feeds/episode_list.php'
);

*/
?>
