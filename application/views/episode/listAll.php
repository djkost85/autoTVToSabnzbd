<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php echo $menu?>
<h1 class="page-title episodes-title"><?php echo HTML::anchor("", HTML::image('index.php/' . $banner, array('alt' => "Banner for $seriesName")))?></h1>
<p class="msg"><?php if (isset($_GET['msg'])) echo HTML::entities($_GET['msg'])?></p>
<div id="banner"><?php //echo HTML::image('index.php/' . $banner, array('alt' => "Banner for $seriesName"))?></div>
<?php
//echo $pagination;
foreach ($episodes as $ep) {
    $poster = new Posters();

    if (preg_match('#^http:\/\/#', $ep->filename)) {
        $path = "images/episode/";
        $image = $posterFile = $ep->filename;
        $newPosterName = $poster->ifFileExist(basename($image), $path);
        if ($newPosterName) {
            $posterFile = $path . $newPosterName;
            $poster->saveImage($image, $posterFile);

            $epORM = ORM::factory('episode', array('id' => $ep->id));
            $epORM->filename = $posterFile;
            if (!$epORM->save()) {
                echo '<p class="msg error">Ett fel med uppdaterningen av filnamnet har inträffat</p>';
            } else {
                echo '<p class="msg">Bilden är uppdaerad</p>';
            }
        } 
    } else if(is_readable($ep->filename)) {
        $posterFile = $ep->filename;
    } else {
        $posterFile = "images/poster.png";
    }
    //var_dump(URL::base() . "images/poster.png");
    //var_dump($ep->id);
    ?>

    <ul class="list episodes">
        <li class="img">
            <a href="<?php echo URL::site($posterFile)?>">
                <?php echo HTML::image('index.php/' . $posterFile . '/142', array('alt' => 'Episode poster for ' . $seriesName . ' ' . sprintf('S%02dE%02d', $ep->season, $ep->episode))); ?>
            </a>
        </li>
        <li class="title">
            <h2><?php echo HTML::anchor("download/episode/$ep->id", $ep->episode_name)?></h2>
            <ul>
                <li>
                    <?php
                    echo HTML::anchor("download/episode/$ep->id", sprintf('S%02dE%02d', $ep->season, $ep->episode));
                    if (ORM::factory('episode')->isDownloaded($ep->id)) {
                        echo ' <em>' . __('is downloaded') . '</em>';
                    }
                    ?>
                </li>
                <li>
                    <?php echo (is_null($ep->first_aired)) ? 'N/A' : $ep->first_aired?>
                </li>
                <li>
                    <?php echo $matrix_cat?>
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
            <?php echo Text::limit_chars(HTML::entities($ep->overview), 280)?>
        </li>
    </ul>

<?php
}

echo $pagination;
?>
