<?php 
    if(empty($search_page)){ 
        echo $this->element('search_default', array('plugin'=>'search'));
    } else { 
        echo $this->element('search_form', array('plugin'=>'search')); 
    } 
?>