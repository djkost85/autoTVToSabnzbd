<?php defined('SYSPATH') or exit('Install tests must be loaded from within index.php!');

function getSabStatus($response) {
    if (preg_match('@^HTTP/[0-9]\.[0-9] ([0-9]{3})@', $response, $matches)) {
        return $matches[1];
    }
    return null;
}

function testSab($server) {
    $server = preg_replace('#^http://#i', '', $server);
    $fp = @fsockopen($server, 8080, $errno, $errstr, 30);

    $page = "/sabnzbd";
    $out = "GET /$page HTTP/1.1\r\n";
    $out .= "Host: $server\r\n";
    $out .= "Connection: Close\r\n\r\n";
    @fwrite($fp,$out);

    return (getSabStatus(@fgets($fp)) == 200);
}

function getWarnings($server, $apiKey) {
    $query = "/sabnzbd/api?mode=warnings&output=json&apikey=$apiKey";
    $filename = $server.$query;
    $json = json_decode(file_get_contents($filename));
    if (isset($json->status))
        return $json->error;
    else
        return $json->warnings;
}

function apacheModuleLoaded($modName) {
    $modules = apache_get_modules();

    return in_array($modName, $modules);
}

$loadedArr['isPHP_5_2_3'] = version_compare(PHP_VERSION, '5.2.3', '>=');
$loadedArr['curlLoaded'] = extension_loaded('curl');
$loadedArr['gdLoaded'] = function_exists('gd_info');

$loadedArr['splLoaded'] = function_exists('spl_autoload_register');
$loadedArr['reflectionLoaded'] = class_exists('ReflectionClass');
$loadedArr['filterLoaded'] = function_exists('filter_list');
$loadedArr['iconvLoaded'] = extension_loaded('iconv');
$loadedArr['mbstringLoadeed'] = extension_loaded('mbstring');


$loadedArr['systemDir'] = is_dir(SYSPATH) AND is_file(SYSPATH.'classes/kohana'.EXT);
$loadedArr['applicationDir'] = is_file(APPPATH.'bootstrap'.EXT);
$loadedArr['cacheDir'] = is_dir(APPPATH.'cache') AND is_writable(APPPATH.'cache');
$loadedArr['logsDir'] = is_dir(APPPATH.'logs') AND is_writable(APPPATH.'logs');
$loadedArr['configDir'] = is_dir(APPPATH.'config') AND is_writable(APPPATH.'config');
if (is_dir(realpath(APPPATH.'../images')) AND
        is_writable(realpath(APPPATH.'../images')) AND
        is_writable(realpath(APPPATH.'../images/__cache')) AND
        is_writable(realpath(APPPATH.'../images/banner')) AND
        is_writable(realpath(APPPATH.'../images/poster')) AND
        is_writable(realpath(APPPATH.'../images/fanart'))) {
    $loadedArr['imagesDir'] = true;
} else {
    $loadedArr['imagesDir'] = false;
}


$loadedArr['requestUri'] = true;

if (!filter_has_var(INPUT_GET, 'save')) {
    $requestUri = preg_replace('/\/index.php/', '', $_SERVER['REQUEST_URI']);
    $requestUri = '/' . trim($requestUri, '/') . '/';
    $loadedArr['requestUri'] = ($requestUri == '/autoTvToSab/');
}

$loadedArr['utf8Support'] = @preg_match('/^.$/u', 'ñ');
$loadedArr['unicodeSupport'] = @preg_match('/^\pL$/u', 'ñ');
$loadedArr['URI_Determination'] = isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF']) OR isset($_SERVER['PATH_INFO']);



$optionalLoadedArr['pdoLoaded'] = class_exists('PDO');
$optionalLoadedArr['modeRewriteLoded'] = apacheModuleLoaded('mod_rewrite');
$optionalLoadedArr['mcryptLoaded'] = extension_loaded('mcrypt');

