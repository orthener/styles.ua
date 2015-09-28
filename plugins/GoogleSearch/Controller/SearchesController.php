<?php
class SearchesController extends AppController {
    var $name = 'Searches';
    var $uses = null;
    
    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    function index(){
        
    }
    
}
?>