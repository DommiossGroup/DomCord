(function ($) {
    "use strict";

    function nice_Select() {
        if ($(".product_select").length) {
            $("select").niceSelect();
        };
    };

    nice_Select();

})(jQuery);
