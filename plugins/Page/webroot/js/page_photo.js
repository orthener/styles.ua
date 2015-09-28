var sortableOptions = {'handle':'img','update':reorderImages};

/* Inicjalizacja */
$(document).ready(function() {
    makeEditable();
    var hiddenForm = $("#hiddenForm");
        var n = 'forphoto' + Math.floor(Math.random() * 99999);
        //nadanie identyfikatora formularzowi
        $(hiddenForm).attr('id', n);
    
        $('#galleryContainer').sortable(sortableOptions);
});

/* Uruchomienie edit-in-place w tabeli */
function makeEditable() {
    // Konfiguracja dla pol typu input
//     $(".editable").editable("/galleries/save_name", { 
//         indicator : "<img src='/img/loading.gif'>",
//         id        : 'data[Gallery][id]',
//         name      : 'data[Gallery][name]',
//         type      : 'text',
//         cancel    : 'Anuluj',
//         submit    : 'OK',
//         onblur    : 'ignore',        
//         tooltip   : 'Kliknij, aby edytować',
//         placeholder : 'brak',
//         callback  : function() {
//             showMsg('Nazwa została zapisana.');
//         },
//         cancelCallback  : function() { }
//     });

    $(".photoname_editable").editable(url+"/admin/page_photos/savename", {
        indicator : "<img src='"+url+"/img/cms/indicator.gif'>",
        id        : 'data[PagePhoto][id]',
        name      : 'data[PagePhoto][title]',
        type      : 'text',
        cancel    : 'Anuluj',
        submit    : 'OK',
        onblur    : 'ignore',        
        tooltip   : 'Kliknij, aby edytować',
        placeholder : 'Dodaj opis',
        callback  : function() {
            showMsg('Nazwa została zapisana.');
            setTimeout("placeholderUnderline();", 100);
        },
        cancelCallback  : function() { setTimeout("placeholderUnderline();", 100); }
    });

}

function placeholderUnderline(){
    var n = $('.photoname_editable').each(function(){
        if(this.innerHTML == "Dodaj opis"){
            this.style.textDecoration = 'underline';
        } else {
            this.style.textDecoration = 'none';
        }
    });
}


$(window).load(function() {
    placeholderUnderline();
    var n = $('.photoname_editable').click(placeholderUnderline);

    setTimeout("placeholderUnderline();", 100);
});






// Wyswietlenie komunikatu
showMsg = function(msg) {
    $('#ajaxMsg').html(msg).fadeIn('fast');
    setTimeout(function() { $('#ajaxMsg').fadeOut('normal'); },4000);
}

showGalleryMsg = function(msg, classname, time) {
    if(!time){
        time = 4000;
    }
    var n = 'galleryMsg' + Math.floor(Math.random() * 99999);
    $('#galleryMsg').clone(true).insertAfter("#galleryMsg").attr('id',n).html(msg).addClass(classname).fadeIn('fast');
    setTimeout(function() { $('#'+n).fadeOut('normal',function(){$('#'+n).remove();}); },time);
}

        var arg1, arg2;
        var i = 0;

        function beforePageStatusDiv(){
            $('#albumStatusDiv').block({
                message: "<img src='"+url+"/img/cms/indicator.gif'>",
                css: { 
                    border: '0px',
                    backgroundColor: 'transparent' 
                },
                overlayCss: {
                    opacity: '0.7'
                }
            });
        }

        function completePageStatusDiv(){
            if(typeof(json.message)=='undefined' || json.message==null){
            } else {
                showGalleryMsg(json.message,json.error,json.time);
            }
            $('#albumStatusDiv').unblock();
        }
  
        function before_setAsGalleryIcon(){
            $('#galleryContainer').block({
                message: "<img src='"+url+"/img/cms/indicator.gif'>", 
                css: { 
                    border: '0px',
                    backgroundColor: 'transparent' 
                },
                overlayCss: {
                    opacity: '0.7'
                }
            });
        }

//     var test1 = null;
//     var test2 = null;
// 
        function onComplete_setAsGalleryIcon(request, json){
//             test2 = json;
//             test1 = request;
            eval('json = ' + request.getResponseHeader('X-JSON'))

            if(typeof(json.mainImage)=='undefined' || json.mainImage==='error'){
                showGalleryMsg("Wystąpił błąd podczas próby aktualizacji zdjęcia głównego",'error');
            } else {
                var n = $('#galleryContainer a.setmainlink').length;
                for(var i=0;i<n;i++){
                    if($('#galleryContainer a.setmainlink')[i].id == 'setmain'+json.mainImage){
                        $('#galleryContainer a.setmainlink')[i].style.display = 'none';
                    } else {
                        $('#galleryContainer a.setmainlink')[i].style.display = 'block';
                    }
                }
                showGalleryMsg("Zmieniono zdjęcie główne galerii");
            }
            $('#galleryContainer').unblock();
        }
  
  
        //funkcja wykonywana przed wyslaniem formularza ze zdjeciem
        function startCallback(thisForm) {
            var pLoader = $("#photo_loader").clone(true).insertAfter("#photo_loader");
       		$(pLoader).attr('id', 'loader' + $(thisForm).attr('id'));
            return true;
        }

        function completeCallback(response, formId) {
            if(response.search("NOK")==-1){
                addedDivId = response.match(/id.+(photo_[0-9]+)/)[1];
                $('#loader' + formId).replaceWith(response);
                makeEditable();
                $('#'+addedDivId+' .loader').fadeOut('slow');
                $('#galleryContainer').sortable('destroy');
                $('#galleryContainer').sortable(sortableOptions);
                showGalleryMsg("Plik został poprawnie dołączony do galerii."); //" + $('#'+formId+' input[type=file]').val() + " 
                placeholderUnderline();
            } else {
                $('#loader' + formId).hide('fast',function(){$('#loader' + formId).remove();});
                showGalleryMsg("Błąd: " + response.substr(4),'error', 20000);
            }
            $('#'+formId+' input[type=file]').val('');
        }

        selectValue = function(obj) {
            obj.focus();
            obj.select();
        }

    function blockLinkDiv(){
        $('#linkdiv').block({
            message: "<img src='"+url+"/img/cms/indicator.gif'>",
            css: {border: '0px',backgroundColor: 'transparent'},
            overlayCss: {opacity: '0.5'}
        });
    }
    function reorderImages(e, ui){
        $('#galleryContainer').block({
            message: "<img src='"+url+"/img/cms/indicator.gif'>",
            css: {border: '0px',backgroundColor: 'transparent'},
            overlayCss: {opacity: '0.7'}
        });
        $.post(url+'/admin/page_photos/reorder/'+pageId, $('#galleryContainer').sortable("serialize", {'key':'data[photo][]', 'expression':".+_(.+)"} ),
            function(data, json){
                eval("data = "+ data);
                showGalleryMsg(data.message,data.errorcode,data.time);
                $('#galleryContainer').unblock();
            }
        );

    }

