<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of subtitles
 *
 * @author morre95
 */
class Subtitles extends Tv_Info {

    public static function facory($name, $lang, $type = 'serie') {
        if ($lang == 8) {
            $obj = new S4u(new self);
            $link = $obj->get($name, $type);
        } else {
            $obj = new S4u(new self);
            $link = $obj->get($name, $type);
        }
        return $link;
    }
}
?>
