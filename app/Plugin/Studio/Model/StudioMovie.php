<?php

App::uses('AppModel', 'Model');

/**
 * StudioMovie Model
 *
 */
class StudioMovie extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array('Image.Upload', 'Translate' => array('name'));

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $mediaTypes = array(
        0 => 'youtube',
        1 => 'pliki',
    );

    /**
     * Callback wykonywany przed walidajcją
     * 
     * @param type $options 
     */
    public function beforeValidate($options = array()) {
        $this->validate = array(
            'name' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    'message' => __d('cms', 'Pole formularza nie może być puste'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'file' => array(
                'mp3' => array(
                    'rule' => array('extension', array('mp3', '')),
                    'message' => 'Błędny typ pliku',
                ),
                'allowEmpty' => true,
            ),
           'url' => array(
                'website' => array(
                    'rule' => 'url',
                    'message' => 'Podaj poprawny adres internetowy',
                    'allowEmpty' => true,
                )
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
        $this->mediaTypes = array(
            0 => 'youtube',
            1 => __d('cms', 'File'),
        );
        
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
//        $params['conditions']['OR']["StudioMovie.name LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}
