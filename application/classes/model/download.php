<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of download
 *
 * @author Morre95
 */
class Model_Download extends ORM {

    protected $_belongs_to = array('episode' => array());

    protected $_created_column = array('format' => 'Y-m-d H:i:s', 'column' => 'modified');

    
}
?>
