<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="add-contents" class="search">
    <p class="msg"><?php if (isset($_GET['msg'])) echo HTML::entities($_GET['msg'])?></p>
    <form action="<?php echo URL::site('search/result')?>" method="get">
        <fieldset>
        <legend><?php echo $title?></legend>
        <ol>
            <li>
                <label for="q"><?php echo __('Search')?>:</label>
                <input type="text" name="q" id="q" size="30" />
            </li>     
            <li>
                <label for="where"><?php echo __('Where')?>:</label>
                <?php echo __('This site')?> <input type="radio" name="where" value="site" checked />
                <?php echo __('NZBMatrix')?> <input type="radio" name="where" id="matrix" value="matrix" />
            </li>
            <li class="matrix">
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
        </ol>
        </fieldset>
        <fieldset class="submit">
            <input type="submit" value="<?php echo __('Search')?>" />
        </fieldset>
    </form>
</div>
<?php if (isset($results)) { ?>
    <?php foreach($results as $series) { 
        $poster = $series->poster . '/147';
        if ($poster == "images/poster.png/147"){
            $poster = 'image/noPoster.png';
        }
        
        ?>
    <ul class="list">
        <li class="img">
            <?php echo HTML::anchor(
                    "http://www.thetvdb.com/?tab=series&id=$series->tvdb_id",
                    HTML::image('index.php/' . $poster, array('alt' => 'Poster for ' . $series->series_name)),
                    array('class' => 'ajaxTooltip', 'rel' => URL::site("series/getInfo/$series->id"))
                );?>
        </li>
        <li class="title">
            <h2><?php echo HTML::anchor("episodes/$series->id", $series->series_name)?></h2>
            <ul>
                <li>
                    <?php echo __('Airs') . ': ' . __($series->airs_day) . ' ' . __('at') . ' ' . date('H:i', strtotime($series->airs_time))?>
                </li>
                <li>
                    <?php echo __('Status') . ': ' . __($series->status)?>
                </li>
                <li>
                    <?php echo __('Network') . ': ' . $series->network?>
                </li>
                <li>
                    <?php echo __('Rating') . ': ' . $series->rating?>
                </li>
                <li>
                    <?php echo HTML::anchor("episodes/listSpecials/$series->id", __('List all specials'));?>
                </li>
            </ul>
        </li>
        <li class="text">
            <?php echo Text::limit_chars(HTML::entities($series->overview), 370)?>
        </li>
    </ul>
    <?php } ?>
<?php } ?>

<script type="text/javascript">
$('.matrix').hide();
$('#matrix').click(function () {
    var element = $('.matrix');
    element.show();
//    if (element.is(':visible')) {
//        element.hide();
//    } else {
//        element.show();
//    }
});

$('input[value="site"]').click(function () {
    $('.matrix').hide();
})
</script>
