<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="add-contents">
    <form action="<?php echo $url?>" method="post">
        <fieldset>
        <legend><?php echo $title; ?></legend>
        <ol>
            <li>
                <label for="series_name"><?php echo __('serie name')?>:</label>
                <input type="text" name="series_name" id="series_name" value="<?php echo $series->series_name?>" readonly />
            </li>
            <li id="search-result" style="display: none">
                <?php foreach($banners as $type => $banner) {
                    echo '<h3>'.$type.'</h3>';
                    foreach ($banner as $img) {
                        echo $img;
                    }
                } ?>
            </li>
            <li>
                <label for="matrix_cat"><?php echo __('download catagory')?>:</label>
                <select id="matrix_cat" name="matrix_cat">
                <option value="tv-all" <?php if ($series->matrix_cat == 'tv-all') echo 'selected'?> >TV: ALL</option>
                <option value="5" <?php if ($series->matrix_cat == '5') echo 'selected'?> >TV: DVD</option>
                <option value="6" <?php if ($series->matrix_cat == '6') echo 'selected'?> >TV: Divx/Xvid</option>
                <option value="41" <?php if ($series->matrix_cat == '41') echo 'selected'?> >TV: HD</option>
                <option value="7" <?php if ($series->matrix_cat == '7') echo 'selected'?> >TV: Sport/Event</option>
                <option value="8" <?php if ($series->matrix_cat == '8') echo 'selected'?> >TV: Other</option>
                </select>

            </li>
        </ol>
        <input type="hidden" name="poster" id="poster" />
        <input type="hidden" name="fanart" id="fanart" />
        <input type="hidden" name="banner" id="banner" />
        </fieldset>
        <fieldset class="submit">
            <input type="submit" value="<?php echo __('update')?>" />
        </fieldset>
    </form>
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
