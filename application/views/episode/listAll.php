<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php echo $menu?>
<h1 class="page-title episodes-title"><?php echo HTML::anchor("", HTML::image('index.php/' . $banner, array('alt' => "Banner for $seriesName")))?></h1>
<p class="msg"><?php if (isset($_GET['msg'])) echo HTML::entities($_GET['msg'])?></p>
<div id="banner"><?php //echo HTML::image('index.php/' . $banner, array('alt' => "Banner for $seriesName"))?></div>
<?php
//echo $pagination;
foreach ($episodes as $ep) {

    if ($ep->posterMsg != "") {
        echo "<li>$ep->posterMsg</li>";
    }
    ?>

    <ul class="list episodes">
        <li class="img">
            <a href="<?php echo URL::site($ep->posterFile)?>">
                <?php echo HTML::image('index.php/' . $ep->posterFile . '/142', array('alt' => 'Episode poster for ' . $seriesName . ' ' . sprintf('S%02dE%02d', $ep->season, $ep->episode))); ?>
            </a>
        </li>
        <li class="title">
            <h2><?php echo HTML::anchor("download/episode/$ep->id", $ep->episode_name)?></h2>
            <ul>
                <li>
                    <?php
                    echo HTML::anchor("download/episode/$ep->id", sprintf('S%02dE%02d', $ep->season, $ep->episode));
                    echo $ep->isDownloaded;
                    ?>
                </li>
                <li>
                    <?php echo $ep->first_aired?>
                </li>
                <li class="matrix-cat" id="<?php echo $ep->id;?>">
                    <?php echo $matrix_cat?>
                </li>

                <li>
                    <?php echo HTML::anchor("episodes/update/$ep->ep_id" . URL::query(array('series_id' => $id)), __('Update'))?>
                </li>
                <li>
                    <?php echo HTML::anchor("episodes/delete/$id/$ep->id", __('Delete'))?>
                </li>
            </ul>
        </li>
        <li class="text">
            <?php echo $ep->overview?>
        </li>
    </ul>

<?php
}

echo $pagination;
?>

<script type="text/javascript">
$('<img src="' + baseUrl + '/images/move-spinner.gif" id="spinner" />').css('position','absolute').hide().appendTo('body');
$('.matrix-cat').click(function () {
    var element = $(this);
    if (element.hasClass('doNoEdit')) return this;
    var oldText = element.text();
    element.text('');
    element.addClass('doNoEdit');
    var select = $('<select name="edit" id="edit"></select>');
    select.append($('<option value="tv-all">TV: ALL</option>'));
    select.append($('<option value="5">TV: DVD</option>'));
    select.append($('<option value="6">TV: Divx/Xvid</option>'));
    select.append($('<option value="41">TV: HD</option>'));
    select.append($('<option value="7">TV: Sport/Event</option>'));
    select.append($('<option value="8">TV: Other</option>'));

    var form = $('<form action="#" method="get"></form>')
    form.append(select);

    var button = $('<input type="button" value="Ok" />').click(function () {
        var position = $(this).offset();
        $('#spinner').css({ top: position.top , left: position.left + $(this).width() + 30 }).fadeIn();
        var value = select.val();
        if (value == "select") return false;
        $.get(baseUrl + 'episodes/setMatrix/' + element.attr('id'), { cat: value }, function(data) {
            $('#spinner').fadeOut();
            form.remove();
            element.removeClass('doNoEdit');
            $('.matrix-cat').text(data);
        });
    });
    form.append(button);

    var cancel = $('<input type="button" value="Cancel" />').click(function () {
        form.remove();
        //element.removeClass('doNoEdit');
        element.text(oldText);
    });
    form.append(cancel);
    element.html(form);

    return this;
});
</script>
