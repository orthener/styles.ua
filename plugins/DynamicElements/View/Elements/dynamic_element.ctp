<?php 

    //use example:
    /* 
    
    echo $this->element('dynamic_element', array(
        'plugin' => 'dynamic_elements',
//        'cache' => array('key' => 'element-id', 'time' => '+2 days'),
        'element_id' => 'element-id'
    ));
    
    */
?>
<?php 
    $element = $this->requestAction(array('plugin' => 'dynamic_elements', 'controller' => 'dynamic_elements', 'action' => 'view', $slug));

if(!isset($truncate)) $truncate = 0;
    
    echo ($truncate) ? $this->Text->truncate($element['DynamicElement']['content'], $truncate, array('html'=>true)) : $element['DynamicElement']['content'];
?>


