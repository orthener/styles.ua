<?php
App::uses('AppInstall', 'Install');

/**
 * Order Controller
 *
 */
class OrderInstall extends AppInstall {

    public function init($module) {
        list($model, $plugin) = pluginSplit($module);
        $this->model = ClassRegistry::init($model);
    }
    
    public function install() {
        //$this->model->
    }

}
