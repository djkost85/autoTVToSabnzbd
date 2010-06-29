<?php defined('SYSPATH') or die('No direct script access.');
echo $menu;
?>

<style>
div {
    width: 748px;
    padding-top: 20px;
    margin-right: auto;
    margin-left: auto;
}
</style>
<div>
    <p>All sections will be updated and marked as downloaded, will no longer be marked as downloaded.</p>
    <p>Click <a href="<?php echo URL::site('update/doAll')?>" id="update">here</a> if you want to refresh all series.</p>
    <p>This action may take several minutes.</p>
</div>
