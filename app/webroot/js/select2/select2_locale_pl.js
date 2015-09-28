/**
 * Select2 <Language> translation.
 * 
 * Author: Piotr Dutko <p.dutko@webdudi.pl>
 */
(function ($) {
    "use strict";

    $.extend($.fn.select2.defaults, {
        formatNoMatches: function () { return "Niczego nie znaleziono"; },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Prosz� poda� " + n + " znak�w wi�cej" + (n == 1 ? "" : "s"); },
        formatInputTooLong: function (input, max) { var n = input.length - max; return "Prosz� poda� " + n + " znak�w mniej" + (n == 1? "" : "s"); },
        formatSelectionTooBig: function (limit) { return "Mo�na zaznaczy� tylko " + limit + " element�w" + (limit == 1 ? "" : "s"); },
        formatLoadMore: function (pageNumber) { return "�adowanie wi�cej wynik�w..."; },
        formatSearching: function () { return "Wyszukiwanie..."; }
    });
})(jQuery);
