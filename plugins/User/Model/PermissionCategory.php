<?php
App::uses('AppModel', 'Model');
/**
 * PermissionCategory Model
 *
 * @property PermissionGroup $PermissionGroup
 */
class PermissionCategory extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array();
    
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
	public $order = 'PermissionCategory.created DESC';

	/**
 	* hasMany associations
 	*
 	* @var array
 	*/
	public $hasMany = array(
		'PermissionGroup' => array(
			'className' => 'User.PermissionGroup',
			'foreignKey' => 'permission_category_id',
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
    
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Pole formularza nie może być puste',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );
    
    /**
     * Callback wykonywany przed walidajcją
     * 
     * @param type $options 
     */
    public function beforeValidate($options = array()) {
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
    
    
//    public function getCategoryTree() {
//        $ret = array();
//        $this->recursive = 1;
//        
//        $permissionCategories = $this->find('all');
//        
//        debug($permissionCategories);
//        
//        foreach($permissionCategories as $permissionCategory) {
//            $ret = a;
//            
//            
//            
//        }
//        
//        
//        return $ret;
//    }
    
//[
//	{
//		"text": "1. Review of existing structures",
//		"expanded": true,
//		"children":
//		[
//			{
//				"text": "1.1 jQuery core"
//			},
//		 	{
//				"text": "1.2 metaplugins"
//			}
//		]
//	},
//	{
//		"text": "2. Wrapper plugins"
//	},
//	{
//		"text": "3. Summary"
//	},
//	{
//		"text": "4. Questions and answers"
//	}
//	
//]
    
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
//        $params['conditions']['OR']["PermissionCategory.name LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

