<?php defined('SYSPATH') or die('No direct script access.');
?>

<style type="text/css">
div.update-wrapper {
    width: 748px;
    padding-top: 20px;
    margin-right: auto;
    margin-left: auto;
}
div.update-wrapper p {
    margin-top: 10px;
}
div.update-wrapper ul {
    margin-top: 5px;
    margin-left: 35px;
}
</style>
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
                        <?php echo HTML::anchor('#', HTML::image("images/black/banner/fringe.jpg", array('alt' => 'Top Banner')), array('title' => 'Top Banner', 'class' => 'adhere'));?>
                    </div>
                    
    <?php if (MsgFlash::has()) { ?><p class="success"><?php echo HTML::entities(MsgFlash::get())?></p> <?php } ?>
    <?php if (MsgFlash::hasError()) { ?><p class="error"><?php echo HTML::entities(MsgFlash::get(true))?></p> <?php } ?>
            
    <p>When you update series, all the episodes marked as downloaded will no longer be marked as downloaded.</p>
    <p>Click <a href="<?php echo URL::site('update/all/series')?>" id="update">here</a> if you want to refresh all series.</p>
    <p>Click <a href="<?php echo URL::site('update/all/rss')?>" id="update">here</a> if you want to refresh the rss feeds.</p>
    <p>This action may take several minutes.</p>
    <p>If you want to use crontab (<a href="http://en.wikipedia.org/wiki/Cron">for linux</a>) or scheduled tasks (for windows) you can use these links:</p>
    <ul>
        <li>Serier: "<?php echo URL::site('update/doAll', true)?>" (update once a week)</li>
        <li>RSS: "<?php echo URL::site('rss/update', true)?>" (update every two hours)</li>
    </ul>
    <p><a href="#">Click here</a> if you want to generate the files needed.</p>
    <div style="display: none">
        <form method="get" action="#">
            <p>
                <label class="noFloting" for="uri_to_php">The path to php.exe (usually: "C:\wamp\bin\php\php5.3.0\php.exe")</label>
                <input type="text" name="path_to_php" value="<?php echo $phpPath?>" size="45" />
            </p>
            <p>
                <input type="submit" name="rss" value="Generate RSS file" />
                <input type="submit" name="series" value="Generate Series file" />
            </p>
        </form>
        <p>Some browsers attach .htm or the like as file extension. You must remove it to make this work</p>
    </div>
        </div>
                    </div>
                    <!-- main ends -->
                </div>


<script type="text/javascript">
$('a[href="#"]').click(function () {
    $('div[style]').toggle();
})
</script>
