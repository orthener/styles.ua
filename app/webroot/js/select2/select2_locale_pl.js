/**
 * Select2 <Language> translation.
 * 
 * Author: Piotr Dutko <p.dutko@webdudi.pl>
 */
(function ($) {
    "use strict";

    $.extend($.fn.select2.defaults, {
        formatNoMatches: function () { return "Niczego nie znaleziono"; },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Proszê podaæ " + n + " znaków wiêcej" + (n == 1 ? "" : "s"); },
        formatInputTooLong: function (input, max) { var n = input.length - max; return "Proszê podaæ " + n + " znaków mniej" + (n == 1? "" : "s"); },
        formatSelectionTooBig: function (limit) { return "Mo¿na zaznaczyæ tylko " + limit + " elementów" + (limit == 1 ? "" : "s"); },
        formatLoadMore: function (pageNumber) { return "£adowanie wiêcej wyników..."; },
        formatSearching: function () { return "Wyszukiwanie..."; }
    });
})(jQuery);
