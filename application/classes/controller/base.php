<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of base
 *
 * @author Morre95
 */
class Controller_Base extends Controller {

    public function before() {
        if (Request::$is_ajax) {
            $this->request->action = 'ajax_'.$this->request->action;
        }
        parent::before();
    }

    public function after() {
        parent::after();
    }
    
}
?>
