<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php echo $menu?>
<h1 class="page-title episodes-title"><?php echo HTML::anchor("", HTML::image('index.php/' . $banner, array('alt' => "Banner for $seriesName")))?></h1>
<p class="msg"><?php if (isset($_GET['msg'])) echo HTML::entities($_GET['msg'])?></p>
<div id="banner"><?php //echo HTML::image('index.php/' . $banner, array('alt' => "Banner for $seriesName"))?></div>
<?php
//echo $pagination;
foreach ($episodes as $ep) {

    if ($ep->posterMsg != "") {
        echo "<li>$ep->posterMsg</li>";
    }
    ?>

    <ul class="list episodes">
        <li class="img">
            <a href="<?php echo URL::site($ep->posterFile)?>">
                <?php echo HTML::image('index.php/' . $ep->posterFile . '/142', array('alt' => 'Episode poster for ' . $seriesName . ' ' . sprintf('S%02dE%02d', $ep->season, $ep->episode))); ?>
            </a>
        </li>
        <li class="title">
            <h2><?php echo HTML::anchor("download/episode/$ep->id", $ep->episode_name)?></h2>
            <ul>
                <li>
                    <?php
                    echo HTML::anchor("download/episode/$ep->id", sprintf('S%02dE%02d', $ep->season, $ep->episode));
                    echo $ep->isDownloaded;
                    ?>
                </li>
                <li>
                    <?php echo $ep->first_aired?>
                </li>
                
                <li>
                    <?php echo HTML::anchor("episodes/update/$ep->ep_id" . URL::query(array('series_id' => $id)), __('Update'))?>
                </li>
                <li>
                    <?php echo HTML::anchor("episodes/delete/$id/$ep->id", __('Delete'))?>
                </li>
            </ul>
        </li>
        <li class="text">
            <?php echo $ep->overview?>
        </li>
    </ul>

<?php
}

echo $pagination;
?>
