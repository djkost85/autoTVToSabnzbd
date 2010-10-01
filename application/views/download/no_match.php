<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($results);
?>

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
            <?php echo HTML::anchor('', HTML::image('index.php/' . $series->banner, array('alt' => 'Top Banner', 'class' => 'banner')), array('title' => 'Top Banner'));?>

            <h1><?php echo $title?>?</h1>
<ul class="thumbnail">
<?php foreach($results as $id => $result) {
$filesize = $result['size']; // displays in bytes
$file_kb = round(($filesize / 1024), 1); // bytes to KB
$file_mb = round(($filesize / 1048576), 1); // bytes to MB
$file_gb = round(($filesize / 1073741824), 1); // bytes to GB
if ($file_gb > 1) {
    $filesize = $file_gb . ' gb';
} else if ($file_mb > 1) {
    $filesize = $file_mb . ' mb';
} else {
    $filesize = $file_kb . ' kb';
}

$status = 'none';
if (isset($result['downloaded'])) {
    $status = '<em style="color:red">' . __('Alredy downloaded') . '<em>';
} else if (isset($result['noCatMatch'])) {
    $status = __('Categories do not match');
} else if (isset($result['noMatch'])) {
    $status = __('No match');
}


    ?>
    <li>
        <?php echo HTML::anchor("download/doDownload/$id", $result['nzbname'])?>
        <br />
        <?php echo HTML::anchor('http://' . $result['link'], __('External link'))?>
        <br />
        <?php echo __("Category") . ': ' . $result['category']?>
        <br />
        <?php echo __("Group") . ': ' . $result['group']?>
        <br />
        <?php echo __("Comments") . ': ' . $result['comments']?>
        <br />
        <?php echo __("Size") . ': ' . $filesize?>
        <br />
        <?php echo __("Status") . ': ' . $status?>
    </li>
<?php } ?>
</ul>
            <div class="clearer"></div>
        </div>
    </div>

