<?php
App::import('Vendor', 'Help.HelpVendor');
class Help extends AppModel {
	var $name = 'Help';
	var $displayField = 'title';

	var $validate = array(
//		'url' => array(
//			'url' => array(
//				'rule' => array('url'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		)
	);
    
    /**
     * @desc Pobiera z drzewa wygenerowanego na podstawie URL najaktualniejsza pomoc
     * @param type $tree
     * @return type array
     */
    function getLastHelp($tree) {
        $tree = array_reverse($tree);
        
//        debug($tree);
//        exit;
//        
        foreach($tree as $path => $url) {
            $help = $this->find('first', array('conditions' => array('Help.url' => $path)));
            if (!empty($help)) {
                return $help;
            }
        }
        return array();
    }
       
}
