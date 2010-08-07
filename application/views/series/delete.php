<?php
defined('SYSPATH') or die('No direct script access.');
?>

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
                <?php echo HTML::anchor('', HTML::image("images/black/banner/fringe.jpg", array('alt' => 'Top Banner')), array('title' => 'Top Banner', 'class' => 'adhere'));?>
            </div>

            <h1><?php echo $title; ?></h1>
            <?php if (empty($series)) { ?>
                <h1><?php echo $noSeries?></h1>
            <?php } ?>
                
            <?php if (MsgFlash::has()) { ?><p class="success"><?php echo HTML::entities(MsgFlash::get())?></p> <?php } ?>

            <?php 
            if ($series->poster == "") {
                $poster = "images/black/noPoster.gif";
            } else {
                $poster = 'index.php/' . $series->poster . '/281';
            }
            ?>
            <div class="deleteBox">
                <?php echo HTML::anchor("episodes/$series->id", $series->series_name)?><br />
                <?php echo HTML::anchor(
                    "http://www.thetvdb.com/?tab=series&id=$series->tvdb_id",
                    HTML::image($poster, array('alt' => 'Poster for ' . $series->series_name)),
                    array('class' => 'ajaxTooltip', 'rel' => URL::site("series/getInfo/$series->id"))
                );?>

                <p><?php echo __('Delete')?> "<?php echo $series->series_name ?>"?<br />
                <?php echo HTML::anchor("series/doDelete/$series->id", __('Yes'))?> |
                <?php echo HTML::anchor("", __('No'))?></p>
            </div>
        </div>
        <!-- wrap ends -->
    </div>
