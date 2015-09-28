/* 
 * Callback wykonywany przy załadowaniu strony w panelu administracyjnym
 */
$(function(){
    jQuery('#flashMessage').click(function(){
        jQuery(this).css('display', 'none');
    });
    $('.subNav').each(function(){
        var width = $(this).width();
        var obj = $(this).find('ul');
        var ulWidth = obj.width();
        if (ulWidth < width) {
            obj.css('width', width);
        }
    });
//    $('.tabs').tabs();
});

