<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($results);
?>
<h1 class="page-title episodes-title">
    <?php echo HTML::anchor("", HTML::image('index.php/' . $series->banner, array('alt' => "Banner for $series->series_name")))?>
</h1>
<h2 class="page-title"><?php echo $title?>?</h2>
<ul id="wrong_category">
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

