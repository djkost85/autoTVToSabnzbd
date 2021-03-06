(function($){
    $.fn.tooltip = function(options) {

        var
        defaults = {
            selector: "#tooltip",
            rounded: false
        },
        settings = $.extend({}, defaults, options);

        $('<div id="'+settings.selector.substr(1, settings.selector.length-1)+'" />').appendTo('body').hide();

        this.each(function() {
            var 
            element = $(this),
            url = element.attr('rel'); 

            if(element.is('a') && element.attr('rel') != '') {
                element.attr('rel', '');
                element.hover(function(e) {
                    // mouse over
                    //alert(url);
                    var offset = element.offset();
                    var top = offset.top - 136;
                    $.get(url, function (data) {
                        $(settings.selector).addClass('ready').html(data);
                        /*var windowTop = $(window).scrollTop();
                        var windowHeight = $(window).height();
                        if (windowHeight <= ($(settings.selector).height() + top) - windowTop) {
                            top = top - ($(settings.selector).height() / 2);
                            $(settings.selector).css({ top: top });
                        }*/
                    });

                    $(settings.selector)
                    /*.css({
                        top: top,
                        left: offset.left + 205
                    })
                    .fadeIn(300)*/
                    .show();

                    if(settings.rounded) {
                        $(settings.selector).addClass('rounded');
                    }
                }, function() {
                    // mouse out
                    $(settings.selector).removeClass('ready').html('').hide();
                }).mousemove(function(event){
                    $(settings.selector).css({left: event.pageX+15, top: event.pageY+15});
		});
            }
        });
        // returns the jQuery object to allow for chainability.
        return this;
    }
})(jQuery);

