<?php
App::uses('AppController', 'Controller');


/*
 * Kontroler obsługuje konwersję ceny z złotych na hrywny wg. wzoru
 * (PLN + Calculator.PlnFixed) * Calculator.ExchangeRate * Calculator.GrnRate + Calculator.FinalConstant
 * gdzie:
 * Calculator.PlnFixed      - jakaś stała 
 * Calculator.ExchangeRate  - kurs GRN/PLN
 * Calculator.GrnRate       - jakaś stała
 * Calculator.FinalConstant - jakaś stała
 */

class CalculatorsController extends AppController {
    public $layout = 'default';
    public $helpers = array('Form', 'Html');
    public $components = array();
    
    
    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('index', 'ajax_pln2grn'));
    }
    
    public function index() {
        $this->loadModel('Page.Page');
        $this->set('page', $this->Page->findById(28));
    }
    
    /**
     * Funkcja przelicza cenę w PLN na cenę w GRN
     */
    public function ajax_pln2grn() {
        $layout = 'default';
        if(!empty($this->request->data)) {
            $pln_price = $this->request->data['pln_price'];
            $exchangeRate = Configure::read('Calculator.ExchangeRate');
            $plnFixed = Configure::read('Calculator.PlnFixed');
            $grnRate = Configure::read('Calculator.GrnRate');
//            $finalConstant = Configure::read('Calculator.FinalConstant');
            
            $grn_price = ($pln_price + $plnFixed) * $exchangeRate * $grnRate;
            
            $this->set('grn_price', $grn_price);
            $this->set('_serialize', array('grn_price'));
        }        
        $this->render(false);
    }
}
?>
