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
            <?php if (MsgFlash::hasError()) { ?><p class="error"><?php echo HTML::entities(MsgFlash::get(true))?></p> <?php } ?>

            <?php if (!empty($install_error)) { echo '<h2 class="error">You have errors you must tend to</h2><ul class="error"><li>' . implode('</li><li>', $install_error) . '</li></ul>'; }?>
            <?php if (!empty($install_warnings)) { echo '<h2 class="warnings">You have warnings</h2><ul class="warnings"><li>' . implode('</li><li>', $install_warnings) . '</li></ul>'; }?>

            <form id="submitform" class="config-form" action="<?php echo URL::site('config/save')?>" method="get">
                <p>
                    <label for="sab_url">Sabnzbd url</label>
                    <input type="text" name="sab_url" id="sab_url" value="<?php if (isset($sab_url)) echo $sab_url; else echo 'http://localhost:8080'; ?>" size="35" <?php if (isset($correct_sab_url) && $correct_sab_url) echo 'readonly' ?> />
                </p>
                <p>
                    <label for="sab_api_key">Sabnzbd api key</label>
                    <input type="text" name="sab_api_key" id="sab_api_key" size="35" value="<?php if (isset($sab_api_key)) echo $sab_api_key ?>" />
                </p>
                <h3><a href="#" id="sab_auth">Sabnzbd Authentication</a></h3>
                <div class="sab_auth">
                    <p>
                        <label for="sab_username">Sabnzbd username</label>
                        <input type="text" name="sab_username" id="sab_username" size="35" value="<?php if (isset($sab_username)) echo $sab_username ?>" />
                    </p>
                    <p>
                        <label for="sab_password">Sabnzbd password</label>
                        <input type="password" name="sab_password" id="sab_password" size="35" value="<?php if (isset($sab_password)) echo $sab_password ?>" />
                    </p>
                </div>
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
            <style type="text/css">
                .border-under-me {
                    border-bottom: #ffffff 1px solid;
                }
                .border-under-me span {
                    font-size: 14px;
                }
                h2 {
                    padding: 10px;
                }
                #submitform input#delete_small_size {
                    width: 45px;
                }
            </style>

            <h2><?php echo __('Renamer Config');?></h2>
             <form id="submitform" class="config-form-renamer" action="<?php echo URL::site('config/renamer')?>" method="get">
                 <div class="border-under-me">
                    <label for="renamer_pathString">Renamer path srting</label>
                    <input type="text" name="renamer[pathString]" id="renamer_pathString" <?php if (isset($renamer)) echo 'value="'.$renamer['pathString'].'"'?> />
                    <br />
                    <br />
                    <span>Example: ":name/Season :season/:name - :ep_string - :ep_name.:ext" -></span><br />
                    <em>Result: "Chuck/Season 1/Chuck - S01E03 - Chuck vs. the Tango.avi"</em>
                    <br />
                    <p>
                        <span>:name = series name</span> <br />
                        <span>:season = season number</span> <br />
                        <span>:episode = episode number</span> <br />
                        <span>:ep_name = episode name</span> <br />
                        <span>:ep_string = S01E03 or S12E04</span> <br />
                        <span>:ext = file extantion (optional)</span> <br />
                    <p>
                </div>
                 <p>
                    <label for="delete_small_files">Delete Small Files</label>
                    Yes: <input class="radio-button" type="radio" <?php if (isset($renamer) && $renamer['deleteSmallFiles']) echo 'checked'?> name="renamer[deleteSmallFiles]" value="1" />
                    No: <input class="radio-button" type="radio" <?php if (isset($renamer) && !$renamer['deleteSmallFiles']) echo 'checked'?> name="renamer[deleteSmallFiles]" value="0" />
                 </p>
                 <p>
                    <label for="delete_small_size">Minimum Files Size</label>
                    <input id="delete_small_size" name="renamer[minimalFileSize]" type="text" <?php if (isset($renamer['minimalFileSize'])) echo 'value="'.$renamer['minimalFileSize'].'"'; else 'value="30"';?> /> MB
                 </p>

                 <p>
                    <label for="delete_unnecessary_files">Delete File Extensions</label>
                    Yes: <input class="radio-button" type="radio" <?php if (isset($renamer) && $renamer['deleteUnnecessaryFiles']) echo 'checked'?> name="renamer[deleteUnnecessaryFiles]" value="1" />
                    No: <input class="radio-button" type="radio" <?php if (isset($renamer) && !$renamer['deleteUnnecessaryFiles']) echo 'checked'?> name="renamer[deleteUnnecessaryFiles]" value="0" />
                 </p>
                 <p>
                    <label for="files_to_delete">File Extensions to Delete</label>
                    <input type="text" id="files_to_delete" name="renamer[deleteExt]" value="<?php if (isset($renamer['deleteExt'])) echo $renamer['deleteExt']?>" />
                    <em>Example: nfo or nfo, sfv</em>
                 </p>
                 <p>
                    <input class="button"  type="submit" value="<?php echo __('Save')?>" />
                </p>
             </form>

            <h2><?php echo __('Subtitles');?></h2>
            <form id="submitform" class="config-form-renamer" action="<?php echo URL::site('config/subtitles')?>" method="get">
                <p>
                    <label for="dl_sub">Download subtitles</label>
                    Yes: <input class="radio-button" type="radio" <?php if (isset($subtitles) && @$subtitles['download']) echo 'checked'?> name="download" value="1" />
                    No: <input class="radio-button" type="radio" <?php if (isset($subtitles) && !@$subtitles['download']) echo 'checked'?> name="download" value="0" />
                 </p>
                 <p>
                     <label for="save_dir"><?php echo __('Stored here')?></label>
                     <input type="text" name="save_dir" id="save_dir" value="H:\usenet\subs" />
                 </p>
                <p>
                    <label for="lang"><?php echo __('Language')?></label>
                    <select name="lang" id="lang">
                        <option value="8"><?php echo __('Swedish')?></option>
                    </select>
                </p>
                <p>
                    <input class="button"  type="submit" value="<?php echo __('Save')?>" />
                </p>
            </form>

            <?php echo HTML::anchor('#', HTML::image("images/black/banner/star-wars.jpg", array('alt' => 'Bottom Banner', 'class' => 'banner')));?>
        </div>
    <!-- main ends -->
    </div>

<script type="text/javascript">
if ($('#sab_username').val() == "") {$('.sab_auth').hide();}

$('#sab_auth').click(function () {
    $('.sab_auth').toggle();
    return false;
});

$('#sab_url').click(function () {
    if ($('#sab_url').attr("readonly") == true) {
        if(confirm("I have confirmed that this is the right url.\n" + "Do you want to change it anyway?")) {
            $('#sab_url').val('');
            $('#readonly').removeAttr("readonly");
        }
    }
});
</script>
