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
            <?php if (MsgFlash::has()) { ?><p class="success"><?php echo HTML::entities(MsgFlash::get())?></p> <?php } ?>

            <div class="episode-banner">
            <?php echo HTML::anchor('', HTML::image('index.php/' . $banner, array('alt' => 'Top Banner', 'class' => 'banner')), array('title' => 'Top Banner'));?>
            </div>
            
            <h1><?php echo $title?></h1>
<style type="text/css">
.thumbnail img {
    width: 190px;
    height: 136px;
}

dl.download-list {
    display: none;
}
dl.download-list ul li {
    /*float: left;*/
}

div.list-all-downloads {
    margin: 5px 0 10px 10px;
}
</style>
            <div class="list-all-downloads">
            <a href="#" id="toggle-list"><?php echo __('Download')?></a>
            <form action="<?php echo URL::site('download/multiEp'); ?>" method="get" id="download-form">
                <dl class="download-list">
                    <?php foreach ($downloads as $season => $value) { ?>
                    <dt><a href="#"><?php echo __('Season') . ': ' . $season?></a></dt>
                    <dd>
                        <ul>
                            <?php foreach ($value as $d) { ?>
                            <li><?php echo $d->episode?> <input type="checkbox" name="episodes[]" value="<?php echo $d->id?>" /></li>
                            <?php } ?>
                        </ul>
                    </dd>
                    <?php } ?>
                    <dd>
                        <input type="submit" name="download" value="<?php echo __('Download')?>" />
                    </dd>
                </dl>
            </form>
            </div>
<ul class="thumbnail">
<?php
foreach ($episodes as $ep) {
    ?>

        <li>
                <?php echo HTML::anchor("download/episode/$ep->id", $ep->episode_name)?> <br />
                <?php if (is_file($ep->posterFile)) echo HTML::anchor(
                    $ep->posterFile,
                    HTML::image('index.php/' . $ep->posterFile . '/142', array('alt' => 'Episode poster for ' . $seriesName . ' ' . sprintf('S%02dE%02d', $ep->season, $ep->episode)))
                );?>
                <span class="icon series-date"><?php echo __('Airs') . ' ' . $ep->first_aired?></span>
                <span class="icon update" title="<?php echo __('Update')?>"><?php echo HTML::anchor("episodes/update/$ep->ep_id" . URL::query(array('series_id' => $id)), __('Update'))?></span>
                <span class="icon del" title="<?php echo __('Delete') ?>"><?php echo HTML::anchor("episodes/delete/$id/$ep->id", __('Delete'))?></span>
                <span class="icon special"><?php echo HTML::anchor("download/episode/$ep->id", sprintf('S%02dE%02d', $ep->season, $ep->episode)); echo '<br />' . $ep->isDownloaded;?></span>
                <?php
                if ($ep->posterMsg != "") {
                    echo $ep->posterMsg;
                }
                ?>
        </li>

<?php } ?>
</ul>
            <?php echo $pagination;?>

        <div class="clearer"></div>
                    </div>
                    <!-- main ends -->
                </div>
<script type="text/javascript">
$('<div id="slow-page-sign" />').css('position', 'absolute').hide().appendTo('body');
$('.pagination').click(function () {
    var position = $(this).offset();
    $('#slow-page-sign').
        css({ top: position.top - $(this).height() - $('#slow-page-sign').height() , left: position.left, background: '#fff', color: '#000' }).
        fadeIn(3000).html('<?php echo __('slow-page')?>');
});


$('input[type="submit"]').click(function () {
    $(this).attr("disabled", true);
    $(this).val('<?php echo __('Wait')?>...');
});


$('.download-list dt').click(function () {
    $(this).next().find('input[type="checkbox"]').each(function() {
        $(this).attr('checked', !$(this).attr('checked'));
    });
    return false;
});

$('#toggle-list').click(function () {
    $('dl.download-list').toggle();
//    $('#download-form').submit(function() {
//        var url = ajaxUrl + 'download/doMultiEp/?' + $(this).serialize();
//        $('h1').before($('<p class="success"/>').text('Trying to download'));
//        $('dl.download-list').toggle();
//        $.get(url, function (data) {
//        });
//        return false;
//    });
    return false;
});
</script>

