<?php
App::uses('AppModel', 'Model');

/**
 * OrderItemFile Model
 *
 * @property OrderItem $OrderItem
 */
class OrderItemFile extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array('Image.Upload');
    var $tablePrefix = 'commerce_';
    /**
    * Display field
    *
    * @var string
    */
	public $displayField = 'name';

	/**
 	* belongsTo associations
 	*
 	* @var array
 	*/
	public $belongsTo = array(
		'OrderItem' => array(
			'className' => 'Commerce.OrderItem',
			'foreignKey' => 'order_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    
    public $fileStatuses = array(
        0 => 'Do akceptacji',
        1 => 'Zaakceptowany',
        2 => 'Niezaakceptowany'
    );
    
 
    /**
     * Callback wykonywany przed walidajcją
     * 
     * @param type $options 
     */
    public function beforeValidate($options = array()) {
		$this->validate = array(
            'name' => array(
                'upload' => array('rule' => 'validateUpload'),
                'mime' => array('rule' => array('validateMime'), 'allowType' => '/pdf|x-pdf|tiff|postscript|eps|ai|cdr|psd|photoshop|application\/octet-stream/',
                    'message' => __d('cms', 'Dozwolone tylko formaty graficzne (PSD, TIFF, EPS, CDR, AI, PDF)')
                ),
                'extension' => array('rule' => array('validateFileExt'),
                    'allowExtensions' => array('psd', 'tiff', 'eps', 'cdr', 'ai', 'pdf'),
                    'message' => 'Dozwolone tylko formaty graficzne (PSD, TIFF, EPS, CDR, AI, PDF)'
                ),
            )
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
//        $params['conditions']['OR']["OrderItemFile.name LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

