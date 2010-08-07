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
    <?php if (MsgFlash::has()) { ?><p class="msg"><?php echo HTML::entities(MsgFlash::get())?></p> <?php } ?>
    <form id="submitform" action="<?php echo URL::site('search/result')?>" method="get">
        <p>
            <label for="q"><?php echo __('Search')?>:</label>
            <input type="text" name="q" id="q" size="30" />
        </p>
        <p>
            <label for="where"><?php echo __('Where')?>:</label>
            <?php echo __('This site')?> <input type="radio" name="where" value="site" checked />
            <?php echo __('NZBMatrix')?> <input type="radio" name="where" id="matrix" value="matrix" />
        </p>
        <p class="matrix">
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
        </p>
        <p>
            <input class="button"  type="submit" value="<?php echo __('Search')?>" />
        </p>
    </form>
<?php if (isset($results)) { ?>
        </div>
    </div>

     <div id="main">
        <div class="inner">
            <ul class="thumbnail">
    <?php foreach($results as $series) {
        if ($series->poster == "") {
            $poster = "images/noPoster.gif/147";
        } else {
            $poster = $series->poster . '/147';
        }

        
        ?>
                <li>
                    <?php echo HTML::anchor("episodes/$series->id", $series->series_name)?><br />
                    <?php echo HTML::anchor(
                        "http://www.thetvdb.com/?tab=series&id=$series->tvdb_id",
                        HTML::image('index.php/' . $poster, array('alt' => 'Poster for ' . $series->series_name)),
                        array('class' => 'ajaxTooltip', 'rel' => URL::site("series/getInfo/$series->id"))
                    );?>
                    <div><?php echo __('Airs') . ': ' . __($series->airs_day) . ' ' . __('at') . ' ' . date('H:i', strtotime($series->airs_time))?></div>
                    <div><?php echo __('Status') . ': ' . __($series->status)?></div>
                    <div><?php echo __('Network') . ': ' . $series->network?></div>
                    <div><?php echo __('Rating') . ': ' . $series->rating?></div>
                    <div><?php echo HTML::anchor("episodes/listSpecials/$series->id", __('List all specials'));?></div>
                    <div><?php echo Text::limit_chars(HTML::entities($series->overview), 370)?></div>
                </li>
    
    <?php } ?>
            </ul>
<?php } ?>

        <?php echo HTML::anchor('#', HTML::image("images/black/banner/star-wars.jpg", array('alt' => 'Bottom Banner', 'class' => 'banner')));?>


                        <div class="clearer"></div>
                    </div>
                    <!-- main ends -->
                </div>

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
