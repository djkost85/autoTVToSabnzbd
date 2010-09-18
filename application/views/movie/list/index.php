<?php
defined('SYSPATH') or die('No direct script access.');
?>

<div class="top-banner">
    <?php echo HTML::anchor('', HTML::image("images/black/banner/fringe.jpg", array('alt' => 'Top Banner')), array('title' => 'Top Banner', 'class' => 'adhere'));?>
</div>

<?php if (empty($movies)) { ?>
    <h1 class="page-title"><?php echo __('No movies saved')?></h1>
<?php } else { ?>
    <!--<h1><?php echo $title; ?></h1>-->

    <p>
        <?php echo HTML::anchor('movie/list/index/?' . http_build_query(array('orderby_rating' => (isset($_GET['orderby_rating']) && $_GET['orderby_rating'] == 'desc') ? 'asc':'desc')), __('Order by rating')) ?>
        |
        <?php echo HTML::anchor('movie/list/index/?' . http_build_query(array('orderby_name' => (isset($_GET['orderby_name']) && $_GET['orderby_name'] == 'desc') ? 'asc':'desc')), __('Order by name')) ?>
        |
        <?php echo HTML::anchor('movie/list/index/?' . http_build_query(array('orderby_released' => (isset($_GET['orderby_released']) && $_GET['orderby_released'] == 'desc') ? 'asc':'desc')), __('Order by release date')) ?>
    </p>
    <ul class="thumbnail">
        <?php foreach ($movies as $movie) {
            $file = "images/black/noPoster.gif";
            foreach (unserialize($movie->posters) as $poster) {
//                var_dump($poster->image);
                //original, mid, cover, thumb
                if ($poster->image->size == 'cover') {
                    $file = $poster->image->url;
                }
            }
            ?>

        <li>
            <?php echo HTML::anchor('movie/list/info/' . $movie->id, $movie->name)?>
            <?php echo HTML::image($file); ?>
            <span class="icon type matrix-cat" id="<?php echo $movie->id;?>" title="<?php echo NzbMatrix::cat2string($movie->matrix_cat)?>"></span>
            <span class="icon edit" title="<?php echo $edit?>"><?php echo HTML::anchor("movie/add/edit/$movie->id", $edit)?></span>
            <span class="icon download" title="<?php echo $download?>"><?php echo HTML::anchor("movie/download/movie/$movie->id", $download)?></span>
            <span class="icon date" title="<?php echo $released?>"><?php echo $released?>: <?php echo $movie->released?></span> <br />
            <span class="icon rating" title="<?php echo $rating?>"><?php echo $rating?>: <?php echo $movie->rating . '/' . $movie->votes?></span>
        </li>
        <?php } ?>
    </ul>
    <?php } ?>
    <?php echo $pagination; ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.matrix-cat').hover(function() {
        $(this).css('cursor','pointer');
    }, function() {
        $(this).css('cursor','auto');
    });


    $('<img src="' + baseUrl + '/images/move-spinner.gif" id="spinner" />').css('position','absolute').hide().appendTo('body');
    $('.matrix-cat').click(function (event) {
        var element = $(this);
        if (element.hasClass('doNoEdit')) {
            return this;
        }
    //    var oldText = jQuery.trim(element.text());
        var oldText = jQuery.trim(element.attr('title'));
        element.text('');
        element.addClass('doNoEdit');

        var select = $('<select name="edit" id="edit"></select>');
        select.append((oldText != 'Movies > ALL') ? $('<option value="movies-all">Movies: ALL</option>') : $('<option value="movies-all" selected>Movies: ALL</option>'));
        select.append((oldText != 'Movies > DVD') ? $('<option value="1">Movies: DVD</option>') : $('<option value="1" selected>Movies: DVD</option>'));
        select.append((oldText != 'Movies > Divx/Xvid') ? $('<option value="2">Movies: Divx/Xvid</option>') : $('<option value="2" selected>Movies: Divx/Xvid</option>'));
        select.append((oldText != 'Movies > BRRip') ? $('<option value="54">Movies: BRRip</option>') : $('<option value="54" selected>Movies: BRRip</option>'));
        select.append((oldText != 'Movies > HD (x264)') ? $('<option value="42">Movies: HD (x264)</option>') : $('<option value="42" selected>Movies: HD (x264)</option>'));
        select.append((oldText != 'Movies > HD (Image)') ? $('<option value="50">Movies: HD (Image)</option>') : $('<option value="50" selected>Movies: HD (Image)</option>'));
        select.append((oldText != 'Movies > WMV-HD') ? $('<option value="48">Movies: WMV-HD</option>') : $('<option value="48" selected>Movies: WMV-HD</option>'));
        select.append((oldText != 'Movies > SVCD/VCD') ? $('<option value="3">Movies: SVCD/VCD</option>') : $('<option value="3" selected>Movies: SVCD/VCD</option>'));
        select.append((oldText != 'Movies > Other') ? $('<option value="4">Movies: Other</option>') : $('<option value="4" selected>Movies: Other</option>'));

        var form = $('<form id="form_'+event.target.tagName+'" action="#" method="get"></form>')
        form.append(select);

        var button = $('<input type="button" value="Ok" />').click(function () {
            var position = $(this).offset();
            $('#spinner').css({ top: position.top , left: position.left + $(this).width() + 30 }).fadeIn();
            var value = select.val();
            if (value == "select") return false;
            $.get(ajaxUrl + 'movie/add/setMatrix/' + element.attr('id'), { cat: value }, function(data) {
                $('#spinner').fadeOut();
                form.remove();
                element.removeClass('doNoEdit');
                element.attr('title', data);
            });
        });
        form.append(button);

        var cancel = $('<input type="button" value="Cancel" />').click(function () {
            form.remove();
//            element.removeClass('doNoEdit');
    //        element.text(oldText);
        });
        form.append(cancel);
        element.html(form);
        return this;
    });

});
</script>