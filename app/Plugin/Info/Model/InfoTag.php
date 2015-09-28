<?php

App::uses('AppModel', 'Model');

/**
 * InfoTag Model
 *
 */
class InfoTag extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array('Translate' => array('name'));

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $primaryKey = 'id';

    /**
     * Domyślne sortowanie
     *
     * @var string
     */
    public $order = 'InfoTag.created DESC';

    /**
     * Callback wykonywany przed walidajcją
     * 
     * @param type $options 
     */
    public function beforeValidate($options = array()) {
        $this->validate = array(
            'count' => array(
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => __d('cms', 'Pole formularza nie może być puste'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
        );
    }

    /**
     * Funkcja aktualizuję model tagów
     */
    public function pushTag($tag, $selectionId) {
        if (!$tag)
            return false;

        $tag = $this->tagFormat($tag);
        $params['conditions']['I18n__InfoTag_name.content'] = $tag;
        $params['conditions']['InfoTag.selection_id'] = $selectionId;
        $_tag = $this->find('first', $params);
                
        if (!empty($_tag)) {
            $this->incrementTag($tag, $selectionId);
            return $_tag['InfoTag']['id'];
        } else {
            $this->create();
            if (!$this->save(array('InfoTag' => array('name' => $tag, 'selection_id' => $selectionId)))) {
                throw new Exception('Błąd zapisu');
            }
            return $this->getLastInsertID();
        }
    }

    public function decrementTag($tag, $selectionId) {
        if (!$tag)
            return false;

        $params['conditions']['I18n__InfoTag_name.content'] = $tag;
        $params['conditions']['InfoTag.selection_id'] = $selectionId;
        $data = $this->find('first', $params);

        if (!$data) {
            return false;
        }

        $this->set($data);
        //$params['conditions']['.selection_id'] = $selectionId;
        $row = $this->find('first', array(
            'conditions' => array(
                'I18n__InfoTag_name.content' => $tag,
                'InfoTag.selection_id' => $selectionId
            ),
        ));
        
        $conditions['InfoTag.id'] = $row['InfoTag']['id'];
        $fields['count'] = '`InfoTag`.`count` - 1';
        if (!$this->updateAll($fields, $conditions)) {
            throw new Exception('Błąd aktualizacji');
        }

        return true;
    }

    public function incrementTag($tag, $selectionId) {

        $row = $this->find('first', array(
            'conditions' => array(
                'InfoTag.selection_id' => $selectionId,
                'I18n__InfoTag_name.content' => $tag
            ),
        ));

        $conditions['InfoTag.id'] = $row['InfoTag']['id'];
        $fields['count'] = '`InfoTag`.`count` + 1';
        if (!$this->updateAll($fields, $conditions)) {
            throw new Exception('Błąd aktualizacji');
        }
    }

    public static function tagFormat($tag) {
        //Zawsze pierwsza litera duża

        return ucfirst($tag);
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

    public function saveTags($tags, $selectionId) {
        $tagsArray = array();
        $tagsString = explode(',', $tags);

        
        
        foreach ($tagsString as &$tag) {
            $tagsArray[] = $this->pushTag(trim($tag), $selectionId);
        }
        return $tagsArray;
    }

    public function removeTags($tags, $selectionId) {
        $tags = explode(',', $tags);

        foreach ($tags as &$tag) {
            $this->decrementTag(trim($tag), $selectionId);
        }
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
//        $params['conditions']['OR']["InfoTag.name LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

