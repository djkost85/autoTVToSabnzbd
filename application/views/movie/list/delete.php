<?php
defined('SYSPATH') or die('No direct script access.');

foreach (unserialize($movie->posters) as $poster) {
    //original, mid, cover, thumb
    if ($poster->image->size == 'thumb') {
        $file = $poster->image->url;
    }
}
?>

<div class="deleteBox">
    <?php echo HTML::anchor('movie/list/info/' . $movie->id, $movie->name)?><br />
    <?php echo HTML::image($file);?>

    <p><?php echo __('Delete')?> "<?php echo $movie->name ?>"?<br />
    <?php echo HTML::anchor('movie/list/doDelete/' . $movie->id, __('Yes'))?> |
    <?php echo HTML::anchor("movie/info/" . $movie->id, __('No'))?></p>
</div>
