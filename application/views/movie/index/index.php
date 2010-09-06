<?php
defined('SYSPATH') or die('No direct script access.');
?>

<div class="top-banner">
    <?php echo HTML::anchor('', HTML::image("images/black/banner/fringe.jpg", array('alt' => 'Top Banner')), array('title' => 'Top Banner', 'class' => 'adhere'));?>
</div>

<h1><?php echo $title; ?></h1>
<?php if (empty($series)) { ?>
    <h1 class="page-title"><?php echo __('No movies saved')?></h1>
<?php } ?>

            