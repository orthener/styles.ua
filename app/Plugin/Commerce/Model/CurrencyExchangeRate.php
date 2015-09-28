<?php
class CurrencyExchangeRate extends AppModel {
    
	var $name = 'CurrencyExchangeRate';
    var $tablePrefix = 'commerce_';
    
	var $displayField = 'currency';
	var $validate = array(
		'currency' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'value' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Podaj wartość liczbową.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
    

}
?>