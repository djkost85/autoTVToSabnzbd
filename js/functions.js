
jQuery(document).ready(function($) {


//    $('#result').hide();
//    $('#name').change(function() {
//        //$.post(basUrl + 'index.php/series/search', {name: $('#name').val()}, function(data){
//        $.post(basUrl + 'index.php/series/search', function(data){
//            $('#result').html(data);
//            $('#result').fadeIn();
//            //alert($('#name').val())
//        });
//        //alert($('#name').val())
//        //alert(basUrl + 'series/search')
//    });


    $('#ajaxTest').click(function () {
        $.get("http://dev/autoTvToSab/index.php/episodes/1", function(data){
           $('#result').html(data);
        });
        /*$.get("http://dev/autoTvToSab/index.php/episodes/1",
        function(data) {
            $('#result').html(data);
        });*/
        return false;
    });

    $('.series div.info').css('position', 'absolute').hide();
    $('.series').hover(
        function() {
            var position = $(this).offset();
            var top = position.top + $(this).height();
            var left = position.left;
            if (left > $(window).width() - $(this).find('div.info').width()) {
                left = $(window).width() - ($(this).find('div.info').width() + 30);
            }
            $(this).find('div.info').css({
                backgroundColor: '#ffffff',
                top: top,
                left: left
            }).fadeIn();
        },

        function () {
            $(this).find('div.info').hide();
        }
    );


    $('.ep li div').css('position', 'absolute').hide();
    $('.ep li').hover(
        function(e) {
            var position = $(this).position();
            
            $(this).find('div').css({
                backgroundColor: '#ffffff',
                top: position.top - 50,
                left: position.left
            }).show(); //fadeIn()
        },

        function () {
            $(this).find('div').hide();
        }
    );
    /*$('.series').click(function () {
        var div = $(this).find('div.info');
        if (div.hasClass('show')) {
            div.removeClass('show').hide();
        } else {
            div.addClass('show').fadeIn()
        }
        return false;
    });

    /*$('.series div').css('position','absolute').hide();
    $('.series').hover(
        function () {
            var position = $(this).offset();
            $(this).find('div').css({
                backgroundColor: '#ffffff',
                top: position.top ,
                left: position.left + $(this).width() + 2
            }).show();
        },
        function () {
            $(this).find('div').hide();
        }
    );*/

    /*$('<img src="' + basUrl + '/images/move-spinner.gif" id="spinner" />').css('position','absolute').hide().appendTo('body');
    
    $('#get-poster').click(function(e) {
        var position = $(this).offset();
        $('#spinner').css({ top: position.top , left: position.left + $(this).width() + 30 }).fadeIn();

        $.post(basUrl + '/getPoster', {
            name: $('#name').val()
        }, function(data) {
            $('#spinner').fadeOut();

            $('#posters').html(data);
            var imgList = $(".img-list");
            imgList.css({
                "opacity": 0.7
            });
            $('#poster-list').find('input').hide();
            imgList.hover(
                function () {
                    $(this).animate({
                        "opacity": 1
                    }, 100);
                },
                function () {
                    if (!$(this).find('input').attr('checked'))
                        $(this).animate({
                            "opacity": 0.7
                        }, 100);
                }
                );
            imgList.click(function () {
                imgList.css({
                    "opacity": 0.7
                }).find('input').removeAttr("checked");
                $(this).css({
                    "opacity": 1
                }).find('input').attr("checked", "checked");
            });
        });
        return false;
    });

    $('.info-list').css('position','absolute').hide();
    $('.tv-listings').hover(
        function() {
            var position = $(this).offset();
            $(this).find('.info-list').css({ top: position.top  + 40, left: position.left + 160 }).fadeIn()
        },

        function () {
            $(this).find('.info-list').hide();
        }
    );*/
    
    /*var refreshId = setInterval(function() {

        $.post(basUrl + '/update', { sabUpdate: "sab", time: "2pm" }, function (date) {
            $('#updateResult').text('Uppdaterade senast: ' + date);
        });
    }, 3600000);*/

    
});

//$(document).ready(function() {
//    var position = $('#updateResult').offset();
//    $('#spinner').css({ top: position.top , left: position.left + $('#updateResult').width() + 30 }).fadeIn();
//    $.post(basUrl + '/update', { sabUpdate: "sab", time: "2pm" }, function (date) {
//        $('#spinner').fadeOut();
//        //$('#updateResult').text('Uppdaterade senast: ' + date);
//        $('#updateResult').html('Uppdaterade senast: ' + date);
//    });
//});

/*$(function() {
    var $headline = $('h1:first');
    $(document).ajaxSend(function() {
        $headline
            .removeClass('activity')
            .addClass('activity');
    });
    $(document).ajaxStop(function() {
        $headline.removeClass('activity')
    });
});

$(document).ready(function() {
	//create image
	$('<img src="move-spinner.gif" id="spinner" />').css('position','absolute').hide().appendTo('body');
	//for every field change
	$('.ajax').change(function() {
		//get element position
		var position = $(this).offset();
		//position image
		$('#spinner').css({ top: position.top , left: position.left + $(this).width() + 30 }).fadeIn();
		//ajax
		$.post('',{
			ajax:1,
			value: $(this).val()
		},function() {
			$('#spinner').fadeOut();
		});
	});
});*/



(function ($) {
    $(document).ready(function() {
        $(document).keypress(function (e) {
            if (37 == e.keyCode && $("#previous").attr("href")) {
                window.location = $("#previous").attr("href");
            }
            if (39 == e.keyCode && $("#next").attr("href")) {
                window.location = $("#next").attr("href");
            }
//            if (38 == e.keyCode && $('#first').attr("href")) {
//                 window.location = $("#first").attr("href");
//            }
//            if (40 == e.keyCode && $('#last').attr("href")){
//                 window.location = $("#last").attr("href");
//            }
        });
    });
})(jQuery)

