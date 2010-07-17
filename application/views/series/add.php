<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php echo $menu?>
<div id="add-contents">
    <p class="msg"><?php if (isset($_GET['msg'])) echo HTML::entities($_GET['msg'])?></p>
    <form action="<?php echo URL::site('series/doAdd')?>" method="post">
        <fieldset>
        <legend><?php echo $title?></legend>
        <ol>
            <li>
                <label for="name"><?php echo __('Serie name')?>:</label>
                <input type="text" name="name" id="name" size="30" />
            </li>
            <li id="search-result" style="display: none"></li>
            <li>
                <label for="cat"><?php echo __('Download catagory')?>:</label>
                <select id="cat" name="cat">
                    <option value="tv-all" style="font-weight: bold;">TV: ALL</option>
                    <option value="5">TV: DVD</option>
                    <option value="6" selected>TV: Divx/Xvid</option>
                    <option value="41">TV: HD</option>
                    <option value="7">TV: Sport/Event</option>
                    <option value="8">TV: Other</option>
                    <option value="movies-all" style="font-weight: bold;">Movies: ALL</option>
                    <option value="1">Movies: DVD</option>
                    <option value="2">Movies: Divx/Xvid</option>
                    <option value="54">Movies: BRRip</option>
                    <option value="42">Movies: HD (x264)</option>
                    <option value="50">Movies: HD (Image)</option>
                    <option value="48">Movies: WMV-HD</option>
                    <option value="3">Movies: SVCD/VCD</option>
                    <option value="4">Movies: Other</option>
                </select>
            </li>
            <li>
                <label for="language"><?php echo __('Language')?>:</label>
                <select id="language" name="language">
                    <?php foreach ($languages as $lang) { ?>
                    <option value="<?php echo $lang->id?>"><?php echo $lang->name?></option>
                    <?php } ?>
                </select>
            </li>
        </ol>
        <input type="hidden" name="poster" id="poster" />
        </fieldset>
        <fieldset class="submit">
            <input type="submit" value="<?php echo __('Save')?>" />
        </fieldset>
    </form>
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
    
    var url = baseUrl + 'series/getBanners/' + search;
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


$('input[type="submit"]').click(function () {
    $(this).attr("disabled", true);
    $(this).val('<?php echo __('Wait')?>...');
});
</script>

