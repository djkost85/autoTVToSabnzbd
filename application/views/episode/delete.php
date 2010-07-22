<?php defined('SYSPATH') or die('No direct script access.'); ?>
<h1 class="page-title episodes-title"><?php echo HTML::anchor("", HTML::image('index.php/' . $banner, array('alt' => "Banner for $seriesName")))?></h1>
<p class="msg"><?php if (isset($_GET['msg'])) echo HTML::entities($_GET['msg'])?></p>

<ul class="list episodes">
    <li class="img">
        <a href="<?php echo URL::site($ep->filename)?>">
            <?php echo HTML::image('index.php/' . $ep->filename . '/124', array('alt' => 'Episode poster for ' . $seriesName . ' S' . sprintf('%02d', $ep->season) . 'E' . sprintf('%02d', $ep->episode))); ?>
        </a>
    </li>
    <li class="title">
        <h2><?php echo HTML::anchor("download/$seriesName/$ep->season/$ep->episode/$id", $ep->episode_name)?></h2>
        <?php echo HTML::anchor("download/$seriesName/$ep->season/$ep->episode/$id", 'S' . sprintf('%02d', $ep->season) . 'E' . sprintf('%02d', $ep->episode));?>
        <br />
        <?php echo (is_null($ep->first_aired)) ? 'N/A' : $ep->first_aired?>
        <br />
        <?php echo $matrix_cat?>
        <br />
        <?php echo HTML::anchor("episodes/update/$ep->ep_id" . URL::query(array('series_id' => $id)), __('update'))?>
    </li>
    <li class="text">
        <?php echo Text::limit_chars(HTML::entities($ep->overview), 280)?>...
    </li>
    <li class="img">
<h3>Är du säker på att du vill radera?</h3>
<?php
echo Form::open("episodes/delete/$id/$epId", array('method' => 'get', 'id'=>'myform', 'class'=>'myclass'));
echo Form::submit('delete', __('yes'));
echo Form::close();
?>
    </li>
</ul>
