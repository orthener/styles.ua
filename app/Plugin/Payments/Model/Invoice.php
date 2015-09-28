<?php
App::uses('AppModel', 'Model');
/**
 * Invoice Model
 *
 */
class Invoice extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array();
    var $tablePrefix = 'payments_';
    
    /**
    * Display field
    *
    * @var string
    */
	public $displayField = 'seller';
    /**
    * Domyślne sortowanie
    *
    * @var string
    */
	public $order = 'Invoice.created DESC';
    
    
    public $jsonEncoded = array('seller', 'buyer', 'items', 'taxes', 'payments');
    
    public $numberPrefixCompany = 'FV';

    public $numberPrefixPerson = 'FA';

    public $numberSufix = '';
    
    public $numberPeriod = 'year'; //possible values: month, year
    /**
     * Callback wykonywany przed walidajcją
     * 
     * @param type $options 
     */
    public function beforeValidate($options = array()) {
		$this->validate = array(
			'number_prefix' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'number_int' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'number_period' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'number_sufix' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'number' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'sent' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'printed' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'emailed' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('cms', 'Pole formularza nie może być puste'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'done' => array(
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
    /**
     * Callback wykonywany przed zapisem danych
     * 
     * @param type $options 
     */
    function beforeSave($options = array()) {
        foreach($this->jsonEncoded AS $field){
            if (isset($this->request->data[$this->alias][$field]) AND is_array($this->request->data[$this->alias][$field])) {
                $this->request->data[$this->alias][$field] = json_encode($this->request->data[$this->alias][$field]);
            }
        }
        return true;
    }
    /**
     * Callback wykonywany przed wyszukaniem danych
     * 
     * @param type $options 
     */
    function afterFind($results, $primary = false) {

        //loop over all records that have been found
        foreach ($results as $key => $value) {
            if (is_array($value)) {
                //search for all fields that have been json_encoded
                foreach($this->jsonEncoded AS $field){
                    if (isset($value[$this->alias][$field])) {
                        //if found one, json_decode it
                        $tmp = json_decode($value[$this->alias][$field], true);
                        if (is_array($tmp)) {
                            $results[$key][$this->alias][$field] = $tmp;
                        }
                    }
                }
            }
        }

        return $results;
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
    
    function create($data = array(), $filterKey = false){
        if(empty($data)){
            return parent::create($data, $filterKey);
        }
        parent::create();

        $data[$this->alias]['price_type'] = PRICE_TYPE;
        if($data[$this->alias]['buyer_is_company']){
            $data[$this->alias]['number_prefix'] = $this->numberPrefixCompany;
        } else {
            $data[$this->alias]['number_prefix'] = $this->numberPrefixPerson;
        }
        $data[$this->alias]['number_period'] = $this->numberPeriod;
        $data[$this->alias]['number_sufix'] = $this->numberSufix;

        $data[$this->alias]['taxes'] = Commerce::calculateTotalTax($data[$this->alias]['items']);
//        $total = Commerce::getTotalPricesForOrder($data[$this->alias]['taxes']);
        $total = Commerce::getTotalPricesForOrder($data[$this->alias]);

        $data[$this->alias]['total_net'] = $total['final_price_net'];
        $data[$this->alias]['total_tax'] = $total['final_tax_value'];
        $data[$this->alias]['total_gross'] = $total['final_price_gross'];

        $this->request->data = $data;

        $this->id = $this->insertNextNumber();
        
        if($this->id == false){
            return false;
        }
        
        $this->request->data[$this->alias]['id'] = $this->id;
        $this->request->data[$this->alias]['pdf'] = Inflector::slug($this->field('number')).'.pdf';

        $this->save($this->request->data);

        $this->requestAction(array('prefix' => 'admin', 'admin' => 'admin', 'plugin' => 'payments', 'controller' => 'invoices', 'action' => 'pdf'), array('pass' => array($this->id)));
        
        return true;
    }

    private function insertNextNumber(){

        $now = time();
        $created = date('Y-m-d H:i:s', $now);
        $prefix = $this->request->data[$this->alias]['number_prefix']?$this->request->data[$this->alias]['number_prefix'].'/':'';
        $sufix = $this->request->data[$this->alias]['number_sufix']?'/'.$this->request->data[$this->alias]['number_sufix']:'';

        switch($this->request->data[$this->alias]['number_period']){
            case 'month':
                $date_from = date('Y-m-01 00:00:00', $now);
                $date_to = date('Y-m-t 00:00:00', $now);
                $date = date('m/Y', $now);
                break;
            case 'year':
                $date_from = date('Y-01-01 00:00:00', $now);
                $date_to = date('Y-12-31 00:00:00', $now);
                $date = date('Y', $now);
                break;
            default:
                die("Error: Invoice.number_period must be set to 'month' or 'year'");
        }

        $query = "INSERT INTO invoices (number_prefix, number_int, number_period, number_sufix, number, created) SELECT 
            '{$this->request->data[$this->alias]['number_prefix']}',
            IF(MAX(number_int), MAX(number_int)+1, 1),
            '{$this->request->data[$this->alias]['number_period']}',
            '{$this->request->data[$this->alias]['number_sufix']}',
            CONCAT(
                '{$prefix}', 
                IF(MAX(number_int), 
                MAX(number_int)+1, 1), 
                '/', 
                '{$date}', 
                '{$sufix}'
            ) ,
            '{$created}'
            FROM invoices
                WHERE created BETWEEN '{$date_from}' AND '{$date_to}'";

//                debug($query);
        if($this->query($query)){
            $id = $this->query("SELECT LAST_INSERT_ID() AS id;");
            return $id[0][0]['id'];
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
//        $params['conditions']['OR']["Invoice.seller LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

