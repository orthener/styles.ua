<?php
class Comment extends AppModel {
	var $name = 'Comment';
	var $displayField = 'desc';
	var $actsAs = array(
        'Recaptcha.Captcha'
    );
    //var $translateModel = 'Page';
	
	var $validate = array(
		'desc' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Wprowadź treść',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Podpisz się, aby wysłać komentarz',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'recaptcha' => array(
            'recaptcha'=>array(
                'rule'=>'RecaptchaValidate',
                'message' => 'Błednie podane dane z formularza przepisz poprawnie tekst z obrazka',
                //'required' => true,
            )
        )
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Page' => array(
			'className' => 'Page.Page',
			'foreignKey' => 'page_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
}
?>