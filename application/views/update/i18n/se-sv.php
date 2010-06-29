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
    <p>Alla avsnitt som blir uppdaterade och är markerade som nerladdade, kommer inte längre vara markerade som nedladdade.</p>
    <p>Klicka <a href="<?php echo URL::site('update/doAll')?>" id="update">här</a> om du vill updatera alla serier.</p>
    <p>Denna åtgärd kan ta flera minuter.</p>
</div>


<script type="text/javascript">
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
