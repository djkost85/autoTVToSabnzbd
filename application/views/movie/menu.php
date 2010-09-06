<?php defined('SYSPATH') or die('No direct script access.'); ?>
 <!--header -->
<div id="header">
    <div id="logo"><?php echo HTML::anchor('',HTML::image('images/black/logo.gif', array('alt' => 'logo')))?></div>

    <div id="nav">
        <ul>
            <li><?php echo HTML::anchor('', __('Series'))?></li>
            <li id="movie_li"><?php echo HTML::anchor('movie/index', __('Movie'), array('id' => 'movie_link'))?></li>
            <li id="add_movie_li"><?php echo HTML::anchor('movie/add', __('New'), array('id' => 'add_movie_link'))?></li>
            <li id="last"><?php echo HTML::anchor('movie/rss', __('RSS'), array('id' => 'rss_link'))?></li>
        </ul>
    </div>
    <!--header ends-->
</div>

