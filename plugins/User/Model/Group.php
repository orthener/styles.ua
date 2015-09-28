<?php
class Group extends AppModel {
	var $name = 'Group';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Wpisz nazwę grupy',
			),
		),
		'alias' => array(
			'custom' => array(
				'rule' => '/[A-Za-z0-9_-]{1,15}/',
				'message' => 'Alias może zawierać tylko litery cyfry i znaki - oraz _',
			),
		),
	);

	var $actsAs = array(
        'Modification.Modification'
    );

	var $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User.User',
			'joinTable' => 'groups_users',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'user_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Permission' => array(
			'className' => 'User.Permission',
			'joinTable' => 'requesters_permissions',
			'foreignKey' => 'row_id',
			'associationForeignKey' => 'permission_id',
			'unique' => true,
			'conditions' => array('RequestersPermission.model' => 'Group'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
    
    /**
     * Serializacja pól PermissionGroup
     * 
     * @return boolean 
     */
    function beforeSave() {
        if (isSet($this->data['PermissionGroup'])) {
            $this->data[$this->name]['permission_groups'] = json_encode($this->data['PermissionGroup']);
        }
        return true;
    }
    /**
     * Logika powiązań z modelem RequestersPermission, usuwanie odznaczonych
     * oraz zapisywanie zaznaczonych uprawnień w chwili obecnym ich stanie
     * 
     * @param type $created
     * @return boolean
     * @throws ErrorException 
     */
    function afterSave($created) {

        if (isSet($this->data['PermissionGroup'])) {
            $this->data[$this->name]['permission_groups'] = json_encode($this->data['PermissionGroup']);
            
            $params['conditions']['Permission.permission_group_id'] = $this->data['PermissionGroup']['PermissionGroup'];
            $params['fields'] = array('Permission.id');
            $permissions = $this->Permission->PermissionGroup->Permission->find('list', $params);

            $params = array();
            $params['conditions']['RequestersPermission.model'] = $this->name;
            $params['conditions']['RequestersPermission.row_id'] = $this->data[$this->name]['id'];
            $params['fields'] = array('RequestersPermission.permission_id');
            $requestersPermissionsToDelete = $this->Permission->RequestersPermission->find('list', $params);
            if (!empty($requestersPermissionsToDelete)) {
                if (!$this->Permission->RequestersPermission->deleteAll(array('RequestersPermission.permission_id' => $requestersPermissionsToDelete), false)) {
                    throw new ErrorException(__d('cms', 'Krytyczny błąd podczas usuwania uprawnień'));
                }
            }
            if (!empty($permissions)) {
                $toSave['RequestersPermission']['model'] = $this->name;
                $toSave['RequestersPermission']['row_id'] = $this->data[$this->name]['id'];
                foreach($permissions as $permissionId) {
                    $toSave['RequestersPermission']['permission_id'] = $permissionId;
                    $this->Permission->RequestersPermission->create();
                    if (!$this->Permission->RequestersPermission->save($toSave)) {
                        throw new ErrorException(__d('cms', 'Krytyczny błąd podczas zapisywania uprawnień (odznaczone uprawnienia zostały już usunięte)'));
                    }
                }
            }
            unset($this->data['PermissionGroup']);
        }
        return true;
    }
    
    /**
     * Deserializacja pól PermissionGroup
     * 
     * @param type $dates
     * @return type 
     */
    function afterFind($dates) {
        foreach ($dates as &$data) {
            if (isSet($data[$this->name]['permission_groups'])) {
                if ($data[$this->name]['permission_groups'] == null) {
                    $data['PermissionGroup']['PermissionGroup'] = array();
                } else {
                    $data['PermissionGroup'] = json_decode($data[$this->name]['permission_groups'], true);                    
                    if (empty($data['PermissionGroup']['PermissionGroup'])) {
                        $data['PermissionGroup']['PermissionGroup'] = array();
                    }
                }
            } else {
                $data['PermissionGroup']['PermissionGroup'] = array();
            }
        }
        return $dates;
    }
    
}
?>