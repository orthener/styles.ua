<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    public function beforeDelete($cascade = true) {
        if ($this->hasField('lock')) {
            if ($this->field('lock')) {

                return false;
            }
        }
        return true;
    }   
    
    /**
     * Główna logika dla globalnej wyszukiwarki w cms
     * 
     * @param array $options
     * @param array $params
     * @return type array
     */
    public function search($options, $params = array()) {
        if (isSet($this->displayField)) {
            $fraz = $options['Searcher']['fraz'];
            $params['conditions']["{$this->name}.{$this->displayField} LIKE"] = "%{$fraz}%";
            $params['limit'] = 5;

            $this->recursive = -1;        
            return $this->find('all', $params);
        } else {
            return array();
        }
    }
}
