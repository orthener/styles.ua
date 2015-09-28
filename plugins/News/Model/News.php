<?php

App::uses('AppModel', 'Model');

/**
 * News Model
 *
 * @property User $User
 * @property Photo $Photo
 * @property Photo $Photo
 */
class News extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array(
        'Slug.Slug',
            //'Translate' => array('title', 'content', 'slug', 'tiny_content')
    );

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
    public $order = 'News.date DESC';

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User.User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Photo' => array(
            'className' => 'Photo.Photo',
            'foreignKey' => 'photo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'NewsCategory' => array(
            'className' => 'News.NewsCategory',
            'foreignKey' => 'news_category_id',
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
        'Photos' => array(
            'className' => 'Photo.Photo',
            'foreignKey' => 'news_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'Photos.order ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Comment' => array(
            //'className' => 'News.Comment',
            'className' => 'Comment.Comment',
            'foreignKey' => 'news_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            //'order' => 'Comment.id ASC',
            'order' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * Callback wykonywany przed walidajcją
     * 
     * @param type $options 
     */
    public function beforeValidate($options = array()) {
        $this->validate = array(
            'main' => array(
                'boolean' => array(
                    'rule' => array('boolean'),
                    'message' => __d('pluginsvalidate', 'Pole formularza nie może być puste'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'slug' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    'message' => __d('pluginsvalidate', 'Pole formularza nie może być puste'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
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
//        $params['conditions']['OR']["News.title LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
    public function filterParams($data) {
        //debug($data); exit;
        $params = array();
        if (empty($data['News']['year'])) {
            $params['conditions']['News.date >='] = date('Y') . '-' . date('m') . '-00 00:00:00';
            $params['conditions']['News.date <='] = date('Y') . '-' . date('m') . '-' . date('t') . ' 23:59:59';
        } else {
            if (empty($data['News']['month'])) {
                $params['conditions']['News.date >='] = $data['News']['year'] . '-01-01 00:00:00';
                $params['conditions']['News.date <='] = $data['News']['year'] . '-12-31 23:59:59';
            } else {
                $m31 = array('01', '03', '05', '07', '08', '10', '12');
                $m30 = array('04', '06', '09', '11');

                if (in_array($data['News']['month'], $m31)) {
                    $maxDays = '31';
                } elseif (in_array($data['News']['month'], $m30)) {
                    $maxDays = '30';
                } else {
                    if (($data['News']['year'] % 4 == 0 && $data['News']['year'] % 100 != 0) || $data['News']['year'] % 400 == 0) {
                        $maxDays = '29';
                    } else {
                        $maxDays = '28';
                    }
                }
                $params['conditions']['News.date >='] = $data['News']['year'] . '-' . $data['News']['month'] . '-01 00:00:00';
                $params['conditions']['News.date <='] = $data['News']['year'] . '-' . $data['News']['month'] . '-' . $maxDays . ' 23:59:59';
            }
        }
        if (!empty($data['News']['author'])) {
            $params['conditions']['News.user_id'] = $data['News']['author'];
        }

        return $params;
    }
    
    public function cmsfilterParams($data) {
        //debug($data); exit;
        $params = array();
        if (!empty($data['News']['created_from']) || !empty($data['News']['created_to'])) {
            if (!empty($data['News']['created_from']) && !empty($data['News']['created_to'])) {
                $params['conditions']['AND'] = array(
                                        array('News.created >=' => $data['News']['created_from']), 
                                        array('News.created <=' => $data['News']['created_to']));
            }
            elseif (!empty($data['News']['created_from'])) {
                $params['conditions']['News.created >='] = $data['News']['created_from'];
            }
            elseif (!empty($data['News']['created_to'])) {
                $params['conditions']['News.created <='] = $data['News']['created_to'];
            }
        }
        if (!empty($data['News']['date_from']) || !empty($data['News']['date_to'])) {
            if (!empty($data['News']['date_from']) && !empty($data['News']['date_to'])) {
                $params['conditions']['AND'] = array(
                                        array('News.created >=' => $data['News']['date_from']), 
                                        array('News.created <=' => $data['News']['date_to']));
            }
            elseif (!empty($data['News']['date_from'])) {
                $params['conditions']['News.created >='] = $data['News']['date_from'];
            }
            elseif (!empty($data['News']['date_to'])) {
                $params['conditions']['News.created <='] = $data['News']['date_to'];
            }
        }
        if (!empty($data['News']['title'])) {
            $params['conditions']['News.title LIKE'] = '%' . $data['News']['title'] . '%';
        }
        if (!empty($data['News']['news_category_id'])) {
            $params['conditions']['News.news_category_id'] = $data['News']['news_category_id'];
        }

        return $params;
    }

}
