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

            <?php if (!empty($install_error)) { echo '<h2 class="error">You have errors you must tend to</h2><ul class="error"><li>' . implode('</li><li>', $install_error) . '</li></ul>'; }?>
            <?php if (!empty($install_warnings)) { echo '<h2 class="warnings">You have warnings</h2><ul class="warnings"><li>' . implode('</li><li>', $install_warnings) . '</li></ul>'; }?>

            <form id="submitform" class="config-form" action="<?php echo URL::site('config/save')?>" method="get">
                <p>
                    <label for="sab_url">Sabnzbd url</label>
                    <input type="text" name="sab_url" id="sab_url" value="<?php if (isset($sab_url)) echo $sab_url; else echo 'http://localhost:8080'; ?>" size="35" />
                </p>
                <p>
                    <label for="sab_api_key">Sabnzbd api key</label>
                    <input type="text" name="sab_api_key" id="sab_api_key" size="35" value="<?php if (isset($sab_api_key)) echo $sab_api_key ?>" />
                </p>
                <p>
                    <label for="matrix_api_key">Use NZB Site</label>
                    Use NZB Matrix <input class="radio-button" type="radio" <?php if ($use_nzb_site == 'nzbMatrix') echo 'checked'?> name="use_nzb_site" value="nzbMatrix" id="nzb_matrix" />
                    Use NZBs.org <input class="radio-button" type="radio" <?php if ($use_nzb_site == 'nzbs') echo 'checked'?> name="use_nzb_site" value="nzbs" id="nzbs" />
                    Use Both <input class="radio-button" type="radio" <?php if ($use_nzb_site == 'both') echo 'checked'?> name="use_nzb_site" value="both" id="both" />
                </p>
                <p>
                    <label for="matrix_api_key">NZB Matrix api key</label>
                    <input type="text" name="matrix_api_key" id="matrix_api_key" size="35" value="<?php if (isset($NzbMatrix_api_key)) echo $NzbMatrix_api_key ?>" />
                </p>
                <p>
                    <label for="matrix_api_user">NZB Matrix username</label>
                    <input type="text" name="matrix_api_user" id="matrix_api_user" size="35" value="<?php if (isset($NzbMatrix_api_user)) echo $NzbMatrix_api_user ?>" />
                </p>
                <p>
                    <label for="nzbs_query_string">NZBs.org URL String</label>
                    <input type="text" name="nzbs_query_string" id="nzbs_query_string" size="35" value="<?php if (isset($nzbs_query_string)) echo $nzbs_query_string ?>" />
                </p>

                <p>
                    <label for="thetvdb_api_key">Thetvdb.com api key</label>
                    <input type="text" name="thetvdb_api_key" id="thetvdb_api_key" size="35" value="<?php if (isset($TheTvDB_api_key)) echo $TheTvDB_api_key ?>" />
                </p>

                <p>
                    <label for="rss_num_results">Rss number of results</label>
                    <input type="text" name="rss_num_results" id="rss_num_results" value="<?php if (isset($rss_num_results)) echo $rss_num_results; else echo '10' ?>" />
                </p>
                <p>
                    <label for="rss_how_old">Rss update every</label>
                    <input type="text" name="rss_how_old" id="rss_how_old" value="<?php if (isset($rss_how_old)) echo $rss_how_old; else echo '3 hours' ?>" />
                    <br />
                    <em>Example: "2 days" or "4 hours"</em>
                </p>
                <p>
                    <label for="series_update_every">All series are updated every</label>
                    <input type="text" name="series_update_every" id="series_update_every" value="<?php if (isset($series_update_every)) echo $series_update_every; else echo '1 week' ?>" />
                    <br />
                    <em>Example: "1 week" or "4 days"</em>
                </p>

                <p>
                    <input class="button"  type="submit" value="<?php echo __('Save')?>" />
                </p>
            </form>

            <?php echo HTML::anchor('#', HTML::image("images/black/banner/star-wars.jpg", array('alt' => 'Bottom Banner', 'class' => 'banner')));?>
            <div class="clearer"></div>
        </div>
    <!-- main ends -->
    </div>
