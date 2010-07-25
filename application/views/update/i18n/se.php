<?php defined('SYSPATH') or die('No direct script access.');
?>

<style type="text/css">
div.update-wrapper {
    width: 748px;
    padding-top: 20px;
    margin-right: auto;
    margin-left: auto;
}
div.update-wrapper p {
    margin-top: 10px;
}
div.update-wrapper ul {
    margin-top: 5px;
    margin-left: 35px;
}
</style>
<div id="wrap">
<!-- content-wrap starts -->
<div id="content-wrap">
    <div id="googleHeader">
        Downloads from <a href="http://nzbmatrix.com/" title="NZBMatrix.com">NZBMatrix.com</a>
    </div>



    <form id="form-search" action="<?php echo URL::site('search/result')?>" method="get">
        <input class="input-text" name="q" type="text" />
        <input name="where" value="site" type="hidden" />
        <input class="input-button" name="search" value="" type="submit" />
    </form>

    <div id="main">
        <div class="inner">
            <!-- BuySellAds.com Zone Code -->
                    <div class="top-banner">
                        <?php echo HTML::anchor('#', HTML::image("images/black/banner/fringe.jpg", array('alt' => 'Top Banner')), array('title' => 'Top Banner', 'class' => 'adhere'));?>
                    </div>
                    <!-- END BuySellAds.com Zone Code -->
    <p>Alla avsnitt som blir uppdaterade och är markerade som nerladdade, kommer inte längre vara markerade som nedladdade.</p>
    <p>Klicka <a href="<?php echo URL::site('update/doAll')?>" id="update">här</a> om du vill updatera alla serier.</p>
    <p>Klicka <a href="<?php echo URL::site('rss/update')?>" id="update">här</a> om du vill updatera rss flödet.</p>
    <p>Denna åtgärd kan ta flera minuter.</p>
    <p>Om du vill använda dig av crontab (<a href="http://en.wikipedia.org/wiki/Cron">för linux</a>) eller schemalagda aktiviteter (för windows). 
        Kan du använda dessa länkar:</p>
    <ul>
        <li>Serier: "<?php echo URL::site('update/doAll', true)?>" (uppdatera en gång per vecka)</li>
        <li>RSS: "<?php echo URL::site('rss/update', true)?>" (uppdatera varannan timme)</li>
    </ul>
    <p><a href="#">Klicka här</a> om du vill generera filerna som behövs.</p>
    <div style="display: none">
        <form method="get" action="#">
            <p>
                <label class="noFloting" for="uri_to_php">The path to php.exe (usually: "C:\wamp\bin\php\php5.3.0\php.exe")</label>
                <input type="text" name="path_to_php" value="<?php echo $phpPath?>" size="45" />
            </p>
            <p>
                <input type="submit" name="rss" value="Generate RSS file" />
                <input type="submit" name="series" value="Generate Series file" />
            </p>
        </form>
        <p>Vissa webläsare sätter .htm eller liknande som filändelse. Du måste ta bort det för att det ska fungera</p>
    </div>
<div class="clearer"></div>
                    </div>
                    <!-- main ends -->
                </div>


<script type="text/javascript">
$('a[href="#"]').click(function () {
    $('div[style]').toggle();
})
//$('<img src="' + baseUrl + '/images/move-spinner.gif" id="spinner" />').css('position','absolute').hide().appendTo('body');
//$('#update').click(function () {
//    var position = $(this).offset();
//    $('#spinner').css({ top: position.top , left: position.left + $(this).width() + 30 }).fadeIn();
//    var url = $(this).attr('href');
//
//    $.ajax({
//        type: "GET",
//        url: url,
//        error: function (XMLHttpRequest, textStatus, errorThrown) {
//            $('#spinner').fadeOut();
//            alert(XMLHttpRequest.status);
//            alert(url);
//        },
//        success: function(data){
//            alert(data)
//            $('#spinner').fadeOut();
//            $('p:first-of-type').text(data);
//        }
//    });
//
////    $.get(url, function (data) {
////        alert(data)
////        $('#spinner').fadeOut();
////        $('p:first-of-type').text(data);
////    });
//    return false;
//});
</script>
