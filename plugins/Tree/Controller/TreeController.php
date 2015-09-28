<?php
class TreeController extends AppController
{
    var $uses = array();
	var $components = array('RequestHandler');
    var $helpers = array('Js'=>array('engine'=>'jquery'),'Paginator');
    var $layout = 'admin';


    function _checkAccess(&$model){

        if(empty($model)){
            $this->cakeError('error404');
        }

        $this->loadModel($model);
        
        if(empty($this->$model->actsAs) or !is_array($this->$model->actsAs) OR !in_array('Tree.FebTree', $this->$model->actsAs)){
            $this->cakeError('error404');
        }
    }

    function index($model = null, $treeMode = '') {
        $this->_checkAccess($model);

        $this->add($model, true);

        if($this->$model->Behaviors->attached('Translate') && Configure::read('Config.languages')){
    		$this->$model->locale = Configure::read('Config.languages');
        }

        $tree = $this->$model->findTree();
        $this->set('tree', $tree);
        
        $this->set('is_ajax', $this->RequestHandler->isAjax());

        $this->set('modelAlias', $model);
        $this->set('modelName', $model);
        $this->set('treeMode', $treeMode);

        return $tree;
    }
    
    function relatedindex($model = null, $params = null){

        if(empty($model)){
            $this->cakeError('error404');
        }
        $this->loadModel($model);

        if(empty($this->$model->alias)){
            $this->cakeError('error404');
        }

        if(method_exists($this->$model, 'set_translate')){
            $this->$model->set_translate();
        }
        if($this->$model->Behaviors->attached('Translate') && Configure::read('Config.languages')){
    		$this->$model->locale = Configure::read('Config.languages');
        }

        $alias = $this->$model->alias;
        if($params){
            if($params == 'podstrony'){
                $this->paginate['Page']['conditions']['gallery'] = 0;
            }
            if($params == 'galerie'){
                $this->paginate['Page']['conditions']['gallery'] = 1;
            }
        }
        $this->paginate['Page']['limit'] = 10;
        $relatedData = $this->paginate($this->$model);
        $displayField = $this->$model->displayField;
        
        $this->set(compact('relatedData', 'alias', 'displayField'));  
    }
    
    function reset($model){
        $this->_checkAccess($model);
        $this->$model->recover('parent');
        $this->$model->recover('tree');
        $this->redirect(array('action'=>'index', $model), null, true);
        
    }
    function update($model = null) {
    
        $this->_checkAccess($model);

        if(empty($this->data['dest_id']) or empty($this->data['id'])){
            exit;
        }

        if(empty($this->data['mode'])){
            $this->request->data['mode'] = null;
        }

        $valid = $this->$model->validateDepth($this->data['id'], $this->data['dest_id'], $this->data['mode']);
        if($valid === false){
            $this->Session->setFlash($this->$model->validate['depth']['message']);
        }

        if($valid === true && $this->$model->moveNode($this->data['id'], $this->data['dest_id'], $this->data['mode'])){
            //success
            $this->Session->setFlash(__d('cms','Zmieniono pozycję'));
        }
    //debug($this->referer());
        $this->render(false);
        //$this->redirect($this->referer());
        return false;
    }

    function add($model = null, $requested = false) {
        $this->_checkAccess($model);

        if(empty($this->data)){
            if(!$requested){
                $this->render(false);
            }
            return false;
        }
        
        if(empty($this->data['Tree']['name'])){
            $this->Session->setFlash(__d('cms','Wprowadź nazwę, aby dodać pozycję.'));
            if(!$requested){
                $this->render(false);
            }
            return false;
        }

        $this->request->data[$model]['name'] = $this->data['Tree']['name'];
        $this->$model->create();
        if($this->$model->save($this->data)){
            if(empty($this->data['dest_id'])){
                $this->Session->setFlash(__d('cms','Dodano pozycję na koniec drzewa.'));
            } else {
                $id = $this->$model->getInsertID();
                if(empty($this->data['mode'])){
                    $this->data['mode'] = null;
                }
                if($this->$model->moveNode($id, $this->data['dest_id'], $this->data['mode'])){
                    $this->Session->setFlash(__d('cms','Dodano pozycję do drzewa.'));
                } else {
                    $this->Session->setFlash(__d('cms','Dodano pozycję na koniec drzewa.'));
                }
            }
            $this->request->data = array();
        } else {
            $this->Session->setFlash(__d('cms','Dodanie pozycji nie powiodło się, sprawdź formularz i spróbuj ponownie'));
        }

        if(!$requested){
            $this->render(false);
        }
        return false;

    }

    function moveup($model = null, $id = null) {
        $this->_checkAccess($model);

        if (empty($id)) {
            $this->cakeError('error404');
        }
        $this->$model->id = $id;
        
        $this->$model->moveUp($id, 1);

        $this->redirect($this->referer(), null, true);
    }

    function movedown($model = null, $id = null) {
        $this->_checkAccess($model);

        if (empty($id)) {
            $this->cakeError('error404');
        }
        $this->$model->id = $id;
        
        $this->$model->moveDown($id, 1);

        $this->redirect($this->referer(), null, true);
    }


    function delete($model = null, $id = null, $all = null, $treeMode = '') {
        $this->loadModel($model);
        $lang = $this->I18n->l10n->locale;
        $this->_checkAccess($model);
        if (empty($id)) {
            $this->cakeError('error404');
        }    
        
        if($all != 0){
            $this->$model->delete($id);
        }else{
            $ile1 = $this->$model->query("SELECT COUNT(*) as `ile` FROM `i18n` WHERE `model` = '{$model}' AND locale = '{$lang}' AND foreign_key = {$id}");
            $ile2 = $this->$model->query("SELECT COUNT(*) as `ile` FROM `i18n` WHERE `model` = '{$model}' AND foreign_key = {$id}");
            if ($ile1[0][0]['ile'] == $ile2[0][0]['ile']) {
                $this->$model->delete($id);
            } else {
                $this->$model->query("DELETE FROM `i18n` WHERE `model` = '{$model}' AND locale = '{$lang}' AND foreign_key = {$id}");
            }
        }
        $this->redirect(array('action' => 'index', $model, $treeMode), null, true);
    }


}