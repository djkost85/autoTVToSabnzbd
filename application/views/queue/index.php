<?php defined('SYSPATH') or die('No direct script access.'); ?>

<style>
table {
    border-collapse: collapse;
    width: 100%;
}
table th,
table td {
    padding: 4px;
    text-align: left;
    vertical-align: top;
}
table th {
    font-weight: normal;
}
table tr:nth-child(odd) {
    background: #eee;
    color: #000;
}
table tr:hover {
    background-color:lightgrey
}

ul {
    list-style-type: none;
    margin: 5px;
}

#sub-nav {
    width: 350px;
    padding-top: 8px;
}

#sub-nav li {
    display: inline;
    margin: 0 10px 0 2px;
    text-decoration: underline;
}

div.progress-container {
    border: 1px solid #ccc;
    width: 100px;
    margin: 2px 5px 2px 0;
    padding: 1px;
    float: left;
    background: white;
}
div.progress-container > div {
    background-color: #ACE97C;
    height: 12px;
    text-align: center;
    font-size: 10px;
}

</style>

<ul id="sub-nav">
    <li><a class="sab" href="<?php echo $deleteAll?>"><?php echo __('Delete')?></a></li>
    <?php if (!$pauseNum) { ?>
        <li><a class="sab" href="<?php echo $pause?>"><?php echo __('Pause')?></a></li>
    <?php } else { ?>
        <li><a class="sab" href="<?php echo $resume?>"><?php echo __('Resume');?></a></li>
    <?php 
    }
    if ($restart) { ?>
        <li><a class="sab" href="<?php echo $restart?>"><?php echo __('Restart')?></a></li>
    <?php } ?>
    <li><a class="sab" href="<?php echo $shutdown?>"><?php echo __('Shutdown')?></a></li>
    <li>
        <div class="progress-container total">
            <div></div>
        </div>
    </li>
</ul>

<table cellpadding="2" cellspacing="5">
    <tr>
        <th colspan="3"></th>
        <th><?php echo __('Order')?></th>
        <th><?php echo __('Category')?></th>
        <th><?php echo __('Processing')?></th>
        <th><?php echo __('Priority')?></th>
        <th><?php echo __('Script')?></th>
        <th><?php echo __('Name')?></th>
        <th><?php echo __('Remain/Total')?></th>
        <th><?php echo __('Left')?></th>
        <th><?php echo __('Age')?></th>
    </tr>
        <?php foreach($queue as $q) { ?>
        <tr>
            <td><a class="files" id="<?php echo $q->nzo_id?>" href="#">+</a></td>
            <td><a class="sab" href="<?php echo $q->deleteLink?>"><?php echo __('Delete')?></a></td>
            <?php if (!$q->paused) { ?>
                <td><a class="sab" href="<?php echo $q->pauseLink?>"><?php echo __('Pause')?></a></td>
            <?php } else { ?>
                <td><a class="sab" href="<?php echo $q->resumeLink?>"><?php echo __('Resume');?></a></td>
            <?php } ?>
            <td>
                <form>
                    <select>
                    <?php foreach($q->prepMove as $index => $value) { ?>
                        <option value="<?php echo $value?>" <?php if ($index == $q->index) echo 'selected'?>><?php echo $index?></option>
                    <?php } ?>
                    </select
                </form>
            </td>
            <td>
                <form>
                    <select>
                        <?php foreach ($q->prepCategories as $cat => $value) { ?>
                        <option value="<?php echo $value?>" <?php if ($cat == $q->cat) echo 'selected'?>><?php echo __($cat)?></option>
                        <?php } ?>
                    </select>
                </form>
            </td>
            <td>
                <form>
                    <select>
                        <?php $i = 0; foreach ($q->processings as $proc => $value) { ?>
                            <option value="<?php echo $value?>" <?php if ($i == $q->unpackopts) { echo 'selected'; } $i++;?>><?php echo __($proc)?></option>
                        <?php } ?>
                    </select>
                </form>
            </td>
            <td>
                <form>
                    <select>
                        <?php foreach ($q->prioritys as $priority => $value) { ?>
                            <option value="<?php echo $value?>" <?php if ($priority == $q->priority) echo 'selected'?>><?php echo __($priority)?></option>
                        <?php } ?>
                    </select>
                </form>
            </td>
            <td>
                <form>
                    <select>
                        <?php foreach ($q->prepScripts as $script => $value) { ?>
                            <option value="<?php echo $value?>" <?php if ($script == $q->script) echo 'selected'?>><?php echo __($script)?></option>
                        <?php } ?>
                    </select>
                </form>
            </td>
            <td><?php if (is_array($q->filename)) { ?>
                    <a href="<?php echo $q->filename['url']?>"><?php echo $q->filename['title']?></a>
                <?php } else { ?>
                    <a href="#"><?php echo $q->filename?></a>
                <?php } ?>
            </td>
            <td><?php echo $q->sizeleft . '/' . $q->size?></td>
            <td><?php echo __($q->eta)?></td>
            <td><?php echo $q->avg_age?></td>
            </tr>
        <?php foreach ($q->prepFiles as $file) { ?>
            <tr class="<?php echo $q->nzo_id?>" style="display: none;">
                <td><?php echo $file->id?></td>
                <td><?php //echo $file->nzf_id?></td>
                <td></td>
                <td></td>
                <td><?php echo __($file->status)?></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $file->filename?></td>
                <td><?php echo $file->mbleft . '/' . $file->mb?></td>
                <td></td>
                <td><?php echo $file->age?></td>
            </tr>
            <?php }
        } ?>
</table>
<hr />
<ul>
    <li>SABnzbd version: <a href="<?php echo URL::site('queue/index')?>"><?php echo $version?></a></li>
    <li>Kvar att ladda ner: <a href="<?php echo URL::site('queue/index')?>"><?php echo $sizeleft?></a></li>
    <li>Hastighet: <a href="<?php echo URL::site('queue/index')?>" id="speed"><?php echo $speed?></a></li>
    <li>Tämporär disk: <a href="<?php echo URL::site('queue/index')?>" id="temp_disk"><?php echo $tempDisk?></a></li>
    <li>Färdig disk: <a href="<?php echo URL::site('queue/index')?>" id="comp_disk"><?php echo $compDisk?></a></li>
    <li>Tid kvar: <a href="<?php echo URL::site('queue/index')?>" id="time-left"><?php echo $timeleft?></a></li>
    <li>Beräknad till: <a href="<?php echo URL::site('queue/index')?>" id="eta"><?php echo $eta?></a></li>
    <?php if ($warnings) { ?>
        <li>Antal varningar: <strong><?php echo $warnings?></strong></li>
        <li>Senaste varningen: <strong><?php echo $lastWarning?></strong></li>
    <?php } ?>
</ul>


<script type="text/javascript">
$("div.progress-container.total").progress(<?php echo $totalPercent?>);
</script>

