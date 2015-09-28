function addToCartAnimate(what, where){
    var position = $(what).offset();
    var dest = $(where).offset();
    var element = $(what).clone(false); 
    element.find('a').unbind().attr('id', null);
    element.attr('id', null);
    element.css({position:'absolute', top: position.top, left: position.left, zIndex: '102'}).appendTo('body');
    element.animate({top:dest.top, height: 30, left:dest.left+$(where).width()-element.width()-10, opacity:0.5}, {complete: function(){
        element.fadeOut('slow', function(){element.remove()});
    }});
    //$('#cartDiv>div').html('...');
}

function changeOrder(script, changeData, updateContent, callback, beforeCallback) {
    //block();
//    console.debug(script);
//    console.debug(changeData);
//    console.debug(updateContent);

    jQuery.ajax({
        url: script,
        data: changeData,
        dataType: 'json',
        type: "POST",
        success: function(json) {
            //unblock();
            //console.debug(json);
            if (typeof(beforeCallback) == 'function') {
                beforeCallback();
            }
            if (json == null) {
                return false;
            }
            if (json.content != null) {
                updateContent.html(json.content);
            }
            if (json.items != null) {
                if (updateContent != null) {
                    updateContent.html(json.items);
                }
            }
            if (json.modyfications != null) {
                if (updateContent != null) {
                    $('#order-modyfications').html(json.modyfications);
                }
            }
            if (typeof(callback) == 'function') {
                callback();
            }
        },
        error: function(x,index, y){
            //unblock(); 
        }
    });
}
