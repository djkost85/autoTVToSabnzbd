<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php echo $menu?>
<!--<h1 class="page-title"><?php echo HTML::anchor("", $title); ?></h1>-->
<?php if (empty($series)) { ?>
    <h1 class="page-title"><?php echo $noSeries?></h1>
<?php } else { ?>
    <h1 class="page-title"><?php echo HTML::anchor("", HTML::image('index.php/' . $banner, array('alt' => $title)))?></h1>
<?php } ?>
<p class="msg"><?php if (isset($_GET['msg'])) echo HTML::entities($_GET['msg'])?></p>

<div id="middle-contents">
<?php
//$modelEp = ORM::factory('episode');

//echo $pagination;
$i = (isset($_GET['page']) && $_GET['page'] > 1) ? 100: 1;
foreach ($series as $ser) {
    $poster = $ser->poster . '/147';
    if ($poster == "images/poster.png/147"){
        $poster = 'image/noPoster.png';
    }

    $paperClip = "";
    if ($i <= 10 && $rss->inFeed(sprintf("%s S%02dE%02d", $ser->series_name, $ser->season, $ser->episode))) {
        $i++;
        $paperClip = "<span></span><em>In RSS</em>";
    }
    ?>
    <ul class="list">
        <li class="img">
            <?php echo HTML::anchor(
                    "http://www.thetvdb.com/?tab=series&id=$ser->tvdb_id",
                    $paperClip . HTML::image('index.php/' . $poster, array('alt' => 'Poster for ' . $ser->series_name)),
                    array('class' => 'ajaxTooltip', 'rel' => URL::site("series/getInfo/$ser->id"))
                );?>
        </li>
        <li class="title">
            <h2><?php echo HTML::anchor("episodes/$ser->series_id", $ser->series_name)?></h2>
            <ul>
                <li><?php
                    echo __('Last episode') . ': ';

                    echo HTML::anchor($ser->download_link, sprintf("S%02dE%02d",$ser->season, $ser->episode), array(
                            'id' => $ser->episode_id,
                            'class' => 'downloadable'
                            ));
                        ?>
                    <?php if (strtotime(date('Y-m-d')) == strtotime($ser->first_aired)) { ?>
                        <em><?php echo __('today') ?></em>
                    <?php } ?>
                </li>
                <li>
                    <?php echo __('Next') . ': ' . $ser->next_episode?>
                </li>
                <li class="matrix-cat" id="<?php echo $ser->id;?>">
                    <?php echo NzbMatrix::cat2string($ser->matrix_cat)?>
                </li>
                <li>
                    <?php echo HTML::anchor("series/update/$ser->id", $update)?>
                </li>
                <li>
                    <?php echo HTML::anchor("series/edit/$ser->id", $edit)?>
                </li>
                <li>
                    <?php echo HTML::anchor("series/delete/$ser->id", $delete)?>
                </li>
                <li>
                    <?php echo HTML::anchor("episodes/listSpecials/$ser->id", $listAllSpecials);?>
                </li>
            </ul>
        </li>
        <li class="text">
            <?php echo Text::limit_chars(HTML::entities($ser->overview), 370)?>
        </li>
    </ul>
    <?php } ?>
</div>


<script type="text/javascript">
$('.ajaxTooltip').tooltip({rounded: true});


$('<img src="' + baseUrl + '/images/move-spinner.gif" id="spinner" />').css('position','absolute').hide().appendTo('body');
$('.matrix-cat').click(function () {
    var element = $(this);
    if (element.hasClass('doNoEdit')) return this;
    var oldText = jQuery.trim(element.text());
    element.text('');
    element.addClass('doNoEdit');
    
    var select = $('<select name="edit" id="edit"></select>');
    select.append((oldText != 'TV > All') ? $('<option value="tv-all">TV: ALL</option>') : $('<option value="tv-all" selected>TV: ALL</option>'));
    select.append((oldText != 'TV > DVD') ? $('<option value="5">TV: DVD</option>') : $('<option value="5" selected>TV: DVD</option>'));
    select.append((oldText != 'TV > Divx/Xvid') ? $('<option value="6">TV: Divx/Xvid</option>') : $('<option value="6" selected>TV: Divx/Xvid</option>'));
    select.append((oldText != 'TV > HD') ? $('<option value="41">TV: HD</option>') : $('<option value="41" selected>TV: HD</option>'));
    select.append((oldText != 'TV > Sport/Event') ? $('<option value="7">TV: Sport/Event</option>') : $('<option value="7" selected>TV: Sport/Event</option>'));
    select.append((oldText != 'TV > Other') ? $('<option value="8">TV: Other</option>') : $('<option value="8" selected>TV: Other</option>'));

    var form = $('<form action="#" method="get"></form>')
    form.append(select);

    var button = $('<input type="button" value="Ok" />').click(function () {
        var position = $(this).offset();
        $('#spinner').css({ top: position.top , left: position.left + $(this).width() + 30 }).fadeIn();
        var value = select.val();
        if (value == "select") return false;
        $.get(baseUrl + 'series/setMatrix/' + element.attr('id'), { cat: value }, function(data) {
            $('#spinner').fadeOut();
            form.remove();
            element.removeClass('doNoEdit');
            element.text(data);
        });
    });
    form.append(button);

    var cancel = $('<input type="button" value="Cancel" />').click(function () {
        form.remove();
//        element.removeClass('doNoEdit');
        element.text(oldText);
    });
    form.append(cancel);
    element.html(form);

    return this;
});
</script>

<?php echo $pagination; ?>
    
