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
                        <?php echo HTML::anchor('#', HTML::image("images/black/banner/fringe.jpg", array('alt' => 'Top Banner')), array('title' => 'Top Banner', 'class' => 'adhere'));?>
                    </div>
    <h1><?php echo $title?></h1>
    <?php if (MsgFlash::has()) { ?><p class="success"><?php echo HTML::entities(MsgFlash::get())?></p> <?php } ?>
    <?php if (MsgFlash::hasError()) { ?><p class="error"><?php echo HTML::entities(MsgFlash::get(true))?></p> <?php } ?>

    <form id="submitform" action="<?php echo URL::site('renamer/index')?>" method="get">
        <p>
            <label for="path"><?php echo __('Path')?>:</label>
            <input type="text" name="path" id="path" />
        </p>

        <p class="submit">
            <input class="button" type="submit" value="<?php echo __('Rename')?>" />
        </p>
    </form>
    <p>
        <?php if (isset($directorys)) { ?>
        <?php echo '<h2>'.__('Select').'</h2>'?>
        <ul>
        <?php  foreach ($directorys as $dir) { ?>
            <li><?php echo HTML::anchor('renamer/folder/?path=' . urldecode($dir), $dir)?></li>
        <?php } ?>
        </ul>
        <?php } else if (isset($folder)) { ?>

        <?php } ?>
    </p>
        </div>
        <!-- main ends -->
    </div>
