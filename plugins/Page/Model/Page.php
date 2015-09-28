<?php

class Page extends AppModel {

    var $name = 'Page';
    public static $categories = array(
        0 => 'www',
        1 => 'studio',
        2 => 'blog'
    );
    var $actsAs = array(
        'Slug.Slug',
        'Translate' => array('name', 'desc', 'slug', 'description', 'keywords'),
        'Image.Upload' => array('imageOptions' => array('size' => array('width' => 1920, 'height' => 1200))),
            //'Tree.FebTree'
    );
    var $hasMany = array(
//        'Comment' => array(
//            'className' => 'Comment.Comment',
//            'foreignKey' => 'page_id',
//            'dependent' => true,
//            'conditions' => '',
//            'fields' => '',
//            'order' => 'Comment.id ASC',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
//        ),
        'Photos' => array(
            'className' => 'Photo.Photo',
            'foreignKey' => 'page_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'Photos.order ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    var $belongsTo = array(
        'PagePhoto' => array(
            'className' => 'Photo.Photo',
            'foreignKey' => 'photo_id',
        )
    );
    var $displayField = 'name';
    var $validate = array(
        'name' => array(
            'length' => array(
                'rule' => array('notempty')
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'imieNazwisko' => array(
            'length' => array(
                'rule' => array('notempty'),
                'message' => 'Wpisz swoje imię'
//				'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'Wpisz poprawny adres e-mail',
            //'allowEmpty' => false,
            //'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'pictogram' => array(
            'mime' => array(
                'rule' => array('validateMime', 'image'),
                'message' => 'Ten formularz akceptuje jedynie pliki graficzne (jpeg, gif, png)'
            ),
            'upload' => array(
                'rule' => 'validateUpload'
            )
        )
    );

    function beforeValidate() {
        parent::beforeValidate();
        $this->validate['name']['length']['message'] = __d('cms', "Wprowadź tytuł strony");
    }

    function set_translate($on = true) {
        if ($on) {
            $this->Behaviors->attach('Translate', array('name' => 'translateDisplay', 'desc', 'slug', 'description', 'keywords'));
        } else {
            $this->Behaviors->detach('Translate');
        }
    }

    public function search($options, $params = array()) {
        $params['limit'] = 5;
        $language = Configure::read('Config.languages');
        $this->locale = $language;
        $params['conditions']["I18n__translateDisplay__pol.content LIKE"] = "%{$options['Searcher']['fraz']}%";
        //$this->Page->locale = Configure::read('Config.locale');
        $this->bindTranslation(array('name' => 'translateDisplay'));

        $this->recursive = 1;
        return $this->find('all', $params);
    }

    function filterParams($data) {
        $params = array();
        if (!empty($data['Page']['name'])) {
            $params['conditions']['Page.name'] = $data['Page']['name'];
        }
        if (!empty($data['Page']['category'])) {
            $params['conditions']['Page.category'] = $data['Page']['category'];
        }

        return $params;
    }

//     function read($fields, $id){
//         $results = parent::read($fields, $id);
//         if(!empty($results)){
//             return $results;
//         }
//         $this->locale = array('eng','pol','deu', 'spa');
//         $this->recursive = 1;
//         $results = parent::read($fields, $id);
// //         return $results;
//         debug($results);
//     }
}

?>