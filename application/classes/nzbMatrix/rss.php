<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nzbMatrix
 *
 * @author morre95
 */
class NzbMatrix_Rss extends NzbMatrix {

    public function  __construct($apiKey) {
        parent::__construct($apiKey);
//        $this->searchUrl = "http://services.nzbmatrix.com/rss.php";
    }

//    public function search($search, $catId = "6") {
//        //http://services.nzbmatrix.com/rss.php?page=details&subcat=6&term=lost
//        $query = array(
//                'term' => $search,
//                'subcat' => $catId,
//                'page' => 'details',
//        );
//
//        $url = $this->searchUrl . '?' . http_build_query($query);
//
//        $this->searchResult = $this->getXml($url);
//        return $this->searchResult->channel;
//    }
}
?>
