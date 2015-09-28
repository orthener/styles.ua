var url;
var indexUrl;
var postUrl;

function initTree(){    
    
    //element drop gdy dodajemy sortujemy góra
    $( "ul li div.sortTop" ).droppable({
            hoverClass: 'droppable-hover',
            greedy: true,
            tolerance: 'pointer',
			drop: function( ev, ui ) {
    			var dropEl = $(this).parent('li:first');
    			//alert(inspect($(this).parent('li:first'),1,1));
                var dragEl = $(ui.draggable).parent('div.child').parent();
    			saveTree(dragEl, dropEl, 'before');
			}
		});
    //element drop gdy dodajemy sortujemy dół
    $( "ul li div.sortDown" ).droppable({
            hoverClass: 'droppable-hover',
            greedy: true,
            tolerance: 'pointer',
			drop: function( ev, ui ) {
    			var dropEl = $(this).parent('li:first');
                var dragEl = $(ui.draggable).parent('div.child').parent();
    			saveTree(dragEl, dropEl, 'after');
			}
		});
    //element drop gdy dodajemy do li
    $("ul li div.child").droppable({
        accept: ".ui-draggable",
        hoverClass: 'droppable-hover',
        greedy: true,
        tolerance: 'pointer',
        drop: function(ev, ui) {
            var dropEl = $(this).parent('li:first');
            var dragEl = $(ui.draggable).parent('div.child').parent();
            saveTree(dragEl, dropEl, '');
        }
    });

    setupDraggable();
    
    clickToggle();
    
    $( "#categories li span" ).draggable({helper: 'clone'});  
}

function clickToggle(){
    jQuery('.toggle').click(
        function(){
        thisUl = jQuery(this).next('ul:first');
        thisClick = jQuery(this);
        clickCssToggle(thisClick,thisUl);
        return false;
        }
    );
}
function clickCssToggle(thisClick,thisUl){
    if($(thisUl).css('display') == 'none'){
        $(thisUl).css('display', 'block');
        $(thisClick).html('&ndash;');
    }else{
        $(thisUl).css('display','none');
        $(thisClick).text('+');
    }
    
} 
var data0;
function saveTree(dragEl, dropEl, mode){
//    data0 = {drag: dragEl, drop: dropEl, mod: mode};
    // get category id
    var parent_id = dropEl.attr("id").substring(9);

    if (!isNaN(parent_id)) {
        var data = new Array();
        if(url == undefined){
            url = "categories/";
        }
        
        // see if we are adding or editing
        if (dragEl.length >0 && dragEl.attr("id").substring(0, 9) == "category_") {
            // get the current id
            var id = dragEl.attr("id").substring(9);
            urlPost = indexUrl.replace('/index/', '/update/');
        } else {
            var id = '';
            urlPost = indexUrl.replace('/index/', '/add/');
            data = jQuery('#treeElementAdd').serializeArray();
            data0 = data;
  
        }
        blockAll();
        data[data.length] = {name: 'data[id]', value :id};
        data[data.length] = {name: 'data[dest_id]', value :parent_id};
        data[data.length] = {name: 'data[mode]', value :mode};
        
        // post to our page to save our category
        $.post(urlPost, data, function() {
            $.get(url, function (data) { destroyDraggable(); 
            $("#tree").html(data); setupDraggable();
            unblockAll();
             });
        });
    
    }
}

function updateDragBox() {
    valInput = jQuery("#TreeName").val();
    draggable = jQuery(".ui-hidden");
    jQuery(draggable.find("span").get(0)).html(valInput);
    uiHidden();
    
}

function uiHidden(){
    valInput = jQuery("#TreeName").val();
    draggable = jQuery(".ui-hidden");
     if(valInput < 1){
        draggable.css('display','none');
    }else{
        draggable.css('display','block');
    }
}

function setupDraggable() {
    $("#ui-draggable span").draggable({
//    containment: '#categories',
    stop: function(e,ui) {
//        jQuery(".ui-hidden").css('display','none');
        $(this).css({ left: 0, top:0 });
    }
    });
    
    $("#category_0").find("li").draggable({
        containment: '#categories'
    });

}

function destroyDraggable() {
    $("#ui-draggable").draggable('destroy');
    $("#category_0").find("li").draggable('destroy');
}

function anulujValue() {
    jQuery('#TreeName').attr('value','');
    updateDragBox();
    return false;
};
function dodajNowaPozycje() {
    jQuery('.firstLiTree:first').css('display','block');
    jQuery('#dodajNowaPozycje').css('display','none');
    return false;
};
function blockAll(){
        jQuery.blockUI({ 
            css: {
                border: 'none', 
                padding: '15px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .5, 
                color: '#fff' 
            },
        message: 'Proszę czekać...'
        }); 

}
function unblockAll(){
    jQuery.unblockUI();
}