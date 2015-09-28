<?php
App::uses('AppModel', 'Model');
/**
 * InvoiceIdentity Model
 *
 * @property Customer $Customer
 * @property Region $Region
 * @property Country $Country
 * @property Customer $Customer
 */
class InvoiceIdentity extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array();
    var $tablePrefix = 'commerce_';
    /**
    * Display field
    *
    * @var string
    */
	public $displayField = 'name';
    
	public $validate = array(
			'iscompany' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
            'name' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'address' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'city' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'post_code' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'nip' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),  
            )
		);
    
    
    /**
    * Domyślne sortowanie
    *
    * @var string
    */
//	public $order = 'InvoiceIdentity.created DESC';

	/**
 	* belongsTo associations
 	*
 	* @var array
 	*/
	public $belongsTo = array(
		'Customer' => array(
			'className' => 'Commerce.Customer',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Region' => array(
			'className' => 'Region.Region',
			'foreignKey' => 'region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Country' => array(
			'className' => 'Country.Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    
	/**
 	* hasMany associations
 	*
 	* @var array
 	*/
	public $hasOne = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'invoice_identity_id',
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
		$this->validate['iscompany']['boolean']['message'] = __d('cms', 'Podaj rodzaj zakupów');
		$this->validate['name']['notempty']['message'] = __d('cms', 'Podaj imię nazwisko lub nazwę');
		$this->validate['address']['notempty']['message'] = __d('cms', 'Podaj ulicę');
		$this->validate['city']['notempty']['message'] = __d('cms', 'Podaj miejscowość');
		$this->validate['post_code']['notempty']['message'] = __d('cms', 'Podaj kod pocztowy');
		$this->validate['nip']['notempty']['message'] = __d('cms', 'Podaj NIP');
        
        if (empty($this->data['InvoiceIdentityDefault']['iscompany'])) {
            unset($this->validate['nip']);
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
     * Checks social security numbers (NIP) for Poland
     *
     * @param string $check Value to check
     * @return boolean
     * @access public
     * @link http://pl.wikipedia.org/wiki/NIP
     */
    //zmieniłem nazwę funkcji na lepiej rozpoznawalną w polsce
    function nip($check) {
        //modyfikacja potrzebna do dzialania w 1.2.x
        $value = array_values($check);
        $value = $value[0];
        //modyfikacja potrzebna do dzialania w 1.2.x
        $pattern = '/^([0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2})|([0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{3})|([0-9]{10})$/';
        if (!preg_match($pattern, $check)) {
            return false;
        }

        $sum = 0;
        $weights = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
        $check = str_replace('-', '', $check);

        for ($i = 0; $i < 9; $i++) {
            $sum += $check[$i] * $weights[$i];
        }

        $control = $sum % 11;
        if ($control == 10) {
            $control = 0;
        }

        if ($check[9] == $control) {
            return true;
        }
        return false;
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
//        $params['conditions']['OR']["InvoiceIdentity.name LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

