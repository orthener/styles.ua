<?php
/**
 * Filter form helper class
 *
 * Provides function to display filters form in index view
 * 
 */
class FilterHelper extends AppHelper {

/**
 * Other components utilized by PermissionsComponent
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html', 'Form');


    function formCreate($fields, $options = array('legend' => "Filtr", 'submit' => 'filtruj')){
        $output = '';
        $output .= $this->Form->create('Filter', array('url' => '/'.$this->params->url, 'class'=>'filter clearfix'));
        $output .='<fieldset class="clearfix">';
        $output .='<legend>'.$options['legend'].'</legend>';
        
        foreach($fields AS $key => &$field){
            $params = empty($field['form'])?array():$field['form'];
            $output .= $this->Form->input($key, $params);
            if(isset($params['class']) and strpos('onChange',$params['class'])>=0){
                $onChange = true;
            }
        }
        $output .='</fieldset>';
        $output .= $this->Form->submit($options['submit']);
        $output .= $this->Form->end();
        if(!empty($onChange)){
            $output .= $this->formCreateOnChange();
        }
        
        return $output;
    }
    
    function formCreateOnChange(){
        $output = '';
        $output .= $this->Html->scriptBlock('
			jQuery(".onChange").parents(".filter").find(".submit").css("display","none");
			jQuery(".onChange").change(function(){
				jQuery(this).parents(".filter").submit();
			});
		');
        return $output;
    }

}
?>