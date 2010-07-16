<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sabnzbd
 *
 * @author morre95
 */
class Sabnzbd_Queue extends Sabnzbd {
    private $_slotsArray = array();

    public function getQueue() {
        $query = array(
                'mode' => 'queue',
                'output' => 'json',
                'apikey' => $this->_apiKey
        );
        $sendTo = $this->_sabUrl . '?' . http_build_query($query);
        $json = json_decode($this->send($sendTo));
        if (isset($json->status) && !$json->status) {
            throw new RuntimeException($json->error);
        }

        $this->prepareSlots($json->queue, $this->_apiKey);
        $slots = $this->getSlots();
        if ($slots !== null) $json->queue->slots = $slots;
        $json->queue->paused = $this->isPaused($json->queue);
        return $json->queue;
    }

    protected function isPaused(stdClass $json) {
        if (isset($json->paused) && $json->paused) {
            $int = (int) $json->pause_int;
            return ($int == 0) ? true : $int;
        }
        return false;
    }

    protected function prepareSlots(stdClass $json, $apiKey)
    {
        if ($json->slots == "") {
            return null;
        }

        $sabUrl = $this->_sabUrl;
        foreach ($json->slots as $key => $value)
        {
            if ($value instanceof stdClass)
            {
                $nzoId = $value->nzo_id;
				$value->prepCategories = array();
                foreach ($json->categories as $cat) {
                    $query = array(
                        'mode' => 'change_cat',
                        'value' => $nzoId,
                        'value2' => $cat,
                        'apikey' => $apiKey
                    );
                    $value->prepCategories[$cat] = $sabUrl . '?' . http_build_query($query);
                }
                
				$value->prepScripts = array();
                foreach ($json->scripts as $script) {
                    $query = array(
                        'mode' => 'change_script',
                        'value' => $nzoId,
                        'value2' => $script,
                        'apikey' => $apiKey
                    );
                    $value->prepScripts[$script] = $sabUrl . '?' . http_build_query($query);
                }

				$value->prepMove = array();
                for($i=0; $i < $json->noofslots; $i++) {
                    $query = array(
                        'mode' => 'switch',
                        'value' => $nzoId,
                        'value2' => $i,
                        'apikey' => $apiKey
                    );
                    
                    $value->prepMove[$i] = $sabUrl . '?' . http_build_query($query);
                }

                $query = array(
                    'mode' => 'get_files',
                    'value' => $nzoId,
                    'output' => 'json',
                    'apikey' => $apiKey
                );
                $sendTo = $sabUrl . '?' . http_build_query($query);
                $value->prepFiles = json_decode($this->send($sendTo))->files;

                $value->prepFilesUrl = URL::site("queue/updateItem/$nzoId");

                $value->deleteAllLink = sprintf("%s?mode=queue&name=delete&value=all&apikey=%s", $sabUrl, $apiKey);
                $value->deleteLink = sprintf("%s?mode=queue&name=delete&value=%s&apikey=%s", $sabUrl, $nzoId, $apiKey);
                $value->pauseLink = sprintf("%s?mode=queue&name=pause&value=%s&apikey=%s", $sabUrl, $nzoId, $apiKey);
                $value->resumeLink = sprintf("%s?mode=queue&name=resume&value=%s&apikey=%s", $sabUrl, $nzoId, $apiKey);

                $value->processings = array(
                    'Skip' => sprintf("%s?mode=change_opts&value=%s&value2=0&apikey=%s", $sabUrl, $nzoId, $apiKey),
                    'Repair' => sprintf("%s?mode=change_opts&value=%s&value2=1&apikey=%s", $sabUrl, $nzoId, $apiKey),
                    'Repair/Unpack' => sprintf("%s?mode=change_opts&value=%s&value2=2&apikey=%s", $sabUrl, $nzoId, $apiKey),
                    'Repair/Unpack/Delete' => sprintf("%s?mode=change_opts&value=%s&value2=3&apikey=%s", $sabUrl, $nzoId, $apiKey)
                    );

                $value->prioritys = array(
                    'Low' => sprintf("%s?mode=queue&name=priority&value=%s&value2=-1&apikey=%s", $sabUrl, $nzoId, $apiKey),
                    'Normal' => sprintf("%s?mode=queue&name=priority&value=%s&value2=0&apikey=%s", $sabUrl, $nzoId, $apiKey),
                    'High' => sprintf("%s?mode=queue&name=priority&value=%s&value2=1&apikey=%s", $sabUrl, $nzoId, $apiKey)
                    );

                $parse = new NameParser($value->filename);
                $parsed = $parse->parse();

                $series = ORM::factory('series');
                $result = $series->search($parsed['name']);
                if ($result->count() == 1) {
                    $value->filename = array('url' => URL::site('episodes/' . $result->get('id')), 'title' => $value->filename);
                }

                $value->paused = false;
                if ($value->status == 'Paused') {
                    $value->paused = 1;
                }

                $this->_slotsArray[$key] = $value;
            }
            else
            {
                $this->_slotsArray[$key] = $value;
            }
        }
    }

    function getSlots()
    {
        return $this->_slotsArray;
    }

    public function setName($item, $name) {
    //mode=queue&name=rename&value=SABnzbd_nzo_zt2syz&value2=THENEWNAME
        $query = array(
                'mode' => 'queue',
                'name' => 'rename',
                'value' => $item,
                'value2' => $name,
                'output' => 'json',
                'apikey' => $this->_apiKey
        );
        $sendTo = $this->_sabUrl . '?' . http_build_query($query);
        $json = json_decode($this->send($sendTo));
    }

