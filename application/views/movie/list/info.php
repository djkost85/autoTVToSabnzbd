<?php
defined('SYSPATH') or die('No direct script access.');
$file = "";
foreach (unserialize($movie->posters) as $image) {
    if ($image->image->size == 'mid') {
        $file = $image->image->url;
    }
//    var_dump($image);
}
//var_dump($movie);
?>
<h1><?php echo $title; ?></h1>
<div>
    <p>
        <?php echo HTML::image($file) ?>
    </p>
    <p>
        <?php echo HTML::entities($movie->overview)?>
    </p>
    <p>
        <?php echo HTML::anchor('movie/list/delete/' . $movie->id, __('Delete')); ?>
    </p>
</div>
