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
$ids = array();
foreach ($series as $ser) {
    $poster = $ser->poster . '/147';
    if ($poster == "images/poster.png/147"){
        $poster = 'image/noPoster.png';
    }

//    $ep = ORM::factory('episode');
//    var_dump($ep->getPreviousAired($ser->series_id));
//    var_dump($ser->ep_id);
//    var_dump($ser->ep_num);
//    var_dump($ser->ep_sea);
//    var_dump($ser->ep_aired);
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
            <h2><?php echo HTML::anchor("episodes/$ser->series_id", $ser->series_name)?></h2>
            <ul>
                <li><?php
                    echo __('Last episode') . ': ';
//                    echo ($modelEp->isDownloaded($ser->episode_id)) ?
//                        __('is downloaded') :
//                        HTML::anchor($ser->download_link, sprintf("S%02dE%02d",$ser->season, $ser->episode), array(
//                            'id' => $ser->episode_id,
//                            'class' => 'downloadable'
//                            ));


                    echo HTML::anchor($ser->download_link, sprintf("S%02dE%02d",$ser->season, $ser->episode), array(
                            'id' => $ser->episode_id,
                            'class' => 'downloadable'
                            ));
                        ?>
                </li>
                <li>
                    <?php echo __('Next') . ': ' . $ser->next_episode?>
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
    <?php } ?>
</div>


<script type="text/javascript">
$('.ajaxTooltip').tooltip({rounded: true});

</script>

<?php echo $pagination; ?>
    
