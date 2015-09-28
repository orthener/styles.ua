<?php
App::uses('AppModel', 'Model');

class Baner extends AppModel {
	var $name = 'Baner';
	var $displayField = 'name';
    
	var $actsAs = array('Image.Upload'=>array('maxFileSize'=>3145728));
    
    var $groupTypes = array(
        '1' => 'Strona główna - góra'
//        '450x255' => 'Głowna (zmieniający się) 450x255',
//        '231x282' => 'Podstrona 231x282'
    );
    
    var $hasMany = array(
		'BanerClick' => array(
			'className' => 'Baner.BanerClick',
			'foreignKey' => 'baner_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'BanerClick.created ASC',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'BanerShow' => array(
			'className' => 'Baner.BanerShow',
			'foreignKey' => 'baner_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'BanerShow.created ASC',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
    
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'clicks_counter' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'url' => array(
			'url' => array(
				'rule' => array('url'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'clicks_limit' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'shows_limit' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'published' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'group' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'image' => array(
            'mime'=>array('rule'=>array('validateMime','image'),
                'message'=>'Ten formularz akceptuje jedynie pliki graficzne (jpeg, gif, png)'),
            'upload'=>array('rule'=>'validateUpload')
        )
	);
    
    function beforeValidate() {
        //Logika zapisu        
        
        if (!empty($this->data['Baner']['banerType'])) {
            if ($this->data['Baner']['banerType']) {
                //0 - HTML
                //1 - IMG
                //2 - tinyMCE
                switch ($this->data['Baner']['banerType']) {
                    case 0:
                        $this->data['Baner']['image'] = null;
                        $this->data['Baner']['tiny'] = null;
                        //Odczepianie walidacji
                        unSet($this->validate['image']);
                        unSet($this->validate['tiny']);
                        break;
                    case 1:
                        unSet($this->data['Baner']['html_code']);// = null;
                        unSet($this->data['Baner']['tiny']);// = null;
                        break;
                    case 2:
                        unSet($this->data['Baner']['html_code']);// = null;
                        unSet($this->data['Baner']['image']);// = null;
                        break;
                }
            }
        }
        
        //Bez limitu
        if (!empty($this->data['Baner']['shows_limit_off']) && $this->data['Baner']['shows_limit_off']) {
            $this->data['Baner']['shows_limit'] = null;
        }  
        
        if (!empty($this->data['Baner']['clicks_limit_off']) && $this->data['Baner']['clicks_limit_off']) {
            $this->data['Baner']['clicks_limit'] = null;
        }  
        
        if (!empty($this->data['Baner']['date_limit_off']) && $this->data['Baner']['date_limit_off']) {
            $this->data['Baner']['date_limit'] = null;
        }
//        debug($this->data);
//        exit;
        return true;
    }
    
    function beforeSave($options = array()) {
        parent::beforeSave($options);
        if(empty($this->data['Baner']['publish_date'])){
            $this->data['Baner']['publish_date'] = date('Y-m-d H:i:s');
        }
        return true;
    }
    
    
//    function beforeSave($options = array()) {
//        parent::beforeSave($options);
//        debug($this->data);
//        exit;
//        return true;
//    }
    
}
