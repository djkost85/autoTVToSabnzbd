<?php defined('SYSPATH') or die('No direct script access.'); ?>

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

            <form id="submitform" action="<?php echo URL::site('config/saveDb')?>" method="get">
                <p>
                    <label for="host">Host:</label>
                    <input type="text" name="host" id="host" />
                </p>
                <p>
                    <label for="user">Username:</label>
                    <input type="text" name="user" id="user" />
                </p>
                <p>
                    <label for="pass">Password:</label>
                    <input type="password" name="pass" id="pass" />
                </p>
                <p>
                    <label for="database">Database</label>
                    <input type="text" name="database" id="database" />
                </p>
                <p>
                    <input class="button"  type="submit" value="<?php echo __('Save')?>" />
                </p>
            </form>

            <?php echo HTML::anchor('#', HTML::image("images/black/banner/star-wars.jpg", array('alt' => 'Bottom Banner', 'class' => 'banner')));?>
            <div class="clearer"></div>
        </div>
    <!-- main ends -->
    </div>
