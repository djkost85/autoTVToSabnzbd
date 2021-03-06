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
    <h1><?php echo $title?></h1>
    <?php if (MsgFlash::has()) { ?><p class="success"><?php echo HTML::entities(MsgFlash::get())?></p> <?php } ?>
    <?php if (MsgFlash::hasError()) { ?><p class="error"><?php echo HTML::entities(MsgFlash::get(true))?></p> <?php } ?>
    <form id="submitform" action="<?php echo URL::site('series/doAdd')?>" method="get">
        <p>
            <label for="name"><?php echo __('Serie name')?>:</label>
            <input type="text" name="name" id="name" size="30" />
        </p>
        <p>
            <label for="is_tvdb_id"><?php echo __('TheTVDB.com ID')?>:</label>
            <input type="checkbox" name="is_tvdb_id" id="is_tvdb_id" value="true" class="radio-button" />
        </p>
        <p id="search-result" style="display: none"></p>
        <p>
            <label for="cat"><?php echo __('Download catagory')?>:</label>
            <select id="cat" name="cat">
                <option value="tv-all" style="font-weight: bold;">TV: ALL</option>
                <option value="5" <?php if ($matrixCat == '5') echo 'selected'?> >TV: DVD</option>
                <option value="6" <?php if ($matrixCat == '6') echo 'selected'?> >TV: Divx/Xvid</option>
                <option value="41" <?php if ($matrixCat == '41') echo 'selected'?> >TV: HD</option>
                <option value="7" <?php if ($matrixCat == '7') echo 'selected'?> >TV: Sport/Event</option>
                <option value="8" <?php if ($matrixCat == '8') echo 'selected'?> >TV: Other</option>
            </select>
        </p>
        <p>
            <label for="language"><?php echo __('Language')?>:</label>
            <select id="language" name="language">
                <?php foreach ($languages as $lang) { ?>
                <option value="<?php echo $lang->id?>"><?php echo $lang->name?></option>
                <?php } ?>
            </select>
        </p>
        
        <input type="hidden" name="poster" id="poster" />
        <p class="submit">
            <input class="button" type="submit" value="<?php echo __('Save')?>" />
        </p>
    </form>
        </div>
        <!-- main ends -->
    </div>
<script type="text/javascript">
$('<img src="' + baseUrl + 'images/move-spinner.gif" id="spinner" />').css('position','absolute').hide().appendTo('body');

var searchData = "";

$('#name').autocomplete(data, {
    matchContains: false,
    minChars: 1
}).result(function (e, result) {
    getImages(result);
});

function getImages(search) {
    var position = $('#name').offset();
    $('#spinner').css({ top: position.top , left: position.left + $('#name').width() + 30 }).fadeIn();
    
    var url = ajaxUrl + 'series/getBanners/' + search;
    $.get(url, function (data) {
        $('#spinner').fadeOut();
        $('#search-result').html(data).fadeIn();
        $("img.select-img").click(function () {
            $("img.select-img").removeClass('selected');
            $(this).addClass('selected');
            $('#poster').val($(this).attr("title"));
            return false;
        });
    });
}


$('<div id="slow-page-sign" />').css('position', 'absolute').hide().appendTo('body');
$('input[type="submit"]').click(function () {
    $(this).attr("disabled", true);
    $(this).val('<?php echo __('Wait')?>...');
    var position = $(this).offset();
    $('#slow-page-sign').css({ top: position.top - $(this).height() - $('#slow-page-sign').height() , left: position.left, background: '#fff', color: '#000' }).
        fadeIn().html('<?php echo __('add-slow-page')?>');
});
</script>

