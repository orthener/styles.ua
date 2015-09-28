<?php

App::uses('AppModel', 'Model');

/**
 * Modification Model
 *
 * @property User $User
 */
class Modification extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'created';

    public $ignoreList = array('product');
    
    public $order = "Modification.created DESC";
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    /**
     * Funkcja odszyfrowywujaca zawartosc contentów
     * 
     * @param type $modData 
     */
    public function unSerialize($modData = array()) {
        foreach($modData as &$mod) {
            if (isSet($mod['Modification'])) {
                if (isSet($mod['Modification']['user_details'])) {
                    $mod['Modification']['User'] = json_decode($mod['Modification']['user_details'], true);
                }
                if (isSet($mod['Modification']['content_before'])) {
                    $mod['Modification']['Before'] = json_decode($mod['Modification']['content_before'], true);
                }
                if (isSet($mod['Modification']['content_after'])) {
                    $mod['Modification']['After'] = json_decode($mod['Modification']['content_after'], true);
                }
            }
        }     
        return $modData;
    }

}
