<?php

App::uses('AppModel', 'Model');

/**
 * SimilarProduct Model
 */
class ProductsSize extends AppModel {


    public $order = 'ProductsSize.name ASC';
    public $displayField = 'name';
       
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
}