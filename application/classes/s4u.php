<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of s4u
 *
 * @author morre95
 */
class S4u {

    protected $_url = "http://www.s4u.se/xml.php";
    protected $_tv_info;

    public function  __construct(Tv_Info $tv_info) {
        $this->_tv_info = $tv_info;
    }

    public function get($name, $type) {
        $query = array(
                'q' => $name,
                'type' => $type,
                'limit' => '15',
        );

        $url = $this->_url . '?' . http_build_query($query);

        $result = $this->_tv_info->getXml($url);

//        var_dump(count($result->xmlsearch->sub));
//        var_dump($result);
        if (count($result->xmlsearch->sub) == 1) return (string) $result->xmlsearch->sub->file;
        else if (count($result->xmlsearch->sub) < 1) return null;
        else return $this->fileArray($result->xmlsearch->sub);
    }

    protected function fileArray($xml) {
        $return = array();
        foreach ($xml as $value) {
            $return[] = (string) $value->file;
        }
        return $return;
    }
}
?>
