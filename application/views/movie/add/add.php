<?php
defined('SYSPATH') or die('No direct script access.');
?>

<form id="submitform" action="<?php echo URL::site('movie/add/doAdd')?>" method="get">
    <p>
        <label for="name"><?php echo __('Movie name')?>:</label>
        <input type="text" name="name" id="name" size="30" />
    </p>
    <p>
        <label for="cat"><?php echo __('Download catagory')?>:</label>
        <select id="cat" name="cat">
            <option value="movies-all" style="font-weight: bold;">Movies: ALL</option>
            <option value="1">Movies: DVD</option>
            <option value="2">Movies: Divx/Xvid</option>
            <option value="54">Movies: BRRip</option>
            <option value="42">Movies: HD (x264)</option>
            <option value="50">Movies: HD (Image)</option>
            <option value="48">Movies: WMV-HD</option>
            <option value="3">Movies: SVCD/VCD</option>
            <option value="4">Movies: Other</option>
        </select>
    </p>
    <p>
        <label for="language"><?php echo __('Language')?>:</label>
        <select id="language" name="language">
            <?php foreach ($languages as $lang) { ?>
            <option value="<?php echo $lang->id?>"><?php echo $lang->name?></option>
            <?php } ?>
        </select>
    </p>

    <p class="submit">
        <input class="button" type="submit" value="<?php echo __('Save')?>" />
    </p>
</form>
