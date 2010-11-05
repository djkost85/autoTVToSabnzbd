<?php defined('SYSPATH') or die('No direct script access.'); ?>

<!-- wrap starts here -->
<div id="wrap">
<!-- content-wrap starts -->
<div id="content-wrap">
    <div id="googleHeader">
        Downloads from <a href="http://nzbmatrix.com/" title="NZBMatrix.com">NZBMatrix.com</a>
    </div>



    <form id="form-search" action="<?php echo URL::site('search/result')?>" method="get">
        <input class="input-text" name="q" type="text" />
        <input name="where" value="site" type="hidden" />
        <input class="input-button" name="search" value="" type="submit" />
    </form>

    <div id="main">
        <div class="inner">
            <div class="top-banner">
                <a href="<?php echo URL::site()?>"><div></div></a>
                <?php //echo HTML::anchor('', HTML::image("images/black/banner/fringe.jpg", array('alt' => 'Top Banner')), array('title' => 'Top Banner', 'class' => 'adhere')); ?>
            </div>

            <h1 class="float-left"><?php echo $title; ?></h1>
            <div class="clearer"></div>
            <?php if (empty($series)) { ?>
                <h1 class="page-title"><?php echo $noSeries?></h1>
            <?php } ?>

            <?php if (MsgFlash::has()) { ?><p class="success"><?php echo HTML::entities(MsgFlash::get())?></p> <?php } ?>
            <?php if (MsgFlash::hasError()) { ?><p class="error"><?php echo HTML::entities(MsgFlash::get(true))?></p> <?php } ?>

            <div class="deleteBox">
            <h2><?php echo sprintf('%s S%02dE%02d', $series->series_name, $ep->season, $ep->episode)?></h2>
            <?php echo HTML::image($ep->filename,
                                array('alt' => 'Poster for ' . sprintf('%s S%02dE%02d', $series->series_name, $ep->season, $ep->episode)
                                        )); ?>
            <?php foreach($subs as $id => $sub) { ?>
                <div><?php echo __('Download episode')?>: <?php echo HTML::anchor("download/episode/$id", $sub['title'], array('title' => __('Download episode'))); ?></div>
                <?php echo  HTML::anchor("download/dlSub/$id", __('Download subtitle'), array('target' => '_blank')); ?>
            <?php } ?>
                </div>
        </div>
    <!-- main ends -->
    </div>