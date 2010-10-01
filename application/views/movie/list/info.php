<?php
defined('SYSPATH') or die('No direct script access.');
$file = "images/black/noPoster.gif";
foreach (unserialize($movie->posters) as $image) {
    if ($image->image->size == 'mid') {
        $file = $image->image->url;
    }
//    var_dump($image);
}
//var_dump($movie);
?>
<div class="info-box">
    <h2><?php echo $title; ?></h2>
    <span class="released"><?php echo $movie->released?></span>
    <br />
    <?php echo HTML::image($file, array('alt' => $movie->name, 'class' => 'floatright')) ?>
        <?php echo HTML::entities($movie->overview)?>
        <br />
        <?php echo HTML::anchor('movie/list/delete/' . $movie->id, __('Delete')); ?> |
        <?php echo HTML::anchor('http://www.imdb.com/title/' . $movie->imdb_id, 'IMDb'); ?> |
        <?php echo HTML::anchor($movie->url, 'themoviedb.org'); ?> |
        <?php echo ($inDlList) ? HTML::anchor('movie/list/rmDlList/' . $movie->id, __('Remove from List')) :
                HTML::anchor('movie/list/addDlList/' . $movie->id, __('Add to list'));?>
        <br />
        <?php echo HTML::anchor('movie/add/update/' . $movie->id, __('Update'))?>
        <br />
        <?php echo __('Budget') . ': $' . number_format($movie->budget, 2, ',', ' '); ?>
        <br />
        <?php echo __('Runtime')  . ': ' . Helper::min2h($movie->runtime) . 'h'?>
        <br />
        (<?php echo $movie->rating . '/' . $movie->votes?>)
</div>

<?php if (is_null($movie->trailer)) { ?>
<form action="<?php echo URL::site('movie/add/trailer/' . $movie->id)?>" method="get">
    <p>
        <label for="trailer">Add a youtube trailer</label>
        <input type="text" id="trailer" name="trailer" />
    </p>
    <p>
        <input type="submit" value="<?php echo __('Save')?>" />
    </p>
</form>
<?php } else { ?>
<div id="player" class="info-box"></div>

<script type="text/javascript">

$('#player').youTubeEmbed({
    video	: '<?php echo $movie->trailer?>',
    width	: 660, 		// Height is calculated automatically
    progressBar : false		// Hide the progress bar
});

</script>
<?php } ?>
