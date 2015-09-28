<?php

App::uses('AppModel', 'Model');

/**
 * InfoPage Model
 *
 * @property $InfoCategory InfoCategory
 * @property $InfoTag InfoTag
 */
class InfoPage extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array('Slug.Slug', 'Translate' => array('title', 'slug', 'content', 'tags'));

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * Domyślne sortowanie
     *
     * @var string
     */
    public $order = 'InfoPage.created DESC';

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
            'title' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    'message' => __d('cms', 'Pole formularza nie może być puste'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'slug' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    'message' => __d('cms', 'Pole formularza nie może być puste'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
        );

        return true;
    }

    public $belongsTo = array(
        'InfoCategory' => array(
            'className' => 'Info.InfoCategory',
            'foreignKey' => 'category_id'
        ),
        'Photo' => array(
            'className' => 'Photo.Photo',
            'foreignKey' => 'photo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
        /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Photos' => array(
            'className' => 'Photo.Photo',
            'foreignKey' => 'info_page_id',
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
    
    public $hasAndBelongsToMany = array(
        'InfoTag' => array(
            'className' => 'Info.InfoTag',
            'joinTable' => 'info_tags_info_pages',
            'foreignKey' => 'info_page_id',
            'associationForeignKey' => 'info_tag_id',
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
    );

    /**
     * Wyciąga dane do modułu frontowych boxów
     * 
     * @return type array
     */
    public function frontBox($params) {
        $this->Behaviors->attach('Containable');

        $this->contain('Photo');

        return $this->find('first', array(
                    'conditions' => array(
                        'InfoPage.id' => $params['article_id']
                    )
        ));
    }

    public function save($data = null, $validate = true, $fieldList = array()) {

        if (isSet($data['InfoPage']['tags']) && is_string($data['InfoPage']['tags'])) {
            $tags = $this->InfoTag->saveTags($data['InfoPage']['tags'], $data['InfoPage']['selection_id']);
            $data['InfoTag']['InfoTag'] = $tags;
        }

        return parent::save($data, $validate, $fieldList);
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

    public function filterParams($data) {
        $params = array();
        if (!empty($data['InfoPage']['category_id'])) {
            $params['conditions']['InfoPage.category_id'] = $data['InfoPage']['category_id'];
        }
        if (!empty($data['InfoPage']['tag'])) {
            $params['conditions']['I18n__InfoPage_tags.content LIKE'] = '%' . h(base64_decode($data['InfoPage']['tag'])) . '%';
        }
        return $params;
    }

    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        if (!empty($extra['group'])) {
            $field = $extra['group'];
            unSet($extra['group']);
            $params = array_merge(
                    array('conditions' => $conditions), array('fields' => array("COUNT(DISTINCT {$field}) AS count")), $extra
            );
            $results = $this->find('all', $params);
            return $results[0][0]['count'];
        }

        $params = array_merge(array('conditions' => $conditions), array());

        return $this->find('count', $params);
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
//        $params['conditions']['OR']["InfoPage.name LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

