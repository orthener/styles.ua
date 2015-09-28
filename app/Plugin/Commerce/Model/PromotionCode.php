<?php
App::uses('AppModel', 'Model');
/**
 * PromotionCode Model
 *
 */
class PromotionCode extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array();
    
    public $tablePrefix = 'commerce_';
    
    /**
    * Display field
    *
    * @var string
    */
	public $displayField = 'code';
    /**
    * Domyślne sortowanie
    *
    * @var string
    */
	public $order = 'PromotionCode.created DESC';
    /**
     * Callback wykonywany przed walidajcją
     * 
     * @param type $options 
     */
    public function beforeValidate($options = array()) {
		$this->validate = array(
			'code' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				'unique' => array(
					'rule' => array('isUnique'),
					'message' => __d('cms', 'Podany kod już istnieje w bazie'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'value' => array(
				'numeric' => array(
					'rule' => array('range', 0, 100),
					'message' => __d('cms', 'Wartość rabatu musi mieścić się w zakresie 1%% - 99%%'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
//			'expiry_date' => array(
//				'date' => array(
//					'rule' => array('date'),
//					'message' => __d('cms', 'Pole formularza nie może być puste'),
//					//'allowEmpty' => false,
//					//'required' => false,
//					//'last' => false, // Stop validation after this rule
//					//'on' => 'create', // Limit validation to 'create' or 'update' operations
//				),
//			),
			'used' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'deleted' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
    }
    
    public function beforeSave($options = array()) {
//        parent::beforeSave($options);
        
        if(isSet($this->data[$this->alias]['expiry_date']) && empty($this->data[$this->alias]['expiry_date'])) {
            $this->data[$this->alias]['expiry_date'] = null;
        }
        
    }


    /**
     * Konstruktor klasy modelu
     * 
     * @param int $id
     * @param array $table
     * @param bool $ds 
     */
    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        //$this->virtualFields = array('fullname' => "CONCAT({$this->alias}.field_1, ' ', {$this->alias}.field_2)");
    }
    
    /**
     * Logika dla globalnej wyszukiwarki w cms
     * nadpisuje metodę z AppModel
     * 
     * @param array $options
     * @param array $params
     * @return type array
     */
//    public function search($options, $params = array()) {
//        $fraz = $options['Searcher']['fraz'];
//        $params['conditions']['OR']["PromotionCode.code LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

