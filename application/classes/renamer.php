<?php defined('SYSPATH') or die('No direct script access.');


class Renamer {

    protected $_movieExt = array('mkv', 'wmv', 'avi', 'mpg', 'mpeg', 'mp4', 'm2ts', 'iso');
    protected $_nfoExt = array('*.nfo');
    protected $_videoCodecs = array('x264', 'DivX', 'XViD');
    protected $_deleteExt = array('sub', 'srt', 'idx', 'ssa', 'ass');

    protected $_minimalFileSize = 31457280; # 1024 * 1024 * 30 = 30MB

    protected $_pathString;
    protected $_deleteSmallFiles = false;
    protected $_deleteUnnecessaryFiles = false;

    public function __construct(array $options) {
        $this->setPathString($options['pathString']);
        $this->_deleteSmallFiles = $options['deleteSmallFiles'];

        if (isset($options['deleteUnnecessaryFiles'])) {
            $this->_deleteUnnecessaryFiles = $options['deleteUnnecessaryFiles'];
        }
        
        if (isset($options['minimalFileSize'])) {
            $this->setMinSize($options['minimalFileSize']);
        }

        if (isset($options['deleteExt'])) {
            $this->setDeleteExt($options['deleteExt']);
        }
    }

    public function setDeleteExt($ext) {
        $this->_deleteExt = preg_split("/[\s,\.]+/", $ext);
    }

    public function setMinSize($int) {
        if (!is_numeric($int)) {
            throw new InvalidArgumentException('Minimal file size is not a number');
        }
        $this->_minimalFileSize = (1024 * 1024 * $int);
    }

    public function setPathString($str) {
        if (substr( $str, -strlen( '.:ext' ) ) != '.:ext') {
            $str = rtrim($str, '.') . '.:ext';
        }

        if (preg_match('/[:\/\w]([\s]+\.:ext)/', $str, $match)) {
            $str = preg_replace('/([\s]+\.:ext)/', '.:ext', $str);
        }

        $this->_pathString = $str;
    }

    public function rename($path, $onlyFiles = false) {
        $objects = new ListFile($path);
        foreach($objects as $obj) {
            $name = $obj->getPath().DIRECTORY_SEPARATOR.$obj->getFilename();
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($this->_deleteSmallFiles && in_array($ext, $this->_movieExt) && $obj->getSize() < $this->_minimalFileSize) {
                unlink($name);
                continue;
            }

            if ($this->_deleteUnnecessaryFiles && in_array($ext, $this->_deleteExt)) {
                unlink($name);
                continue;
            }

            $newFilename = $this->setFilename($name, $obj);

            if ($newFilename === null) {
//                var_dump(basename($name));
                continue;
            }

//            var_dump($newFilename);
//            exit;

            if ($onlyFiles) {
                $newFilename = dirname($name) . DIRECTORY_SEPARATOR . basename($newFilename);
            } else {
                $directory = dirname($newFilename);
                if (!is_dir($directory) && !mkdir($directory, 0777, TRUE)) {
                    throw new RuntimeException("Failed to create directory : $directory");
                }
//                var_dump($directory);
                chmod($directory, 0777);
            }

            if (!rename($name, $newFilename)) {
                throw new RuntimeException("FAILED, Could not rename $name to  $newFilename. Check Permissions");
            }

        }
//        if (!rmdir($objects->getPath())) {
//            throw new RuntimeException("Failed to remove directory : " . dirname($objects->getPath()));
//        }
        if (!$onlyFiles && dirname($newFilename) != $objects->getPath()) {
            if (!Helper_Path::delete_dir_recursive($objects->getPath())) {
                throw new RuntimeException("Failed to remove directory : " . dirname($objects->getPath()));
            }
        }
    }

