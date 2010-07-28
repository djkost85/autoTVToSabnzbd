<?php

class Sabnzbd_History extends Sabnzbd {

    protected $_slotsArray = array();

    public function getHistory() {

        $query = array(
                'mode' => 'history',
                'output' => 'json',
                'apikey' => $this->_apiKey
        );
        $sendTo = $this->_sabUrl . '?' . http_build_query($query);
        $json = json_decode($this->send($sendTo));
        if (isset($json->status) && !$json->status) {
            throw new RuntimeException($json->error);
        }

        $this->prepareHistory($json->history, $this->_apiKey);
        $slots = $this->getSlots();
        if ($slots !== null) {
            $json->history->slots = $slots;
        }

        return $json->history;
    }

    protected function prepareHistory(stdClass $json, $apiKey) {
        foreach ($json->slots as $key => $value) {
            //?mode=history&name=delete&value=SABnzbd_nzo_zt2syz
            $value->deleteLink = sprintf("%s?mode=history&name=delete&value=%s&apikey=%s", $this->_sabUrl, $value->nzo_id, $apiKey);
            $this->_slotsArray[$key] = $value;
        }

    }

    protected function getSlots() {
        return $this->_slotsArray;
    }
}

?>