    public function getItemInfo($id) {
        //mode=get_files&output=xml&value=SABnzbd_nzo_zt2syz
        $query = array(
                'mode' => 'get_files',
                'value' => $id,
                'output' => 'json',
                'apikey' => $this->_apiKey
        );
        $sendTo = $this->_sabUrl . '?' . http_build_query($query);
        $json = json_decode($this->send($sendTo));
        return $json;
    }

    public function setCompleteAction($scriptName) {
        //mode=queue&name=change_complete_action&value=hybernate_pc
        $query = array(
                'mode' => 'queue',
                'name' => 'change_complete_action',
                'value' => $scriptName,
                'output' => 'json',
                'apikey' => $this->_apiKey
        );
        $sendTo = $this->_sabUrl . '?' . http_build_query($query);
        $json = json_decode($this->send($sendTo));
    }

}




/*protected function prepareSlots(stdClass $json, $apiKey)
    {
        if ($json->slots == "") {
            return null;
        }

        $sabUrl = $this->_sabUrl;
        foreach ($json->slots as $key => $value)
        {
            if ($value instanceof stdClass)
            {
                $nzoId = $value->nzo_id;
                $categories = $json->categories;
                $value->getCategories = function () use ($nzoId, $categories, $apiKey, $sabUrl) {
                    $return = array();
                    foreach ($categories as $cat) {
                        $query = array(
                            'mode' => 'change_cat',
                            'value' => $nzoId,
                            'value2' => $cat,
                            'apikey' => $apiKey
                        );
                        $sendTo = $sabUrl . '?' . http_build_query($query);
                        $return[$cat] = $sendTo;
                    }
                    return $return;
                };

                $scripts = $json->scripts;
                $value->getScripts = function () use($nzoId, $scripts, $apiKey, $sabUrl) {
                    $return = array();
                    foreach ($scripts as $script) {
                        $query = array(
                            'mode' => 'change_script',
                            'value' => $nzoId,
                            'value2' => $script,
                            'apikey' => $apiKey
                        );
                        $sendTo = $sabUrl . '?' . http_build_query($query);
                        $return[$script] = $sendTo;
                    }
                    return $return;
                };

                $noofslots = $json->noofslots;
                $value->getMove = function () use($nzoId, $noofslots, $apiKey, $sabUrl) {
                    $return = array();
                    for($i=0; $i < $noofslots; $i++) {
                        $query = array(
                            'mode' => 'switch',
                            'value' => $nzoId,
                            'value2' => $i,
                            'apikey' => $apiKey
                        );
                        $sendTo = $sabUrl . '?' . http_build_query($query);
                        $return[$i] = $sendTo;
                    }
                    return $return;
                };

                $value->getFiles = function () use($nzoId, $apiKey, $sabUrl) {
                    $query = array(
                        'mode' => 'get_files',
                        'value' => $nzoId,
                        'output' => 'json',
                        'apikey' => $apiKey
                    );
                    $sendTo = $sabUrl . '?' . http_build_query($query);
                    $json = json_decode(file_get_contents($sendTo));
                    return $json->files;
                };

                $value->getFilesUrl = URL::site("queue/updateItem/$nzoId");

                $value->deleteAllLink = sprintf("%s?mode=queue&name=delete&value=all&apikey=%s", $sabUrl, $apiKey);
                $value->deleteLink = sprintf("%s?mode=queue&name=delete&value=%s&apikey=%s", $sabUrl, $nzoId, $apiKey);
                $value->pauseLink = sprintf("%s?mode=queue&name=pause&value=%s&apikey=%s", $sabUrl, $nzoId, $apiKey);
                $value->resumeLink = sprintf("%s?mode=queue&name=resume&value=%s&apikey=%s", $sabUrl, $nzoId, $apiKey);

                $value->processings = array(
                    'Skip' => sprintf("%s?mode=change_opts&value=%s&value2=0&apikey=%s", $sabUrl, $nzoId, $apiKey),
                    'Repair' => sprintf("%s?mode=change_opts&value=%s&value2=1&apikey=%s", $sabUrl, $nzoId, $apiKey),
                    'Repair/Unpack' => sprintf("%s?mode=change_opts&value=%s&value2=2&apikey=%s", $sabUrl, $nzoId, $apiKey),
                    'Repair/Unpack/Delete' => sprintf("%s?mode=change_opts&value=%s&value2=3&apikey=%s", $sabUrl, $nzoId, $apiKey)
                    );

                $value->prioritys = array(
                    'Low' => sprintf("%s?mode=queue&name=priority&value=%s&value2=-1&apikey=%s", $sabUrl, $nzoId, $apiKey),
                    'Normal' => sprintf("%s?mode=queue&name=priority&value=%s&value2=0&apikey=%s", $sabUrl, $nzoId, $apiKey),
                    'High' => sprintf("%s?mode=queue&name=priority&value=%s&value2=1&apikey=%s", $sabUrl, $nzoId, $apiKey)
                    );

                $parse = new NameParser($value->filename);
                $parsed = $parse->parse();

                $series = ORM::factory('series');
                $result = $series->search($parsed['name']);
                if ($result->count() == 1) {
                    $value->filename = array('url' => URL::site('episodes/' . $result->get('id')), 'title' => $value->filename);
                }

                $value->paused = false;
                if ($value->status == 'Paused') {
                    $value->paused = 1;
                }

                $this->_slotsArray[$key] = $value;
            }
            else
            {
                $this->_slotsArray[$key] = $value;
            }
        }
    }*/
?>
