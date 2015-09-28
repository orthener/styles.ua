jQuery(document).ready(function($) {
    var eurociastko = $.cookie("zgoda-cookie");
    if (eurociastko == null) {
        $("div#eurociastko").html('<div class="inner"><a class="close" href="#">X</a><p>Strona korzysta z plików cookies w celu realizacji usług i zgodnie z <a href="'+eurociastkolink+'"><strong>Polityką Plików Cookies</strong></a>. Możesz określić warunki przechowywania lub dostępu do plików cookies w Twojej przeglądarce.</p></div>').slideDown(1500);
        $("div#eurociastko a.close").click(function() {
            $(this).parent().parent().slideUp(1000, function() {
                $.cookie("cookie-zgoda", 1, {
                    expires: 365
                });
                $(this).remove();
            });
            return false;
        });
    }
});
