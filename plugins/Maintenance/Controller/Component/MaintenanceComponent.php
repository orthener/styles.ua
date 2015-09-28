<?php
/**
 * Maintenance Component blocks access to your site to all but allowed hosts, 
 * and show a default "site under maintenance" page 
 */
App::uses('Component', 'Controller'); 

class MaintenanceComponent extends Component {
    
    var $active = true;
    var $redirect = array('controller'=>'maintenance','action'=>'index','plugin'=>'maintenance','admin'=>false,'user'=>false);
    
    var $usePassword = true;
    var $accessPassword = 'kawa123'; 
    
    function beforeRender(){
        
    }

    function initialize() {
        $this->active = Configure::read('Maintenance.status');
        $this->accessPassword = Configure::read('Maintenance.password');
    }
 
    //called after Controller::beforeFilter()
    function startup(&$controller) {
        
        if(!empty($controller->params['requested'])){
            return;
        }

        //if the host is localhost stop processing
        if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            return;    
        } 
        
        //if we have already been redirected, stop processing
        if ($controller->here == Router::url($this->redirect)) {
            return;        
        }
       
       //quick fix for cake 1.2 prebeta
       //TODO change it so it loads the cookie component
       
       $cookieVal = @$_COOKIE['CakeCookie']['Maintenance']['allow'];
       
       if ($cookieVal == true) {
        
        return;       
       }
       //redirect if active
        if ($this->active) {
            $controller->redirect($this->redirect, 302);        
        }
         
    }    
}
?>