    protected function setFilename($name, SplFileInfo $obj) {
        $filename = dirname($obj->getPath());
        $parser = new NameParser(basename($name));
        $p = $parser->parse();

        if ($p === null) {
            return null;
        }

        $p['name'] = str_replace('.', ' ', $p['name']);
        $p['name'] = rtrim($p['name'], '- ');
        $pre = $p;

//        var_dump($p);
//        exit;

        $pre['season'] = intval($p['season']);
        $pre['episode'] = intval($p['episode']);
        $pre['ep_string'] = sprintf('S%02dE%02d', $p['season'], $p['episode']);
        $pre['ext'] = pathinfo($name, PATHINFO_EXTENSION);
        $pre['ep_name'] = $this->getEpName($p);
        $pre['name'] = ucfirst($pre['name']);

        $filename = dirname($obj->getPath());

        $search = array_map(create_function('$val', 'return ":" . $val;'), array_keys($pre));

        $filename .= '/' . str_replace($search, array_values($pre), $this->_pathString);
        $filename = str_replace(array('//', '\/'), array('/', '\\'), $filename);

        return Helper_Path::safeFilename($filename);
    }

    protected function getEpName(array $p) {
        $series = ORM::factory('series');
        $result = $series->search($p['name']);

        if ($result->count() <= 0) {
            return $this->getEpNameTheTvDb($p);
        }

        $ep = ORM::factory('episode')->where('series_id', '=', $result->current()->id)
                ->and_where('season', '=', intval($p['season']))
                ->and_where('episode', '=', intval($p['episode']))->find();

        return ($ep->episode_name !== null) ? $ep->episode_name : $this->getEpNameTheTvDb($p);
    }

    protected function getEpNameTheTvDb(array $p) {
        try {
            $tv = new TheTvDB(Kohana::config('default.default.TheTvDB_api_key'), $p['name']);
            $info = $tv->getSeriesInfo();
        } catch (InvalidArgumentException $e) {
            Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));
        } catch (RuntimeException $e) {
            if ($e->getCode() == 404) {
                Kohana::$log->add(Kohana::ERROR, __('Either thetvdb.com is down or you have entered the wrong api key'));
                return;
            }
            Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));
            return;
        }

        foreach ($info->Episode as $ep) {
            if ($p['season'] == (string) $ep->SeasonNumber && $p['episode'] == (string) $ep->EpisodeNumber) {
                return (string) $ep->EpisodeName;
            }
        }

        return null;
    }

}

?>

<?php
/* Anime Rename script v1.0 by Werner Buck
 *
 * Searches directory recursively for .mkv/.avi/.mp4 video files.
 * When found it tries to find the season and episode on www.thetvdb.com to rename
 * the file so it can be correctly scraped by XBMC's TvDB scraper.
 *
 * Can be used for SABnzbd and or as standalone script
 * Requires:
 * - PHP-CLI (ubuntu apt-get install php5-cli)
 * - Correct permissions.
 * Could work for windows not tested.
 *
 * Example command:
 * php -f procanime.php -- '/storage/Anime/Mobile Suit Gundam 00/'
 */

