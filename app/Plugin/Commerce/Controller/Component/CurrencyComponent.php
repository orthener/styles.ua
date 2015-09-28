<?php

App::uses('Currency', 'Commerce.Vendor');

class CurrencyComponent extends Component {

    var $components = array('Session');
    var $controller = null;
    
    
    function initialize(\Controller $controller) {
        
        Currency::getInstance();
        
        $this->controller = &$controller;
        
        $params = array();
        $params['conditions'][] = 'CurrencyExchangeRate.deleted IS NULL';
        
        $this->controller->loadModel('Commerce.CurrencyExchangeRate');
        $this->controller->CurrencyExchangeRate->recursive = -1;
        $this->_currencies = $this->controller->CurrencyExchangeRate->find('all', $params);
        
        Currency::setCurrencies(Set::combine($this->_currencies, '{n}.CurrencyExchangeRate.currency', '{n}.CurrencyExchangeRate'));
        
    }

    function startup(\Controller $controller) {

    }
}

?>