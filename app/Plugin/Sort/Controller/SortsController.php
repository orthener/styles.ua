<?php
App::uses('AppController', 'Controller');

/**
 * Sort Controller
 *
 */
class SortsController extends AppController {

    public $name = 'Sorts';
    /**
     * Nazwa layoutu
     */
    public $layout = 'admin';

    /**
     * Kontroler nie wykorzystuje modelu
     */
    public $uses = false;
    
    public function admin_sort($module) {
        $module = str_replace('_', '.', $module);
        list($plugin, $model) = pluginSplit($module);
        $this->loadModel($module);        
        $params['recursive'] = -1;
        $datas = $this->$model->find('all', $params);
        $this->set('model', $this->$model);
        $this->set(compact('datas', 'plugin'));
    }

    /**
     * Akcja sortująca tabele
     * 
     * @param mixed $id 
     */
    public function admin_resort($module) {
        $module = str_replace('_', '.', $module);
        $this->layout = 'ajax';
        list($plugin, $model) = pluginSplit($module);
        $this->loadModel($module);
        $reLocate = $this->request->data['reLocate'];
        $order = 0; 
        
        foreach($reLocate as $id) {
            $conditions[$this->$model->alias.'.'.$this->$model->primaryKey] = $id;     
            $this->$model->updateAll(array('order' => $order), $conditions);
            $order++;
        }
        
        $this->render(false);
    }

}
