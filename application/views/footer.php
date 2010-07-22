<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="footer">
    <ul>
        <li><?php echo HTML::anchor(URL::query(array('lang' => 'se')), HTML::image('images/flags/se.png', array('alt' => 'Language icon')))?></li>
        <li><?php echo HTML::anchor(URL::query(array('lang' => 'en')), HTML::image('images/flags/en.png', array('alt' => 'Language icon')))?></li>
        <li><?php echo HTML::image('images/flags/no.png', array('alt' => 'Language icon'))?></li>
        <li><?php echo HTML::image('images/flags/da.png', array('alt' => 'Language icon'))?></li>
        <li><?php echo HTML::image('images/flags/fi.png', array('alt' => 'Language icon'))?></li>
        <li><?php echo HTML::image('images/flags/fr.png', array('alt' => 'Language icon'))?></li>
        <li><?php echo HTML::image('images/flags/ge.png', array('alt' => 'Language icon'))?></li>
    </ul>
</div>
