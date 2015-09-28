<?php

App::uses('AppModel', 'Model');

/**
 * Searcher Model
 *
 */
class Searcher extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array();
    public $ignoreModels = array(
        'AppModel', 'Group',
        'Permission', 'RequestersPermission', 'Menu',
        'UsersLog', 'Searcher', 'Comment', 'GoogleAnalyticsAccount',
        'Slug', 'Setting', 'PagePhoto', 'Category', 'Help', 'DynamicElement'
    );

    /**
     * Konstruktor klasy modelu
     * 
     * @param int $id
     * @param array $table
     * @param bool $ds 
     */
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        //$this->virtualFields = array('fullname' => "CONCAT({$this->alias}.field_1, ' ', {$this->alias}.field_2)");
    }

    public function getModels() {
        $allPlugins = App::objects('plugin');

        $searchModels = array();
        foreach($allPlugins as $plugin) {
            $allModels = App::objects("{$plugin}.model");
            foreach ($allModels as $model) {
                if (!in_array($model, $this->ignoreModels)) {
                    $searchModels[] = array('model' => $model, 'plugin' => $plugin);
                }
            }
        }
                
        return $searchModels;
    }

}

