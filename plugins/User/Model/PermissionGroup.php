<?php
App::uses('AppModel', 'Model');
/**
 * PermissionGroup Model
 *
 * @property PermissionCategory $PermissionCategory
 * @property Permission $Permission
 */
class PermissionGroup extends AppModel {

    /**
     * Pole inicjalizujÄ…ce Behaviory
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
    * DomyĹ›lne sortowanie
    *
    * @var string
    */
	public $order = 'PermissionGroup.created DESC';

	/**
 	* belongsTo associations
 	*
 	* @var array
 	*/
	public $belongsTo = array(
		'PermissionCategory' => array(
			'className' => 'User.PermissionCategory',
			'foreignKey' => 'permission_category_id',
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
		'Permission' => array(
			'className' => 'User.Permission',
			'foreignKey' => 'permission_group_id',
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
     * Usuwam powiazania z dodanych uprawneń, ale nie usuwam rekordów bezpośrednio w permission,
     * ale usuwam rekordy z RequestersPermission oraz z serializowanych pól zapisanych bezpośrednio w użytkownikach
     * 
     * @param type $event
     * @return boolean 
     */
    public function afterDelete($event) {
        if ($event->result) {
            $this->Permission->recursive = -1;
            
            //Wyciągam wszystkie permissions z tej grupy
            $permissions = $this->Permission->find('list', array('fields' => array('Permission.id'), 'conditions' => array('Permission.permission_group_id' => $this->id)));
            
            //Odwiązuje je od usuniętej grupy
            if (!$this->Permission->updateAll(array('Permission.permission_group_id' => null), array('Permission.permission_group_id' => $this->id))) {
                throw new ErrorException(__d('cms', 'Krytyczny błąd podczas odbindowania uprawnień z kategorii'));
            }
             
            //Usuwam je z request_permissions
            $this->Permission->RequestersPermission->deleteAll(array('RequestersPermission.permission_id' => $permissions), false);
            
            //Trzeba usunąć w powiązanych polach zserializowanych uprawnień GROUP I USER w tym celu:
            
            App::uses('User', 'User.User');
            $this->User = new User();
            
            //Wyszukuje wiedząć, że pola są w afterFind zdeserializowane
            $this->User->recursive = -1;
            $allUsers = $this->User->find('all');
                        
            //Wyszukuje w userach pól gdzie mogli mieć powiązanie z usuwaną grupą
            //                          !!!UWAGA!!!
            //Jeżeli wystąpi krtyczny błąd podczas poniższych czynności, 
            //w celu naprawy można ponownie zapisać uprawnienia grupy bądź użytkowników
            //w akcji edit
            
            foreach($allUsers as $user) {
                $user['PermissionGroup']['PermissionGroup'] = array_flip($user['PermissionGroup']['PermissionGroup']);
                if (isSet($user['PermissionGroup']['PermissionGroup'][$this->id])) {
                    unSet($user['PermissionGroup']['PermissionGroup'][$this->id]);
                    $user['PermissionGroup']['PermissionGroup'] = array_flip($user['PermissionGroup']['PermissionGroup']);
                    if (!$this->User->save($user)) {
                        throw new ErrorException(__d('cms', 'Krytyczny błąd podczas usuwania powiązanej grupy uprawnień z grupą użytkowników'));
                    }
                }
            }
            
            App::uses('Group', 'User.Group');
            $this->Group = new Group();
            
            $this->Group->recursive = -1;
            $allGroup = $this->Group->find('all');
            
            //To samo robię  grupach
            foreach($allGroup as $group) {
                $group['PermissionGroup']['PermissionGroup'] = array_flip($group['PermissionGroup']['PermissionGroup']);
                if (isSet($group['PermissionGroup']['PermissionGroup'][$this->id])) {
                    
                    unSet($group['PermissionGroup']['PermissionGroup'][$this->id]);
                    $group['PermissionGroup']['PermissionGroup'] = array_flip($group['PermissionGroup']['PermissionGroup']);
                    if (!$this->Group->save($group)) {
                        throw new ErrorException(__d('cms', 'Krytyczny błąd podczas usuwania powiązanej grupy uprawnień z grupą użytkowników'));
                    }
                }
            }
            
        }
        return true;
    }
    
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
     * Callback wykonywany przed walidajcjÄ…
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
    
    /**
     * Logika dla globalnej wyszukiwarki w cms
     * nadpisuje metodÄ™ z AppModel
     * 
     * @param array $options
     * @param array $params
     * @return type array
     */
//    public function search($options, $params = array()) {
//        $fraz = $options['Searcher']['fraz'];
//        $params['conditions']['OR']["PermissionGroup.name LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

