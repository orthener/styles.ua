<?php
class RequestersPermission extends AppModel {
	var $name = 'RequestersPermission';
	var $displayField = 'model';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User.User',
			'foreignKey' => 'row_id',
			'conditions' => array('RequestersPermission.model' => 'User'),
		),
		'Group' => array(
			'className' => 'User.Group',
			'foreignKey' => 'row_id',
			'conditions' => array('RequestersPermission.model' => 'Group'),
		),
		'Permission' => array(
			'className' => 'User.Permission',
			'foreignKey' => 'permission_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    function getGroupsPermissionsConfigChanges() {
        $queries = array();
        $dbo = $this->getDatasource();
        foreach($dbo->_queriesLog AS &$query){
            if(stripos($query['query'], 'INSERT ') !== false OR stripos($query['query'], 'DELETE ') !== false OR stripos($query['query'], 'UPDATE ') !== false){
                $queries[] = $query['query'];
            }
        }
        return $queries;
    }


}
?>