/*error_reporting(0);

if ($argc == 1 || $argv[1] == '--help' || $argv[1] == '/?' || $argv[1] == '-help') {
	fwrite(STDOUT, "Anime Rename script v1.0\n\nSearches directory recursively for .mkv/.avi/.mp4 video files.\nWhen found it tries to find the season and episode on www.thetvdb.com to rename\nthe file so it can be correctly scraped by XBMC's TvDB scraper.\n\nCan be used for SABnzbd and or as standalone script\nRequires:\n- PHP-CLI (ubuntu apt-get install php5-cli)\n- Correct permissions.\nCould work for windows not tested.\n\nExample command:\nphp -f ".$argv[0]." -- '/storage/Anime/Mobile Suit Gundam 00/'\n");
} elseif ($argc > 1) {
	$directory = "";
	for ($i=1; $i < count ($argv); $i++) {
		if ($i != 1) {
			$directory .= ' ';
		}
		$directory .= $argv[$i] . '';
	}
	//remove trailing slash
	if ('/' == substr($directory, strlen($directory)-1)) {
		$directory = substr_replace($directory, '', strlen($directory)-1);
	}
	$status = rec_listFiles($directory);
	if ($status === false) {
		fwrite(STDOUT, "FAILED, directory does not exist or is not accessible. Make sure your permissions are properly setup.\n");
	} else {
		for ($i=0; $i < count($status); $i++) {

			$fullfile = $status[$i];
			$file = basename($fullfile);
			$dirname = dirname($fullfile);
			$extension = get_extension($file);
			if ($extension == ".mkv" || $extension == ".avi" || $extension == ".mp4") {
				$result = animealize($file);
				if ($result['status'] == 1) {
					fwrite(STDOUT, $result['output']);
					fwrite(STDOUT, "FAILED, Show not found on TheTVDB.com.\n\n");
				} elseif ($result['status'] == 2) {
					fwrite(STDOUT, $result['output']);
					fwrite(STDOUT, "FAILED, Absolute number not found on TheTVDB.com for this show.\n\n");
				} elseif ($result['status'] == 3) {
					fwrite(STDOUT, $result['output']);
					fwrite(STDOUT, "SKIPPED, Already named correctly.\n");
				} elseif ($result['status'] == 4) {
					fwrite(STDOUT, $result['output']);
					//Do actual rename here:
					$worked = rename($fullfile, $dirname . '/' . $result['filename']);
					if ($worked === false) {
						fwrite(STDOUT, "FAILED, Could not rename ".$fullfile." to  ".$dirname."/".$result['filename'].". Check Permissions!\n\n");
					} else {
						fwrite(STDOUT, "SUCCESS, Renamed from ".$fullfile." to  ".$dirname."/".$result['filename']."\n\n");
					}
			}
			}
		}
	}
}

function animealize ($file) {
	$output = $file . "\n";
	if (preg_match('/(S|s)([0-9]+)(E|e)([0-9]+)/', $file, $match) == 0) {
		$result = get_show_name(rid_extension($file));
		$output .= "Show name: " . $result . "\n";
		$seasonarray = get_season_number($result);
		$output .= "Possible season number: " . $seasonarray['res'] . "\n";
		$episodearray = get_episode_number($result);
		$output .= "Episode number: " . $episodearray['res'] . "\n";
		$cleanshowname = $result;
		if ($seasonarray) {
			$cleanshowname = trim(str_replace($seasonarray['del'],'',$cleanshowname));
		}
		$cleanshowname = trim(str_replace($episodearray['del'],'',$cleanshowname));
		$output .= "Clean Show Name: " . $cleanshowname . "\n";
		$tvdb_series_info = get_tvdb_seriesinfo($cleanshowname);
		if ($tvdb_series_info === false) {
			return array('status' => '1', 'output' => $output);
		}
		$output .= "TheTVDB Series Name: " . $tvdb_series_info['name'] . "\n";
		$output .= "TheTVDB Series ID: " . $tvdb_series_info['id'] . "\n";
		$tvdb_episode_info = get_tvdb_episodeinfo($tvdb_series_info['id'], $episodearray['res'], $seasonarray['res']);
		if ($tvdb_episode_info === false) {
			return array('status' => '2', 'output' => $output);
		}
		$output .= "TheTVDB Series Season: " . $tvdb_episode_info['season'] . "\n";
		$output .= "TheTVDB Series Episode: " . $tvdb_episode_info['episode'] . "\n";
		$new_filename = gen_proper_filename($file, $tvdb_episode_info['episode'], $tvdb_episode_info['season']);
	} else {
		return array('status' => '3', 'output' => $output);
	}
	return array('status' => '4', 'output' => $output, 'filename' => $new_filename);
}


function gen_proper_filename($input, $episode, $season) {
	$delimiter = '.';
	$extension = get_extension($input);
 	$output = rid_extension($input);
	if ($episode > 99) {
		$string = 'S' . str_pad($season, 2, "0", STR_PAD_LEFT) . 'E' . str_pad($episode, 3, "0", STR_PAD_LEFT);
	} else {
		$string = 'S' . str_pad($season, 2, "0", STR_PAD_LEFT) . 'E' . str_pad($episode, 2, "0", STR_PAD_LEFT);
	}
	$output = $output . $delimiter . $string . $extension;
	return $output;
}

function get_tvdb_seriesinfo($input) {
	$thetvdb = "http://www.thetvdb.com/";
	$result = file_get_contents($thetvdb . 'api/GetSeries.php?seriesname='.urlencode($input));
	$postemp1 = strpos($result, "<seriesid>") + strlen("<seriesid>");
	$postemp2 = strpos($result, "<", $postemp1);
	$seriesid = substr($result, $postemp1, $postemp2 - $postemp1);
	if (is_numeric($seriesid) === false) {
		return false;
	}
	$postemp1 = strpos($result, "<SeriesName>") + strlen("<SeriesName>");
	$postemp2 = strpos($result, "<", $postemp1);
	$seriesname = substr($result, $postemp1, $postemp2 - $postemp1);
	$tvdb = array('id' => $seriesid, 'name' => $seriesname);
	return $tvdb;
}

function get_tvdb_episodeinfo($seriesid, $episode, $season) {
	if (empty($season)) {
		$thetvdb = "http://www.thetvdb.com/";
		$result = file_get_contents($thetvdb . 'api/F0A9519B01D1C096/series/'.$seriesid.'/absolute/'.$episode.'/');
		if ($result === false) {
			return false;
		}
		$postemp1 = strpos($result, "<Combined_episodenumber>") + strlen("<Combined_episodenumber>");
		$postemp2 = strpos($result, "<", $postemp1);
		$episodenumber = substr($result, $postemp1, $postemp2 - $postemp1);
		$postemp1 = strpos($result, "<Combined_season>") + strlen("<Combined_season>");
		$postemp2 = strpos($result, "<", $postemp1);
		$episodeseason = substr($result, $postemp1, $postemp2 - $postemp1);
		$tvdb = array('episode' => $episodenumber, 'season' => $episodeseason);
	} else {
		$tvdb = array('episode' => $episode, 'season' => $season);
	}
	return $tvdb;
}

function get_show_name($input) {
	$pattern = '/' . '\[[^]]+\]|\([^]]+\)' . '/i';
	$result = preg_replace($pattern,"",$input);
	$result = str_replace("-", " ",$result);
	$result = str_replace("_", " ",$result);
	$result = str_replace(".", " ",$result);
	// remove double spaces in the middle
	while (sizeof ($array=explode ("  ",$result)) != 1)
	{
 		 $result = implode (" ",$array);
	}
	return trim($result);
}

function rid_extension($thefile) {
	if (strpos($thefile,'.') === false) {
		return $thefile;
	} else {
		return substr($thefile, 0, strrpos($thefile,'.'));
	}
}

function get_extension($thefile) {
	return substr($thefile, strrpos($thefile,'.'));
}

function get_episode_number($input) {
	if (preg_match('/' . '(E|e)([0-9]+)' . '/', $input, $episodenumber) > 0) {
		$episodenumber = array('del' => $episodenumber[0], 'res' => $episodenumber[2]);
		return $episodenumber;
	} else {
		preg_match_all('/' . '[0-9]+' . '/', $input, $matches);
		//Kijk voor alle episodes
		$matches = $matches[0];
		for ($i=0; $i < count($matches); $i++) {
			$lastnum = $matches[$i];
		}
		$lastnum = array('del' => $lastnum, 'res' => $lastnum);
		return $lastnum;
	}
}

function get_season_number($input) {
	$pattern = '/' . '(S|s)([0-9]+)' . '/';
	if (preg_match($pattern, $input, $match) > 0) {
		$match = array('del' => $match[0], 'res' => $match[2]);
		return $match;
	} else {
		return false;
	}
}

function rec_listFiles( $from = '.')
{
    if(! is_dir($from))
        return false;

    $files = array();
    if( $dh = opendir($from))
    {
        while( false !== ($file = readdir($dh)))
        {
            // Skip '.' and '..'
            if( $file == '.' || $file == '..')
                continue;
            $path = $from . '/' . $file;
            if( is_dir($path) )
                $files=array_merge($files,rec_listFiles($path));
            else
                $files[] = $path;
        }
        closedir($dh);
    }
    return $files;
}
 */
?>

