
//(function($){
//    $.fn.extend({
//        sabProgress: function(value, options) {
//            var defaults = {
//                selectorDone: ".progress .done",
//                selectorRemain: ".progress .remain",
//                                text: false
//            };
//
//            var settings = $.extend({}, defaults, options);
//
//            value = (value <= 100) ? value : 100;
//
//            var left = 100 - value;
//
//            return this.each(function() {
//                var element = $(this);
//                var text = value + "%";
//                if (settings.text) {
//                    text = settings.text;
//                }
//                element.find(settings.selectorDone).css({ width: value + "%" }).text(text);
//                element.find(settings.selectorRemain).css({ width: left + "%" });
//
//            });
//        }
//    });
//})(jQuery);

(function($){
    $.fn.extend({
        progress: function(value, options) {
            var defaults = {
                selectorValue: "div",
                text: false
            };

            var settings = $.extend({}, defaults, options);

            value = (value <= 100) ? value : 100;

            var left = 100 - value;

            return this.each(function() {
                var element = $(this);
                var text = value + "%";
                if (settings.text) {
                    text = settings.text;
                }
                element.find(settings.selectorValue).css({ width: value + "%" }).find('span').text(text);

            });
        }
    });
})(jQuery);


jQuery(document).ready(function($) {
    $('select').change(function () {
        var url = $(this).val()
        $.get(url, function () {
            window.location = ajaxUrl + 'queue/index';
        });
    });
    $('.sab').click(function () {
        var url = $(this).attr('href');
        $.get(url, function () {
            window.location = ajaxUrl + 'queue/index';
        });
        return false;
    });
    $('.files').click(function () {
        var element = $(this);
        var id = element.attr('id');

        if (element.hasClass('hide')) {
            $('.' + id).hide();
            element.removeClass('hide');
            element.text('+');
        } else {
            $('.' + id).show();
            element.addClass('hide');
            element.text('-');
        }
        return false;
    });

    var refreshBar = setInterval(function() {
        $.getJSON(ajaxUrl + 'queue/getProcent', function (data) {
            $("#total-percentage").text(data.total_text);
            $("div.progress-container.total").progress(data.total_percent);
            $('#speed').text(data.speed);
            $('#temp_disk').text(data.temp_disk);
            $('#comp_disk').text(data.comp_disk);
            $('#time_left').text(data.time_left);
            $('#eta').text(data.eta);
        });
    }, 2000);

    
});