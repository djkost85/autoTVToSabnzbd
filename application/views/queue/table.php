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
        <th><?php echo __('Year')?></th>
    </tr>
        <?php foreach($queue as $q) { ?>
        <tr>
            <td><a class="files" id="<?php echo $q->nzo_id?>" href="#">+</a></td>
            <td><a class="sab" href="<?php echo $q->deleteLink?>">Radera</a></td>
            <?php if (!$q->paused) { ?>
                <td><a class="sab" href="<?php echo $q->pauseLink?>">Paus</a></td>
            <?php } else { ?>
                <td><a class="sab" href="<?php echo $q->resumeLink?>">Fortsätt</a></td>
            <?php } ?>
            <td>
                <form>
                    <select>
                    <?php
                    $move = $q->getMove;
                    foreach($move() as $index => $value) { ?>
                        <option value="<?php echo $value?>" <?php if ($index == $q->index) echo 'selected'?>><?php echo $index?></option>
                    <?php } ?>
                    </select
                </form>
            </td>
            <td>
                <form>
                    <select>
                        <?php
                        $categories = $q->getCategories;
                        foreach ($categories() as $cat => $value) { ?>
                        <option value="<?php echo $value?>" <?php if ($cat == $q->cat) echo 'selected'?>><?php echo $cat?></option>
                        <?php } ?>
                    </select>
                </form>
            </td>
            <td>
                <form>
                    <select>
                        <?php $i = 0; foreach ($q->processings as $proc => $value) { ?>
                            <option value="<?php echo $value?>" <?php if ($i == $q->unpackopts) { echo 'selected'; } $i++;?>><?php echo $proc?></option>
                        <?php } ?>
                    </select>
                </form>
            </td>
            <td>
                <form>
                    <select>
                        <?php foreach ($q->prioritys as $priority => $value) { ?>
                            <option value="<?php echo $value?>" <?php if ($priority == $q->priority) echo 'selected'?>><?php echo $priority?></option>
                        <?php } ?>
                    </select>
                </form>
            </td>
            <td>
                <form>
                    <select>
                        <?php
                        $scripts = $q->getScripts;
                        foreach ($scripts() as $script => $value) { ?>
                            <option value="<?php echo $value?>" <?php if ($script == $q->script) echo 'selected'?>><?php echo $script?></option>
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
            <td><?php echo $q->eta?></td>
            <td><?php echo $q->avg_age?></td>
            </tr>
        <?php
            $getFiles = $q->getFiles;
            foreach ($getFiles() as $file) { ?>
            <tr class="<?php echo $q->nzo_id?>" style="display: none;">
                <td><?php echo $file->id?></td>
                <td><?php //echo $file->nzf_id?></td>
                <td></td>
                <td></td>
                <td><?php echo $file->status?></td>
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
    <li>Kvar att ladda ner:
        <a href="<?php echo URL::site('queue/index')?>" id="total-percentage">
            <dl class="progress">
                <dt>Completed:</dt>
                <dd class="done"></dd>

                <dt>Remaining:</dt>
                <dd class="remain"></dd>
            </dl>
        </a>
    </li>
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
$("#total-percentage").sabProgress(<?php echo $totalPercent?>, { text: '<?php echo $sizeleft?>' });
</script>