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

<table class="paginated">
    <thead>
        <tr>
            <th></th>
            <th><?php echo __('Ready')?></th>
            <th><?php echo __('Name')?></th>
            <th><?php echo __('Size')?></th>
            <th><?php echo __('Status')?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($history->slots as $slot) { ?>
        <tr>
            <td><?php echo HTML::anchor($slot->deleteLink, HTML::image('images/black/bullet_delete.gif'), array('title' => __('Delete'), 'class' => 'sab'))?></td>
            <td><?php echo date('d/m -Y H:i:s', $slot->completed)?></td>
            <td><?php echo $slot->name . ' ' . strip_tags($slot->fail_message)?></td>
            <td><?php echo $slot->size?></td>
            <td><?php echo __($slot->status)?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.sab').click(function () {
        var url = $(this).attr('href');
        $.get(url, function () {
            window.location = baseUrl + 'download/listAll';
        });
        return false;
    });
});

  
$(document).ready(function() {

    /*$('table.paginated').each(function() {
        var currentPage = 0;
        var numPerPage = 20;

        var $table = $(this);

        $table.bind('repaginate', function() {
            $table.find('tbody tr').show()
            .slice(0,currentPage * numPerPage)
            .hide()
            .end()
            .slice((currentPage + 1) * numPerPage)
            .hide()
            .end();
        });

        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);

        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number">' + (page + 1) + '</span>')
            .bind('click', {'newPage': page}, function(event) {
                currentPage = event.data['newPage'];
                numPerPage = 20;
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            })
            .appendTo($pager).addClass('clickable');
        }
        $('<span class="view-all">View All</span>').bind('click', {'newPage':page}, function(event) {
            $(this).addClass('active').siblings().removeClass('active');
            currentPage = 0;
            numPerPage = numRows;
            $table.trigger('repaginate');
        }).appendTo($pager).addClass('clickable');
        $pager.find('span.page-number:first').addClass('active');
        $pager.insertBefore($table);

        $table.trigger('repaginate');

    });*/


});

</script>
