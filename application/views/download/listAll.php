<?php defined('SYSPATH') or die('No direct script access.');
//var_dump($history);
?>

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
    background: #eee;
    color: #000;
}

table tr:hover {
    background-color: #171C1D;
}

</style>

<table>
    <tr>
        <th><?php echo __('Ready')?></th>
        <th><?php echo __('Name')?></th>
        <th><?php echo __('Size')?></th>
        <th><?php echo __('Status')?></th>
    </tr>
    <?php foreach ($history->slots as $slot) { ?>
    <tr>
        <td><?php echo date('d/m -Y H:i:s', $slot->completed)?></td>
        <td><?php echo ($slot->fail_message == "") ? $slot->name : strip_tags($slot->fail_message)?></td>
        <td><?php echo $slot->size?></td>
        <td><?php echo __($slot->status)?></td>
    </tr>
    <?php } ?>
</table>
