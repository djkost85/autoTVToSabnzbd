<?php defined('SYSPATH') or die('No direct script access.');  $session = Session::instance(); ?>
<ul id="nav">
    <li><?php echo HTML::anchor('', __('Home'))?></li>
    <li><?php echo HTML::anchor('series/add', __('New series'))?></li>
    <li><?php echo HTML::anchor('download/listAll', __('Download list'))?></li>
    <li><?php echo HTML::anchor('search/index', __('Search'))?></li>
    <li><?php echo HTML::anchor('queue/index', __('Queue'))?></li>
    <li><?php echo HTML::anchor('update/all', __('Update all'))?></li>
    <li><?php echo HTML::image('images/flags/'.I18n::lang().'.png', array('alt' => 'Current language icon'))?>
        <ul>
            <li><?php echo HTML::anchor(URL::query(array('lang' => 'se')), HTML::image('images/flags/se.png', array('alt' => 'Language icon')))?></li>
            <li><?php echo HTML::anchor(URL::query(array('lang' => 'en')), HTML::image('images/flags/en.png', array('alt' => 'Language icon')))?></li>
        </ul>
    </li>
</ul>

