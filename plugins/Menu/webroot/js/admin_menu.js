    treeOptionClick();
    function treeOptionClick(){
        jQuery('#MenuOption0').click(function () {
         treeOptionChanged('0');
        });
        jQuery('#MenuOption1').click(function () {
         treeOptionChanged('1');
        });
        jQuery('#MenuOption2').click(function () {
         treeOptionChanged('2');
        });
        jQuery('#MenuOption0,#MenuOption1,#MenuOption2').blur(treeOptionChanged);
        treeOptionChanged();
    }
    
    function treeOptionChanged(default_value){
        if(typeof(default_value) != 'string'){
            var value = jQuery('#MenuOption1:checked, #MenuOption0:checked, #MenuOption2:checked').val();
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
    
