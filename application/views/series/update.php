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
            <h1><?php echo $title; ?></h1>
            <?php if (MsgFlash::has()) { ?><p class="success"><?php echo HTML::entities(MsgFlash::get())?></p> <?php } ?>
            <?php if (MsgFlash::hasError()) { ?><p class="error"><?php echo HTML::entities(MsgFlash::get(true))?></p> <?php } ?>
            
    <form id="submitform" action="<?php echo $url?>" method="get">
            <p>
                <label for="series_name"><?php echo __('serie name')?>:</label>
                <input type="text" name="series_name" id="series_name" value="<?php echo $series->series_name?>" readonly />
            </p>
            <p id="search-result" style="display: none">
                <?php foreach($banners as $type => $banner) {
                    echo '<h3>'.$type.'</h3>';
                    foreach ($banner as $img) {
                        echo $img;
                    }
                } ?>
            </p>
            <p>
                <label for="matrix_cat"><?php echo __('download catagory')?>:</label>
                <select id="matrix_cat" name="matrix_cat">
                <option value="tv-all" <?php if ($series->matrix_cat == 'tv-all') echo 'selected'?> >TV: ALL</option>
                <option value="5" <?php if ($series->matrix_cat == '5') echo 'selected'?> >TV: DVD</option>
                <option value="6" <?php if ($series->matrix_cat == '6') echo 'selected'?> >TV: Divx/Xvid</option>
                <option value="41" <?php if ($series->matrix_cat == '41') echo 'selected'?> >TV: HD</option>
                <option value="7" <?php if ($series->matrix_cat == '7') echo 'selected'?> >TV: Sport/Event</option>
                <option value="8" <?php if ($series->matrix_cat == '8') echo 'selected'?> >TV: Other</option>
                </select>

            </p>
        <input type="hidden" name="poster" id="poster" />
        <input type="hidden" name="fanart" id="fanart" />
        <input type="hidden" name="banner" id="banner" />
        <p>
            <input class="button" type="submit" value="<?php echo __('update')?>" />
        </p>
    </form>
                </div>
                    </div>
                    <!-- main ends -->
                </div>

<script type="text/javascript">
$('input[type="submit"]').click(function () {
    $(this).attr("disabled", true);
    $(this).val('Vänta...');
});

$('#search-result').fadeIn();

$("img.select-poster").click(function () {
    //alert($(this).attr("title"))
    $("img.select-poster").removeClass('selected');
    $(this).addClass('selected');
    $('#poster').val($(this).attr("title"));
    return false;
});
$("img.select-fanart").click(function () {
    //alert($(this).attr("title"))
    $("img.select-fanart").removeClass('selected');
    $(this).addClass('selected');
    $('#fanart').val($(this).attr("title"));
    return false;
});
$("img.select-banner").click(function () {
    //alert($(this).attr("title"))
    $("img.select-banner").removeClass('selected');
    $(this).addClass('selected');
    $('#banner').val($(this).attr("title"));
    return false;
});
</script>
