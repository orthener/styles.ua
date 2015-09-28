<?php
class Note extends AppModel {
	var $name = 'Note';
	var $displayField = 'title';
     
    var $actsAs = array('Modification'); 
    
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);    
    
}
?>