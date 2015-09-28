<?php
App::uses('AppModel', 'Model');
/**
 * ShipmentMethod Model
 *
 * @property ShipmentMethodConfig $ShipmentMethodConfig
 */
class ShipmentMethod extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array('Image.Upload', 'Modification.Modification');
    var $tablePrefix = 'commerce_';
    /**
    * Display field
    *
    * @var string
    */
	public $displayField = 'name';
    /**
    * Domyślne sortowanie
    *
    * @var string
    */
	public $order = 'ShipmentMethod.created DESC';

	/**
 	* hasMany associations
 	*
 	* @var array
 	*/
	public $hasMany = array(
		'ShipmentMethodConfig' => array(
			'className' => 'Commerce.ShipmentMethodConfig',
			'foreignKey' => 'shipment_method_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    /**
     * Callback wykonywany przed walidajcją
     * 
     * @param type $options 
     */
    public function beforeValidate($options = array()) {
		$this->validate = array(
			'name' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'img' => array(
				'mime' => array(
					'rule'=>array('validateMime','image'),
					'message' => 'Ten formularz akceptuje jedynie pliki graficzne (jpeg, gif, png)',
				),
				'upload' => array(
					'rule'=>array('validateUpload'),
				),
			),
		);
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
//        $params['conditions']['OR']["ShipmentMethod.name LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

