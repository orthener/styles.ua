<?php

App::uses('AppModel', 'Model');

/**
 * ProductsCategory Model
 *
 */
class ProductsProductCategory extends AppModel {


    /**
     * Domyślne sortowanie
     *
     * @var string
     */
    public $order = 'ProductsProductCategory.created DESC';
    public $displayField = 'product_id';

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

    public function setScope($scope) {
        $this->Behaviors->attach('Menu.Menu', array('scope' => $scope));
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
//        $params['conditions']['OR']["ProductsCategory.name LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

