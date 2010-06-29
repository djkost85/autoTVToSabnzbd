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
$ids = array();
foreach ($series->limit($items_per_page)->offset($offset)->order_by('first_aired', 'desc')->find_all() as $ser) {
    $poster = $ser->poster . '/147';
    if ($poster == "images/poster.png/147"){
        $poster = 'image/noPoster.png';
    }

    foreach ($ser->episodes->where('first_aired', '<=', DB::expr('CURDATE()'))->and_where('season', '>', '0')->order_by('first_aired', 'desc')->limit(1)->find_all() as $ep) {
        $download_link = "download/episode/$ep->id";
    ?>
    <ul class="list">
        <li class="img">
            <?php echo HTML::anchor(
                    "http://www.thetvdb.com/?tab=series&id=$ser->tvdb_id",
                    HTML::image('index.php/' . $poster, array('alt' => 'Poster for ' . $ser->series_name)),
                    array('class' => 'ajaxTooltip', 'rel' => URL::site("series/getInfo/$ser->id"))
                );?>
        </li>
        <li class="title">
            <h2><?php echo HTML::anchor("episodes/$ser->id", $ser->series_name)?></h2>
            <ul>
                <li><?php
                    echo __('Last episode') . ': ';

                    echo HTML::anchor($download_link, sprintf("S%02dE%02d",$ep->season, $ep->episode), array(
                            'id' => $ep->id,
                            'class' => 'downloadable'
                            ));
                        ?>
                </li>
                <li>
                    <?php echo __('Next') . ': ' . $ep->getNext($ep->id);?>
                </li>
                <!--<li>
                    <?php /*echo __('Airs') . ': ' . $ser->airs_at;*//*__('Previous') . ': ' . $ser->first_aired;*/ ?>
                </li>-->
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
    <?php } } ?>
</div>


<script type="text/javascript">
$('.ajaxTooltip').tooltip({rounded: true});

</script>

<?php echo $pagination; ?>

