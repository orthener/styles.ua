var autocompleteCache = {};
var initAutocomplete = function(object, params) {
    if (params.model == null) {
        params.model = 'none'
    }
    if (params.displayField == null) {
        params.displayField = 'name';
    }
                
    var autocomplete_competition_options = {
        minLength: 1,
        autoFocus: true,
        delay: 0,
        source: function( request, response ) {
            data = {
                'data': {
                    'fraz': request.term,
                    'fields': params.fields
                }
            };
            $.ajax({
                url: params.url,
                dataType: "json",
                type: 'POST',
                data: data,
                success: function(data) {
                    if (typeof(params.callback) == 'function') {
                        params.callback(data);
                    }
                    response(
                        $.map( data, function( item, v ) {
                            autocompleteCache[params.model][item[params.model]['id']] = item[params.model][params.displayField];
                            return {
                                label: item[params.model][params.displayField],
                                data: item
                            };
                        })
                    );                       
                }
            });
        },
        select: function(event, item) {
            if (typeof(params.select) == 'function') {
                params.select(event, item);
            }
        }
    };
        
    if (typeof(object) == 'object') {
        return object.autocomplete(autocomplete_competition_options);
    } else {
        return $(object).autocomplete(autocomplete_competition_options);
    }
}

var setChangeInput = function(object, model, name) {
    if (typeof(object) == 'object') { 
        object.parent('div').find('input[type=text]').css('border', ''); 
        object.parent('div').find('input[type=hidden]').attr('value', ''); 
        object.parent('div').removeClass('autocomplete-error'); 
    } else {
        $(object).parent('div').find('input[type=text]').css('border', ''); 
        $(object).parent('div').find('input[type=hidden]').attr('value', ''); 
        $(object).parent('div').removeClass('autocomplete-error'); 
    }
        
    var id = getChangedId(model, name);
    if (id != '') {
        if (typeof(object) == 'object') {
            object.attr('value', id);
            object.parent('div').find('input[type=text]').css('border', '2px solid green');
            object.parent('div').removeClass('autocomplete-error'); 
        } else {
            $(object).attr('value', id);
            $(object).parent('div').find('input[type=text]').css('border', '2px solid green');
            $(object).parent('div').removeClass('autocomplete-error'); 
        }
    } else {
        if (typeof(object) == 'object') { 
            if (object.parent('div').find('input[type=text]').val()) {            
                object.parent('div').find('input[type=text]').css('border', '2px solid red'); 
                object.parent('div').addClass('autocomplete-error'); 
            }  
        } else {
            if ($(object).parent('div').find('input[type=text]').val()) {            
                $(object).parent('div').find('input[type=text]').css('border', '2px solid red'); 
                $(object).parent('div').addClass('autocomplete-error'); 
            }  
        }
    }
    

    return false;
};

var getChangedId = function(model, value) {
    var ret = '';
    $.each(autocompleteCache[model], function(id, name){
        if (''+name == ''+value) {
            ret = id;
        }
    });
    return ret;
}