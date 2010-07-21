<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nzbindex
 *
 * @author morre95
 */
class Nzbindex extends Tv_Info {

    protected $searchUrl = "http://www.nzbindex.nl/rss/";

    public function  __construct() {

    }

    public function search($q) {
//        ?q=Top+Gear+S15E04&sort=agedesc&complete=1&hidecross=1&max=25&more=1
        $query = array(
                'q' => $q,
                'sort' => 'agedesc',
                'complete' => '1',
//                'hidecross' => '1',
                'max' => '25',
                'more' => '1',
                'minsize' => '50',
        );

        $url = $this->searchUrl . '?' . http_build_query($query);
        try {
            $xml = $this->getXml($url);
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
        }

        return $xml;
    }

}
?>
