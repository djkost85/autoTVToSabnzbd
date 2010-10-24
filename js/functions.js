
//jQuery(document).ready(function($) {
//
//});

/**
  *
  * timer() provides a cleaner way to handle intervals
  *
  *     @usage
  * $.timer(interval, callback);
  *
  *
  * @example
  * $.timer(1, function (timer) {
  *     alert("hello");
  *     timer.stop();
  * });
  * @desc Show an alert box after 1 second and stop
  *
  * @example
  * var second = false;
  *     $.timer(1, function (timer) {
  *             if (!second) {
  *                     alert('First time!');
  *                     second = true;
  *                     timer.reset(3);
  *             }
  *             else {
  *                     alert('Second time');
  *                     timer.stop();
  *             }
  *     });
  * @desc Show an alert box after 1 second and show another after 3 seconds
  *
  *
  */
jQuery.timer = function (interval, callback)
 {

        var interval = interval || 100;

        interval = interval * 1000;

        if (!callback)
                return false;

        _timer = function (interval, callback) {
                this.stop = function () {
                        clearInterval(self.id);
                };

                this.internalCallback = function () {
                        callback(self);
                };

                this.reset = function (val) {
                        if (self.id)
                                clearInterval(self.id);

                        var value = val || 100;
                        value = value * 1000
                        this.id = setInterval(this.internalCallback, value);
                };

                this.interval = interval;
                this.id = setInterval(this.internalCallback, this.interval);

                var self = this;
        };

        return new _timer(interval, callback);
 };



//jQuery(document).ready(function($) {
//    $.timer(300, function (timer) {
//
//    });
//});



(function ($) {
    $(document).ready(function() {
        $(document).keypress(function (e) {
            $(".pagination a").filter(function() {
                if ($(this).text() == "Next") {
//                    alert($(this).attr("href"));
                }
            });

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

