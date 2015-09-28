<?php
/**
 * Wersja 1.0
 * Podstawowa funkcjonalność 
 * 
 */
class OrderComponent  extends Component {

	public $controller = null;
	
    public function startup(&$controller, $params = array()) {
        $this->controller = &$controller;
    }


    
    
}
?>