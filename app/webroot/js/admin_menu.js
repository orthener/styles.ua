
    function treeOptionClick(){
        jQuery('#CategoryOption0').click(function () {
         treeOptionChanged('0');
        });
        jQuery('#CategoryOption1').click(function () {
         treeOptionChanged('1');
        });
        jQuery('#CategoryOption2').click(function () {
         treeOptionChanged('2');
        });
        jQuery('#CategoryOption0,#CategoryOption1,#CategoryOption2').blur(treeOptionChanged);
        treeOptionChanged();
    }
    
    function treeOptionChanged(default_value){
        if(typeof(default_value) != 'string'){
            var value = jQuery('#CategoryOption1:checked, #CategoryOption0:checked, #CategoryOption2:checked').val();
        } else {
            var value = default_value;
        }

        if(value == '2'){
            jQuery('.url-section').css('display' ,'none');
            jQuery('.model-section').css('display' ,'block');
        } else if(value == '1'){
            jQuery('.url-section').css('display' ,'block');
            jQuery('.model-section').css('display' ,'none');
        } else{
            jQuery('.url-section').css('display' ,'none');
            jQuery('.model-section').css('display' ,'none');
        }
    
    }
