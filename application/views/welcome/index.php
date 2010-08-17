<?php defined('SYSPATH') or die('No direct script access.'); ?>

<!-- wrap starts here -->
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
                <?php echo HTML::anchor('', HTML::image("images/black/banner/fringe.jpg", array('alt' => 'Top Banner')), array('title' => 'Top Banner', 'class' => 'adhere'));?>
            </div>

            <h1><?php echo $title; ?></h1>
            <?php if (empty($series)) { ?>
                <h1 class="page-title"><?php echo $noSeries?></h1>
            <?php } ?>
                
            <?php if (MsgFlash::has()) { ?><p class="success"><?php echo HTML::entities(MsgFlash::get())?></p> <?php } ?>
<ul class="thumbnail">
<?php

$i = (isset($_GET['page']) && $_GET['page'] > 2) ? 100: 1;
$useNzbSite = Kohana::config('default.default.useNzbSite');
foreach ($series as $ser) {
    if ($ser->poster == "") {
        $poster = "images/black/noPoster.gif";
    } else {
        $poster = 'index.php/' . $ser->poster . '/281';
    }

    $paperClip = "";
    $searchName = sprintf("%s S%02dE%02d", $ser->series_name, $ser->season, $ser->episode);
//    if ($useNzbSite == 'nzbs') $searchName = str_replace (' ', '.', $searchName);
    if ($i <= 10 && $rss->inFeed($searchName)) {
        $i++;
        $paperClip = "<p></p><em>".__('In RSS')."</em>";
    }
    ?>
            <li>
                <?php echo HTML::anchor("episodes/$ser->series_id", $ser->series_name)?><br />
                <?php echo HTML::anchor(
                    "http://www.thetvdb.com/?tab=series&id=$ser->tvdb_id",
                    $paperClip . HTML::image($poster, array('alt' => 'Poster for ' . $ser->series_name)),
                    array('class' => 'ajaxTooltip', 'rel' => URL::site("series/getInfo/$ser->id"))
                );?>
                <!--<span class="dateThumb">S23E88</span>-->
                <span class="icon update" title="<?php echo $update?>"><?php echo HTML::anchor("series/update/$ser->id", $update)?></span>
                <span class="icon edit" title="<?php echo $edit?>"><?php echo HTML::anchor("series/edit/$ser->id", $edit)?></span>
                <span class="icon type matrix-cat" id="<?php echo $ser->id;?>" title="<?php echo NzbMatrix::cat2string($ser->matrix_cat)?>"></span>
                <span class="icon del" title="<?php echo $delete?>"><?php echo HTML::anchor("series/delete/$ser->id", $delete)?></span>
                <span class="icon special" title="<?php echo $listAllSpecials?>"><?php echo HTML::anchor("episodes/listSpecials/$ser->id", $listAllSpecials);?></span>
                <div><?php echo __('Last episode') . ': '.
                HTML::anchor($ser->download_link, sprintf("S%02dE%02d",$ser->season, $ser->episode), array(
                    'id' => $ser->episode_id,
                    'class' => 'downloadable'
                ));?></div>
                <div><?php echo __('Next') . ': ' . $ser->next_episode?></div>
            </li>
    
    <?php }    ?>
</ul>
<?php echo $pagination; ?>
<?php echo HTML::anchor('', HTML::image((isset($banner)) ? $banner : "images/black/banner/star-wars.jpg", array('alt' => 'Bottom Banner', 'class' => 'banner')));?>


                    <div class="clearer"></div>
                </div>
                <!-- wrap ends -->
            </div>


<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.ajaxTooltip').tooltip({rounded: true});


    $('<img src="' + baseUrl + '/images/move-spinner.gif" id="spinner" />').css('position','absolute').hide().appendTo('body');
    $('.matrix-cat').click(function (event) {
        var element = $(this);
        if (element.hasClass('doNoEdit')) {
            return this;
        }
    //    var oldText = jQuery.trim(element.text());
        var oldText = jQuery.trim(element.attr('title'));
        element.text('');
        element.addClass('doNoEdit');

        var select = $('<select name="edit" id="edit"></select>');
        select.append((oldText != 'TV > All') ? $('<option value="tv-all">TV: ALL</option>') : $('<option value="tv-all" selected>TV: ALL</option>'));
        select.append((oldText != 'TV > DVD') ? $('<option value="5">TV: DVD</option>') : $('<option value="5" selected>TV: DVD</option>'));
        select.append((oldText != 'TV > Divx/Xvid') ? $('<option value="6">TV: Divx/Xvid</option>') : $('<option value="6" selected>TV: Divx/Xvid</option>'));
        select.append((oldText != 'TV > HD') ? $('<option value="41">TV: HD</option>') : $('<option value="41" selected>TV: HD</option>'));
        select.append((oldText != 'TV > Sport/Event') ? $('<option value="7">TV: Sport/Event</option>') : $('<option value="7" selected>TV: Sport/Event</option>'));
        select.append((oldText != 'TV > Other') ? $('<option value="8">TV: Other</option>') : $('<option value="8" selected>TV: Other</option>'));

        var form = $('<form id="form_'+event.target.tagName+'" action="#" method="get"></form>')
        form.append(select);

        var button = $('<input type="button" value="Ok" />').click(function () {
            var position = $(this).offset();
            $('#spinner').css({ top: position.top , left: position.left + $(this).width() + 30 }).fadeIn();
            var value = select.val();
            if (value == "select") return false;
            $.get(ajaxUrl + 'series/setMatrix/' + element.attr('id'), { cat: value }, function(data) {
                $('#spinner').fadeOut();
                form.remove();
                element.removeClass('doNoEdit');
                element.attr('title', data);
            });
        });
        form.append(button);

        var cancel = $('<input type="button" value="Cancel" />').click(function () {
            form.remove();
//            element.removeClass('doNoEdit');
    //        element.text(oldText);
        });
        form.append(cancel);
        element.html(form);
        return this;
    });

});
</script>

    
