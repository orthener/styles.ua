/**
* FebMultiple - FebCMS
* 
* @author Sławomir Jach
* @version 1.0
*/
(function($){
    var methods = {
        _inArray: function(el, stack) {
            for(e in stack) {
                if (stack[e] == el) return true;
            }
            return false;
        },
        _complete: function(response) {
            var $this = $(this);
            var data = $this.data('febMultiple');
                
            if (typeof(response) == 'object') {
                data.dialog.html(response.responseText);
            } else {
                data.dialog.html(response);
            } 
        },
        //ustanowienie domyślych wartości
        add: function(id) {
            return this.each(function(){
                var $this = $(this);
                var data = $this.data('febMultiple');
                    
                if (!methods._inArray(id, data.register)) {
                    data.register.push(id);
                    $this.append($('<option selected="selected" value="'+id+'">'+id+'</option>'));   
                }
                $this.data('febMultiple', data);
            });
        },
        remove: function(id) {
            return this.each(function(){
                var $this = $(this);
                
                $this.find('option[value="'+id+'"]').remove();
                var data = $this.data('febMultiple');
                    
                for(i in data.register) {
                    if (id == data.register[i]) {
                        delete data.register[i];
                    }
                }
                $this.data('febMultiple', data);
            });
        },
        create: function(ids) {
            return this.each(function(){
                var $this = $(this);
                var data = $this.data('febMultiple');

                for (i in ids) {
                    methods.add.apply($this, [ids[i]]);
                }
                methods.createContent.apply($this, [false]);
            });
        },
            
        createContent: function() {
            return this.each(function(){
                var that = this;
                var $this = $(this);
                var data = $this.data('febMultiple');

                data.options.updateRegister.apply($this);

                $.ajax({
                    url: data.options.inlineEditUrl,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        ids: data.register
                        },
                    success: function(json) {
                        //Tworzę tabelkę
                        var content = $this.parent().parent().find('.feb-multiple-content');
                        if (content.length) {
                            content = content.html(json.index);
                        } else {
                            content = $('<div class="feb-multiple-content">'+json.index+'</div>');
                            $this.parent().before(content);
                            
                        }

                        //Zamykam okienko
                        if (data.dialog) {
                            $(data.dialog).dialog('close');
                        }
                        
                        data.options.afterAdd.apply(that, [content, json]);
                    }
                });
            });
        },
            
        init: function(options){
            return this.each(function(){
            
                var $this = $(this);
                var data = $this.data('febMultiple');

                var defaults = {
                    updateRegister: function() {},
                    afterAdd: function() {},
                    data: {
                        url: '/uzupenij_data_zrodla',
                        type: 'POST',
                        complete: function(response) {
                            return methods._complete.apply($this, [response] );
                        }
                    },
                    defaultHtml: 'Wybierz podobne produkty',
                    dialog: {
                        height: 440,
                        title: 'Dodaj podobne wybierz',
                        width: 800,
                        modal: true,
                        autoOpen: true,
                        buttons: {
                            Dodaj: function(){
                                return methods.createContent.apply($this);
                            },
                            Anuluj: function(){
                                $(this).dialog('close');
                            }
                        }
                    }
                }
                //Nie zainicjalizowany
                if (!data) {
                    options = $.extend(true, defaults, options);
                    var dialog = $('<div>Ładowanie...</div>');
                    
                    data = {
                        register: [],
                        options: options
                    };
                    $this.hide();
                        
                    var myButton = $('<div>'+options.defaultHtml+'</div>');
                    $this.parent().append(myButton);
                        
                    myButton.button({
                        create: function() {
                            $(this).click(function(e) {
                                data.dialog = dialog.dialog(options.dialog);
                                dialog.dialog('open');
                                $.ajax(options.data);
                                e.preventDefault();
                            });
                        }
                    });
                        
                    $this.data('febMultiple', data);
                        
                }
            });
        }
    }
        
    $.fn.febMultiple = function(method) {
        // Method calling logic
        if ( methods[method] ) {
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.febMultiple' );
        }
        return this;
    };
            
})(jQuery);