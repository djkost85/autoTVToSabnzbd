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
            <option value="movies-all" style="font-weight: bold;" <?php if ($matrixCat == "movies-all") echo 'selected'?> >Movies: ALL</option>
            <option value="1" <?php if ($matrixCat == '1') echo 'selected'?> >Movies: DVD</option>
            <option value="2" <?php if ($matrixCat == '2') echo 'selected'?> >Movies: Divx/Xvid</option>
            <option value="54" <?php if ($matrixCat == '54') echo 'selected'?> >Movies: BRRip</option>
            <option value="42" <?php if ($matrixCat == '42') echo 'selected'?> >Movies: HD (x264)</option>
            <option value="50" <?php if ($matrixCat == '50') echo 'selected'?> >Movies: HD (Image)</option>
            <option value="48" <?php if ($matrixCat == '48') echo 'selected'?> >Movies: WMV-HD</option>
            <option value="3" <?php if ($matrixCat == '3') echo 'selected'?> >Movies: SVCD/VCD</option>
            <option value="4" <?php if ($matrixCat == '4') echo 'selected'?> >Movies: Other</option>
        </select>
    </p>

    <p class="submit">
        <input class="button" type="submit" value="<?php echo __('Save')?>" />
    </p>
</form>