$errorMsg = array();
$configSaved = false;
if (filter_has_var(INPUT_GET, 'save')) {
//    var_dump($_GET);

    $defs = array(
        'use_nzb_site'  => FILTER_SANITIZE_STRING,
        'nzbs_query_string'  => FILTER_SANITIZE_STRING,
        'matrix_api_key'    => FILTER_SANITIZE_STRING,
        'matrix_api_user'    => FILTER_SANITIZE_STRING,
        'thetvdb_api_key'   => FILTER_SANITIZE_STRING,
        'sab_api_key'       => FILTER_SANITIZE_STRING,
        'rss_how_old'       => array('filter'=>FILTER_SANITIZE_STRING,
                                   'options'   => array('min_range' => 4, 'max_range' => 20)),
        'sab_url'           => FILTER_VALIDATE_URL,
        'rss_num_results'   => FILTER_VALIDATE_INT,
        'db_host'           => FILTER_DEFAULT,
        'db_user'           => FILTER_DEFAULT,
        'db_pass'           => FILTER_DEFAULT,
        'db_dbname'         => FILTER_DEFAULT,
              );

    $get = filter_input_array(INPUT_GET, $defs);

    $link = @mysql_connect($get['db_host'], $get['db_user'], $get['db_pass']);
    if (!$link) {
        $errorMsg[] = "Can not login to the database. Check the login data to the database are correct : " . mysql_error();
    }

    $db_selected = @mysql_select_db($get['db_dbname'], $link);
    if (!$db_selected) {
        if (!@mysql_query("CREATE DATABASE {$get['db_dbname']}", $link)) {
            $errorMsg[] = 'Error creating database: "'.$get['db_dbname'].'". Mysql error: ' . mysql_error();
        } else if (@mysql_select_db($get['db_dbname'], $link)) {
            $tables = file_get_contents('database.sql');
            foreach (explode(';', $tables) as $table) {
                mysql_query($table, $link);
            }
        }
    }

    if (!testSab($get['sab_url'])) {
        $errorMsg[] = "Incorrect URL: {$get['sab_url']}";
    }

    $SabWarnings = getWarnings($get['sab_url'], $get['sab_api_key']);
    if (is_string($SabWarnings)) {
        $errorMsg[] = "SABnzbd error: $SabWarnings";
    }
	
	if (empty($get['use_nzb_site'])) {
		if (empty($get['matrix_api_user']) && !empty($get['nzbs_query_string'])) {
			$get['use_nzb_site'] = 'nzbs';
		} else {
			$get['use_nzb_site'] = 'nzbMatrix';
		}
	}

    if (!in_array(false, $loadedArr, true) && !in_array(null, $get, true) && !in_array(false, $get, true) && empty($errorMsg)) {

        $config = "<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'imdb' => false,
    'default' => array(
        'saveImagesAsNew' => false,
        'cacheTimeImages' => (3600 * 3),
        'TheTvDB_api_key' => '{$get['thetvdb_api_key']}',
        'NzbMatrix_api_key' => '{$get['matrix_api_key']}',
        'NzbMatrix_api_user' => '{$get['matrix_api_user']}',
        'useNzbSite' => '{$get['use_nzb_site']}', //nzbs
    ),

    'Sabnzbd' => array(
        'api_key' => '{$get['sab_api_key']}',
        'url' => '{$get['sab_url']}',
    ),

    'rss' => array(
        'numberOfResults' => {$get['rss_num_results']},
        'howOld' => '{$get['rss_how_old']}' //\"-1 week\" \"-2 days\" \"-4 hours\" \"-2 seconds\" uses strtotime()
    ),

    'nzbs' => array(
        'queryString' => '{$get['nzbs_query_string']}'
    ),
);

?>";

        file_put_contents('application/config/default.php', $config);
        $get['db_pass'] = (empty($get['db_pass'])) ? "FALSE": "'{$get['db_pass']}'";
        $config = "<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'mysql',
		'connection' => array(
			/**
			 * The following options are available for MySQL:
			 *
			 * string   hostname
			 * string   username
			 * string   password
			 * boolean  persistent
			 * string   database
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'hostname'   => '{$get['db_host']}',
			'username'   => '{$get['db_user']}',
			'password'   => {$get['db_pass']},
			'persistent' => FALSE,
			'database'   => '{$get['db_dbname']}',
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
	'alternate' => array(
		'type'       => 'pdo',
		'connection' => array(
			/**
			 * The following options are available for PDO:
			 *
			 * string   dsn
			 * string   username
			 * string   password
			 * boolean  persistent
			 * string   identifier
			 */
			'dsn'        => 'mysql:host=localhost;dbname=kohana',
			'username'   => 'root',
			'password'   => 'r00tdb',
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
);";

        file_put_contents('application/config/database.php', $config);

        $configSaved = true;
    }

}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>AutoTvToSab Installation</title>

        <script type="text/javascript" src="js/jQuery.js"></script>

        <script type="text/javascript">
            function isUrl(s) {
                var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
                return regexp.test(s);
            }


            var isNumber = function(num) {
                //return typeof o === 'number' && isFinite(o);
                var RE = /^-{0,1}\d*\.{0,1}\d+$/;
                return (RE.test(num));
            }

            $.fn.extend({
                scrollTo : function(speed, easing) {
                    return this.each(function() {
                        var targetOffset = $(this).offset().top;
                        $('html,body').animate({scrollTop: targetOffset}, speed, easing);
                    });
                }
            });

            $(document).ready(function(){
                //hide message_body after the first one
                $(".message_list .message_body:gt(3)").hide();
                $(".message_head:lt(4) cite").removeClass('down').addClass('up');

                var collapsNum = 5;
                //hide message li after the 5th
                $(".message_list li:gt("+collapsNum+")").hide();

                //toggle message_body
                $(".message_head").click(function(){

                    if ($(this).find('cite').hasClass('up')) $(this).find('cite').removeClass('up').addClass('down')
                    else $(this).find('cite').removeClass('down').addClass('up')

                    $(this).next(".message_body").slideToggle(500)
                    return false;
                });

                <?php if (in_array(false, $loadedArr, true) || in_array(false, $optionalLoadedArr, true)) { ?>
                    $(".message_list .environment").show();
                    $("#environment_header").scrollTo(1000)
                <?php } ?>

                //collapse all messages
                $(".collpase_all_message").click(function(){
                    $(".message_body").slideUp(500)
                    return false;
                });

                //show all messages
//                $(".show_all_message").click(function(){
//                    $(this).hide()
//                    $(".show_recent_only").show()
//                    $(".message_list li:gt("+collapsNum+")").slideDown()
//                    return false;
//                });
//
//                //show recent messages only
//                $(".show_recent_only").click(function(){
//                    $(this).hide()
//                    $(".show_all_message").show()
//                    $(".message_list li:gt("+collapsNum+")").slideUp()
//                    return false;
//                });


                $(":input").focus(function(){
                    if ($(this).hasClass("needsfilled") ) {
                        $(this).val("");
                        $(this).removeClass("needsfilled");
                        $(this).parents('div.message_body').prev().removeClass('error');
                    }
                });



                var required = ["sab_api_key", "matrix_api_key", "thetvdb_api_key", "rss_num_results",
                    "rss_how_old", "db_host", "db_user", /*"db_pass", */"db_dbname"];
                // If using an ID other than #email or #error then replace it here
                var url = $("#sab_url");
                var errornotice = $("#error");
                var rssNum = $("#rss_num_results");
                // The text to show up within a field when it is incorrect
                var emptyError = "Please fill out this field.";
                var urlError = "Please enter a valid url.";
                var numError = "Please enter a valid number.";



                $('form').submit(function (e) {
                    $('.message_list .message_head').removeClass('error');

                    for (i = 0; i < required.length; i++) {
                        var input = $('#'+required[i]);
                        if ((input.val() == "") || (input.val() == emptyError)) {
                            input.addClass("needsfilled");
                            input.parents('div.message_body').prev().addClass('error');
                            input.val(emptyError);
                            errornotice.fadeIn(750);
                        } else {
                            input.removeClass("needsfilled");
                        }
                    }

                    if (!isUrl(url.val())) {
                        url.val(urlError);
                        url.addClass("needsfilled");
                        url.parents('div.message_body').prev().addClass('error');
                        errornotice.fadeIn(750);
                    }

                    if (!isNumber(rssNum.val())) {
                        rssNum.val(numError);
                        rssNum.addClass("needsfilled");
                        rssNum.parents('div.message_body').prev().addClass('error');
                        errornotice.fadeIn(750);
                    }

                    if ($(":input").hasClass("needsfilled")) {
                        return false;
                    } else {
                        errornotice.hide();
                        return true;
                    }
                });

            });

            $(document).ready(function(){
                $('#nzb_matrix').click(function () {
                    $('#nzbs_wrapper').hide().find('input').removeClass('needsfilled');
                    $('#nzb_matrix_wrapper').show().find('input').each(function (){
                        var input = $(this);
                        if (input.val() == '') {
                            input.addClass('needsfilled');
                        }
                    });
                });
                $('#nzbs').click(function () {
                    $('#nzb_matrix_wrapper').hide().find('input').removeClass('needsfilled');
                    $('#nzbs_wrapper').show().find('input').each(function (){
                        var input = $(this);
                        if (input.val() == '') {
                            input.addClass('needsfilled');
                        }
                    });
                });
                $('#both').click(function () {
                    $('#nzb_matrix_wrapper').show().find('input').find('input').each(function (){
                        var input = $(this);
                        if (input.val() == '') {
                            input.addClass('needsfilled');
                        }
                    });
                    $('#nzbs_wrapper').show().find('input').find('input').each(function (){
                        var input = $(this);
                        if (input.val() == '') {
                            input.addClass('needsfilled');
                        }
                    });
                });
            });

        </script>



        <style type="text/css">
            body { width: 42em; margin: 0 auto; font-family: sans-serif; background: #fff; font-size: 1em; }
            h2 { letter-spacing: -0.04em; }
            h2 + p { margin: 0 0 2em; color: #333; font-size: 90%; font-style: italic; }
            code { font-family: monaco, monospace; }
            table { border-collapse: collapse; width: 100%; }
            table th,
            table td { padding: 0.4em; text-align: left; vertical-align: top; }
            table th { width: 12em; font-weight: normal; }
            table tr:nth-child(odd) { background: #eee; }
            table td.pass { color: #191; }
            table td.fail { color: #911; }
            #results { padding: 0.8em; color: #fff; font-size: 1.5em; }
            #results.pass { background: #191; }
            #results.fail { background: #911; }

            /*body {
	margin: 10px auto;
	width: 570px;
	font: 75%/120% Arial, Helvetica, sans-serif;
            }*/
            p {
                padding: 0 0 1em;
            }
            /* message display page */
            .message_list {
                list-style: none;
                margin: 0;
                padding: 0;
                width: 42em;
            }
            .message_list li {
                padding: 0;
                margin: 0;
                background: url(images/message-bar.gif) no-repeat;
            }
            .message_head {
                padding: 5px 10px;
                cursor: pointer;
                position: relative;
                background: #eee;
            }
            .message_head .order {
                color: #666666;
                font-size: 95%;
                position: absolute;
                right: 10px;
                top: 5px;
            }
            .message_head cite {
                font-size: 100%;
                font-weight: bold;
                font-style: normal;
                padding-left: 24px;
            }
            .message_body {
                padding: 5px 10px 15px;
            }

            .message_body div {
                clear: both;
            }
            .collapse_buttons {
                text-align: right;
                border-top: solid 1px #e4e4e4;
                padding: 5px 0;
                width: 383px;
            }
            .collapse_buttons a {
                margin-left: 15px;
                float: right;
            }

            .show_all_message {
                background: url(images/tall-down-arrow.gif) no-repeat right center;
                padding-right: 12px;
            }
            .show_recent_only {
                display: none;
                background: url(images/tall-up-arrow.gif) no-repeat right center;
                padding-right: 12px;
            }
            .collpase_all_message {
                background: url(images/collapse-all.gif) no-repeat right center;
                padding-right: 12px;
                color: #666666;
            }

            #error {
                color: #911;
                font-size:10px;
                display:none;
            }
            .needsfilled, .error {
                background: #911;
                color:white;
            }


            label {
                float: left;
                width: 155px;
                margin-right: 10px;
            }

            label:hover {
                background: #e4e4e4;
            }



            .message_head cite.up {
                background: url(images/arrow-square.gif) no-repeat 0 2px;
                padding-right: 50px;
            }
            .message_head cite.down {
                background: url(images/arrow-square.gif) no-repeat 0 -54px;
            }

            div.fail {
                background: orange;
                padding: 0.8em;
                color: #fff;
                font-size: 1.5em;
            }

        </style>

    </head>
    <body>
        <?php if ($configSaved) { ?>
        <p id="results" class="pass">✔ Your environment passed all requirements.<br />
			Remove or rename the <code>install<?php echo EXT ?></code> file now.</p>
        <?php if (isset($SabWarnings) && is_array($SabWarnings) && !empty($SabWarnings)) { ?>
        <p class="fail">SABnzbd errors:</p>
        <ul class="fail">
            <li><?php echo implode('</li><li>', $SabWarnings)?></li>
        </ul>
       <?php } ?>
        <?php } else { ?>

        <?php if (!empty($errorMsg)) { ?>
        <?php foreach ($errorMsg as $msg) { ?>
            <p id="results" class="fail">✘ <?php echo $msg ?></p>
            <?php }
        } ?>
        <h2>Fields marked in red are important</h2>
        <p>Follow the instructions <a href="http://sourceforge.net/apps/trac/autotvtosab/">here</a> before continuing.</p>
        <p id="error">You have an error in the installation form</p>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
        <ol class="message_list">
            <li>

                <p class="message_head"><cite class="down">Databas variables</cite> <span class="order">1</span></p>
                <div class="message_body">
                    <div>
                        <label for="db_host">Hostname</label>
                        <input type="text" name="db_host" id="db_host" value="<?php if (isset($get['db_host'])) echo $get['db_host']; else echo 'localhost'; ?>" size="35" />
                    </div>
                    <div>
                        <label for="db_user">Username</label>
                        <input type="text" name="db_user" id="db_user" size="35" class="<?php if (!isset($get['db_user'])) echo 'needsfilled'?>" value="<?php if (isset($get['db_user'])) echo $get['db_user'] ?>" />
                    </div>
                    <div>
                        <label for="db_pass">Password</label>
                        <input type="password" name="db_pass" id="db_pass" size="35" class="<?php if (!isset($get['db_pass'])) echo 'needsfilled'?>" />
                    </div>
                    <div>
                        <label for="db_dbname">Database name</label>
                        <!--<input type="text" name="db_dbname" id="db_dbname" size="35" class="<?php //if (!isset($get['db_dbname'])) echo 'needsfilled'?>" value="<?php //if (isset($get['db_dbname'])) echo $get['db_dbname'] ?>" />-->
                        <input type="text" name="db_dbname" id="db_dbname" size="35" value="<?php if (isset($get['db_dbname'])) echo $get['db_dbname']; else echo 'autotvtosab'; ?>" />
                    </div>
                </div>

            </li>
            <li>

                <p class="message_head"><cite class="down">Set Sabnzbd variables</cite> <span class="order">2</span></p>
                <div class="message_body">
                    <div>
                        <label for="sab_url">Sabnzbd url</label>
                        <input type="text" name="sab_url" id="sab_url" value="<?php if (isset($get['sab_url'])) echo $get['sab_url']; else echo 'http://localhost:8080'; ?>" size="35" />
                    </div>
                    <div>
                        <label for="sab_api_key">Sabnzbd api key</label>
                        <input type="text" name="sab_api_key" id="sab_api_key" size="35" value="<?php if (isset($get['sab_api_key'])) echo $get['sab_api_key'] ?>" class="<?php if (!isset($get['sab_api_key'])) echo 'needsfilled'?>" />
                    </div>
                </div>

            </li>
            <li>
                <p class="message_head"><cite class="down">Set NZB site variables</cite> <span class="order">3</span></p>
                <div class="message_body">
                    <div>
                        <label for="matrix_api_key">Use NZB Site</label>
                        Use NZB Matrix<input type="radio" name="use_nzb_site" value="nzbMatrix" id="nzb_matrix" />
                        Use NZBs.org<input type="radio" name="use_nzb_site" value="nzbs" id="nzbs" />
                        Use Both<input type="radio" name="use_nzb_site" value="both" id="both" />
                    </div>
                    <div id="nzb_matrix_wrapper">
                        <div>
                            <label for="matrix_api_key">NZB Matrix api key</label>
                            <input type="text" name="matrix_api_key" id="matrix_api_key" size="35" value="<?php if (isset($get['matrix_api_key'])) echo $get['matrix_api_key'] ?>" class="<?php if (!isset($get['matrix_api_key'])) echo 'needsfilled'?>" />
                        </div>
                        <div>
                            <label for="matrix_api_user">NZB Matrix username</label>
                            <input type="text" name="matrix_api_user" id="matrix_api_user" size="35" value="<?php if (isset($get['matrix_api_user'])) echo $get['matrix_api_user'] ?>" class="<?php if (!isset($get['matrix_api_user'])) echo 'needsfilled'?>" />
                        </div>
                        <div>
                            If you dont have an VIP account on Nzbmatrix.com
                            <a href="http://nzbmatrix.com/account-signup.php">click here</a>
                            and register for one
                        </div>
                    </div>
                    <div id="nzbs_wrapper" style="display: none;">
                        <div>
                            <label for="nzbs_query_string">NZBs.org URL String</label>
                            <input type="text" name="nzbs_query_string" id="nzbs_query_string" size="35" value="<?php if (isset($get['nzbs_query_string'])) echo $get['nzbs_query_string'] ?>" />
                        </div>
                    </div>
                </div>
            </li>

            <li>
                <p class="message_head"><cite class="down">Set Thetvdb.com variables</cite> <span class="order">4</span></p>
                <div class="message_body">
                    <div>
                        <label for="thetvdb_api_key">Thetvdb.com api key</label>
                        <input type="text" name="thetvdb_api_key" id="thetvdb_api_key" size="35" value="<?php if (isset($get['thetvdb_api_key'])) echo $get['thetvdb_api_key'] ?>" class="<?php if (!isset($get['thetvdb_api_key'])) echo 'needsfilled'?>" />
                    </div>
                    <div>
                        If you dont have an account on Thetvdb.com
                        <a href="http://thetvdb.com/?tab=register">click here</a>
                        and register for one
                    </div>
                </div>
            </li>
            <li>
                <p class="message_head"><cite class="down">RSS variables</cite> <span class="order">5</span></p>
                <div class="message_body">
                    <p>Do not touch unless you know what you are doing</p>
                    <div>
                        <label for="rss_num_results">Rss number of results</label>
                        <input type="text" name="rss_num_results" id="rss_num_results" value="<?php if (isset($get['rss_num_results'])) echo $get['rss_num_results']; else echo '10' ?>" />
                    </div>
                    <div>
                        <label for="rss_how_old">How old the results should be</label>
                        <input type="text" name="rss_how_old" id="rss_how_old" value="<?php if (isset($get['rss_how_old'])) echo $get['rss_how_old']; else echo '-1 days' ?>" />
                        <em>Example: -1 week or -4 hours</em>
                    </div>
                </div>
            </li>
            <li>
                <p id="environment_header" class="message_head"><cite class="down">Environment Tests</cite> <span class="order">6</span></p>
                <div class="message_body environment">
                    <p>
                        The following tests have been run to determine if AutoTvToSab will work in your environment.
                    </p>

                    <?php $failed = FALSE ?>

                    <table cellspacing="0">
                        <tr>
                            <th>PHP Version</th>
                            <?php if ($loadedArr['isPHP_5_2_3']): ?>
                            <td class="pass"><?php echo PHP_VERSION ?></td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">AutoTvToSab requires PHP 5.2.3 or newer, this version is <?php echo PHP_VERSION ?>.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>System Directory</th>
                            <?php if (is_dir(SYSPATH) AND is_file(SYSPATH.'classes/kohana'.EXT)): ?>
                            <td class="pass"><?php echo SYSPATH ?></td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">The configured <code>system</code> directory does not exist or does not contain required files.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Application Directory</th>
                            <?php if (is_dir(APPPATH) AND is_file(APPPATH.'bootstrap'.EXT)): ?>
                            <td class="pass"><?php echo APPPATH ?></td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">The configured <code>application</code> directory does not exist or does not contain required files.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Cache Directory</th>
                            <?php if ($loadedArr['cacheDir']): ?>
                            <td class="pass"><?php echo APPPATH.'cache/' ?></td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">The <code><?php echo APPPATH.'cache/' ?></code> directory is not writable.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Logs Directory</th>
                            <?php if ($loadedArr['logsDir']): ?>
                            <td class="pass"><?php echo APPPATH.'logs/' ?></td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">The <code><?php echo APPPATH.'logs/' ?></code> directory is not writable.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Config Directory</th>
                            <?php if ($loadedArr['configDir']): ?>
                            <td class="pass"><?php echo APPPATH.'config/' ?></td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">The <code><?php echo APPPATH.'config/' ?></code> directory is not writable.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Images Directory</th>
                            <?php if ($loadedArr['imagesDir']): ?>
                            <td class="pass"><?php echo APPPATH.'images/' ?></td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">The <code><?php echo APPPATH.'images/' ?></code> directory or it´s subdirectories is not writable.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>PCRE UTF-8</th>
                            <?php if ( ! @preg_match('/^.$/u', 'ñ')): $failed = TRUE ?>
                            <td class="fail"><a href="http://php.net/pcre">PCRE</a> has not been compiled with UTF-8 support.</td>
                            <?php elseif ( ! @preg_match('/^\pL$/u', 'ñ')): $failed = TRUE ?>
                            <td class="fail"><a href="http://php.net/pcre">PCRE</a> has not been compiled with Unicode property support.</td>
                            <?php else: ?>
                            <td class="pass">Pass</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>SPL Enabled</th>
                            <?php if ($loadedArr['splLoaded']): ?>
                            <td class="pass">Pass</td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">PHP <a href="http://www.php.net/spl">SPL</a> is either not loaded or not compiled in.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Reflection Enabled</th>
                            <?php if ($loadedArr['reflectionLoaded']): ?>
                            <td class="pass">Pass</td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">PHP <a href="http://www.php.net/reflection">reflection</a> is either not loaded or not compiled in.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Filters Enabled</th>
                            <?php if ($loadedArr['filterLoaded']): ?>
                            <td class="pass">Pass</td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">The <a href="http://www.php.net/filter">filter</a> extension is either not loaded or not compiled in.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Iconv Extension Loaded</th>
                            <?php if ($loadedArr['iconvLoaded']): ?>
                            <td class="pass">Pass</td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">The <a href="http://php.net/iconv">iconv</a> extension is not loaded.</td>
                            <?php endif ?>
                        </tr>
                        <?php if ($loadedArr['mbstringLoadeed']): ?>
                        <tr>
                            <th>Mbstring Not Overloaded</th>
                                <?php if (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING): $failed = TRUE ?>
                            <td class="fail">The <a href="http://php.net/mbstring">mbstring</a> extension is overloading PHP's native string functions.</td>
                                <?php else: ?>
                            <td class="pass">Pass</td>
                                <?php endif ?>
                        </tr>
                        <?php endif ?>
                        <tr>
                            <th>URI Determination</th>
                            <?php if (isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF']) OR isset($_SERVER['PATH_INFO'])): ?>
                            <td class="pass">Pass</td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">Neither <code>$_SERVER['REQUEST_URI']</code>, <code>$_SERVER['PHP_SELF']</code>, or <code>$_SERVER['PATH_INFO']</code> is available.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>cURL Enabled</th>
                            <?php if ($loadedArr['curlLoaded']): ?>
                            <td class="pass">Pass</td>
                            <?php else: ?>
                            <td class="fail">AutoTvToSab requires <a href="http://php.net/curl">cURL</a> for the Remote class.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>GD Enabled</th>
                            <?php if ($loadedArr['gdLoaded']): ?>
                            <td class="pass">Pass</td>
                            <?php else: ?>
                            <td class="fail">AutoTvToSab requires <a href="http://php.net/gd">GD</a> v2 for the Image class.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Base url</th>
                            <?php if ($loadedArr['requestUri']): ?>
                            <td class="pass">Pass</td>
                            <?php else: ?>
                            <td class="fail">AutoTvToSab requires this line <code>'base_url' => '/autoTvToSab/',</code> in application/bootstrap.php to be set to <code>'base_url' => '<?php echo $requestUri?>'</code>.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th colspan="2"><h2>This is optional</h2></th>
                        </tr>
                        <tr>
                            <th>Apache mod_rewrite</th>
                            <?php if ($optionalLoadedArr['modeRewriteLoded']): ?>
                            <td class="pass">Pass</td>
                            <?php else: $failed = TRUE ?>
                            <td class="fail">
                                AutoTvToSab requires <a href="http://httpd.apache.org/docs/2.0/mod/mod_rewrite.html">mod_rewrite</a> to rewrite requested URLs on the fly.
                                You can use autoTvToSab without mod_rewrite. But then you must change this line <code>'index_file' => FALSE,</code> in application/bootstrap.php to
                                <code>'index_file' => 'index.php',</code> and delete the .htaccess file.
                            </td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>mcrypt Enabled</th>
                            <?php if ($optionalLoadedArr['mcryptLoaded']): ?>
                            <td class="pass">Pass</td>
                            <?php else: ?>
                            <td class="fail">AutoTvToSab requires <a href="http://php.net/mcrypt">mcrypt</a> for the Encrypt class.</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>PDO Enabled</th>
                            <?php if ($optionalLoadedArr['pdoLoaded']): ?>
                            <td class="pass">Pass</td>
                            <?php else: ?>
                            <td class="fail">AutoTvToSab can use <a href="http://php.net/pdo">PDO</a> to support additional databases.</td>
                            <?php endif ?>
                        </tr>
                    </table>

                    <?php if ($failed === TRUE || in_array(false, $loadedArr, true)): ?>
                    <p id="results" class="fail">✘ AutoTvToSab may not work correctly with your environment.</p>
                    <?php endif ?>
                </div>
            </li>
        </ol>
            <p>
                <input type="submit" name="save" value="save" />
            </p>
        <p class="collapse_buttons">
            <!--<a href="#" class="show_all_message">Show all message (9)</a>
            <a href="#" class="show_recent_only">Show 5 only</a>-->
            <a href="#" class="collpase_all_message">Collapse all</a>
        </p>
        </form>
        <?php } ?>
    </body>
</html>
