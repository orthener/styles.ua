<?php
echo $this->Html->script('Eurocookie.cookie');
echo $this->Html->css('Eurocookie.eurocookie');
?>
<script type="text/javascript">
    document.write('<div id="eurociastko"></div>');
    jQuery(document).ready(function($) {
        var eurociastko = $.cookie("cookie-zgoda");
        if (eurociastko == null) {

            $("div#eurociastko").html('<div class="inner"><a class="close" href="#">ЗАКРЫТЬ</a><p>Уважаемые посетители, наш сайт использует файлы cookie, чтобы постоянно улучшать качество предоставляемых услуг. Вы можете разрешить/запретить их передачу, управляя настройками cookie в Вашем браузере.</p></div>').slideDown(1500);
            $("div#eurociastko a.close").click(function() {
                $(this).parent().parent().slideUp(1000, function() {
                    $.cookie("cookie-zgoda", 1, {
                        expires: 365
                    });
                    $(this).remove();
                });
                return false;
            });
            $(".openCookieInfo").bind('click', function() {
                $("div#eurociastko").slideUp(1000, function() {
                    $.cookie("cookie-zgoda", 1, {
                        expires: 365
                    });
                    $(this).remove();
                });
            });
        }
    });
</script>

<?php $this->Fancybox->init('$(".openCookieInfo")', array('type'=>'ajax'), true); ?>
