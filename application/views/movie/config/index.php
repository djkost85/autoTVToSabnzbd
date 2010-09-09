<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<form id="submitform" class="config-form" action="<?php echo URL::site('movie/config/save')?>" method="get">
    <p>
        <label for="top10_list_genre"><?php echo __('Top 10 list genre')?>:</label>
        <select id="top10_list_genre" name="list[top10][genre]">
            <option value="0" <?php if (0 == $top10listGenre) echo 'selected'?> ><?php echo __('All')?></option>
            <?php foreach ($genres as $genre) { ?>
            <option value="<?php echo $genre->id?>" <?php if ($genre->id == $top10listGenre) echo 'selected'?> ><?php echo $genre->name?></option>
            <?php } ?>
        </select>
    </p>
    <p>
        <label for="new10_list_genre"><?php echo __('New list genre')?>:</label>
        <select id="new10_list_genre" name="list[new10][genre]">
            <option value="0" <?php if (0 == $top10listGenre) echo 'selected'?> ><?php echo __('All')?></option>
            <?php foreach ($genres as $genre) { ?>
            <option value="<?php echo $genre->id?>" <?php if ($genre->id == $new10listGenre) echo 'selected'?> ><?php echo $genre->name?></option>
            <?php } ?>
        </select>
    </p>
    <p>
        <label for="sab_cat"><?php echo __('Sabnzbd category')?>:</label>
        <input type="text" name="sabnzbd[category]" id="sab_cat" value="<?php if (!empty($sabCat)) echo $sabCat?>" />
    </p>

    <p class="submit">
        <input class="button" type="submit" value="<?php echo __('Save')?>" />
    </p>
</form>
