<?php
App::uses('AppModel', 'Model');
/**
 * Customer Model
 *
 * @property User $User
 * @property Address $Address
 * @property Address $Address
 * @property InvoiceIdentity $InvoiceIdentity
 * @property Order $Order
 */
class Customer extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array();
    var $tablePrefix = 'commerce_';
    
    
    public $validate = array(
			'email' => array(
                'email' => array(
                    'rule' => array('email'),
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
                'isUnique' => array(
                    'rule' => 'validateUniqueEmail',
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                )
			),
            'contact_person' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
		);
    
    
    /**
    * Display field
    *
    * @var string
    */
	public $displayField = 'contact_person';
    /**
    * Domyślne sortowanie
    *
    * @var string
    */
	public $order = 'Customer.created DESC';

	/**
 	* belongsTo associations
 	*
 	* @var array
 	*/
	public $belongsTo = array(
		'User' => array(
			'className' => 'User.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AddressDefault' => array(
			'className' => 'Commerce.Address',
			'foreignKey' => 'address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'InvoiceIdentityDefault' => array(
            'className' => 'Commerce.InvoiceIdentity',
            'foreignKey' => 'invoice_identity_id',
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
	public $hasMany = array(
		'Address' => array(
			'className' => 'Commerce.Address',
			'foreignKey' => 'customer_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'InvoiceIdentity' => array(
			'className' => 'Commerce.InvoiceIdentity',
			'foreignKey' => 'customer_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Order' => array(
			'className' => 'Commerce.Order',
			'foreignKey' => 'customer_id',
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
		$this->validate['email']['email']['message'] = __d('commerce', 'Podaj e-mail');
		$this->validate['email']['isUnique']['message'] = __d('commerce', 'Podany adres e-mail jest już zarejestrowany. Zaloguj się aby złozyć zamówienie na ten adres');
		$this->validate['contact_person']['notempty']['message'] = __d('cms', 'Podaj imię i nazwisko');
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
     *    
     * @desc Sprawdzenie, czy email jest unikalny
     */
    function validateUniqueEmail($value, $params) {

        $params = array(
            'recursive' => 0,
            'conditions' => array(
                'OR' => array(
                    array('Customer.email' => $value, 'Customer.user_id IS NOT NULL'),
                    'User.email' => $value
                )
                ));

        if (!empty($this->id) OR !empty($this->request->data['Customer']['id'])) {
            $params['conditions']['Customer.id <>'] = empty($this->id) ? $this->request->data['Customer']['id'] : $this->id;
        }

        return (bool) !$this->find('count', $params);
    }

    function filterParams($data) {
        $params = array();
        if (!empty($data['Customer']['contact_person'])) {
            $params['conditions']['Customer.contact_person LIKE'] = $data['Customer']['contact_person'] . '%';
        }
        if (!empty($data['Customer']['email'])) {
            $params['conditions'][] = array(
                'OR' => array(
                    'Customer.email' => $data['Customer']['email'],
                    'User.email' => $data['Customer']['email']
                    ));
        }
        if (!empty($data['Customer']['name'])) {
            $params['conditions'][] = array(
                'OR' => array(
                    'AddressDefault.name LIKE' => $data['Customer']['name'] . '%',
                    'InvoiceIdentityDefault.name LIKE' => $data['Customer']['name'] . '%'
                    ));
        }
        if (!empty($data['Customer']['address'])) {
            $params['conditions'][] = array(
                'OR' => array(
                    'AddressDefault.address LIKE' => $data['Customer']['address'] . '%',
                    'InvoiceIdentityDefault.address LIKE' => $data['Customer']['address'] . '%'
                    ));
        }
        if (!empty($data['Customer']['post_code'])) {
            $params['conditions'][] = array(
                'OR' => array(
                    'AddressDefault.post_code LIKE' => $data['Customer']['post_code'] . '%',
                    'InvoiceIdentityDefault.post_code LIKE' => $data['Customer']['post_code'] . '%'
                    ));
        }
        if (!empty($data['Customer']['city'])) {
            $params['conditions'][] = array(
                'OR' => array(
                    'AddressDefault.city LIKE' => $data['Customer']['city'] . '%',
                    'InvoiceIdentityDefault.city LIKE' => $data['Customer']['city'] . '%'
                    ));
        }
        if (!empty($data['Customer']['region_id'])) {
            $params['conditions'][] = array(
                'OR' => array(
                    'AddressDefault.region_id' => $data['Customer']['region_id'],
                    'InvoiceIdentityDefault.region_id' => $data['Customer']['region_id']
                    ));
        }
        
        return $params;
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
//        $params['conditions']['OR']["Customer.contact_person LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

