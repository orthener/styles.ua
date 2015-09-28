<?php

App::uses('AppController', 'Controller');
App::uses('QqFileUploader', 'Lib');

/**
 * Photos Controller
 *
 * @property Photo $Photo
 */
class PhotosController extends AppController {

    /**
     * Nazwa layoutu
     */
    public $layout = 'admin';

    /**
     *
     */
    public $helpers = array();

    /**
     * 
     */
    public $components = array();

    /**
     * 
     * @access public 
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
    }

    /**
     * 
     * 
     * @return void
     */
    public function index() {
        $this->helpers[] = 'FebTime';
        $this->Photo->recursive = 0;
        $this->set('photos', $this->paginate());
    }

    /**
     * 
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
//        $slug = $this->Photo->isSlug($slug);
//        if (!$slug) {
//            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
//        }
//        if (!empty($slug['error'])) {
//            $this->redirect(array($slug['slug']), $slug['error']);
//        }
//        $this->Photo->id = $slug['id'];

        $this->Photo->id = $id;
        if (!$this->Photo->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('photo', $this->Photo->read(null, $id));
    }

    public function upload($model = null, $remote_id = null) {
        $this->layout = 'ajax';
        $allowedExtensions = array('jpg', 'png', 'gif', 'jpeg');
        $sizeLimit = 3300000;
//        debug($model);
//        debug($remote_id);
//        exit;
        try {
            $uploader = new QqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload('/files/photo/');

            $id = Inflector::underscore($model);

            $toSave['Photo']['img'] = $result['filename'];
            $toSave['Photo'][$id . '_id'] = $remote_id;

            $this->Photo->create();
            $this->Photo->save($toSave);

            $result['id'] = $this->Photo->getLastInsertID();

            if (!empty($this->Photo->$model)) {
                $this->Photo->$model->id = $remote_id;
                if ($this->Photo->$model->field("photo_id") == "") {
                    $this->Photo->$model->saveField("photo_id", $result['id']);
                }
            }
        } catch (Exception $e) {
            $result['error'] = __d('cms', 'Nie można wysłać pliku');
        }

        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        $this->render(false);
    }

    /**
     * Akcja ustawia zdjęcie jako główne
     * Uwaga! Wymaga pola photo_id w głównej tabeli
     */
    public function admin_set_parent() {
        $this->layout = 'ajax';
        
        $this->loadModel($this->request->data['model']);
        $model = Inflector::classify($this->request->data['model']);
        
        $tmpModel = explode('.', $model);
              
        $plugin = '';
        
         if (isSet($tmpModel[1])) {
             $targetModel = $model;
             $model = $tmpModel[1];
             $plugin = $tmpModel[0];
         } else {
             $targetModel = $model;
         }

        try {
            $this->$model->{$this->$model->primaryKey} = $this->request->data['remote_id'];
            $this->$model->saveField('photo_id', $this->request->data['id']);
        } catch (Exception $exc) {}
        $this->render(false); 
    }

    public function admin_set_title() {
        $this->layout = 'ajax';
        $model = $this->request->data['model'];
        $this->Photo->$model->id = $this->request->data['remote_id'];
        $this->Photo->$model->saveField('photo_id', $this->request->data['id']);
        $this->render(false);
    }

    /**
     * Akcja edytująca tytuł zdjęcia
     * 
     * @param mixed $id 
     */
    public function admin_get_title($id = null) {
        $this->layout = 'ajax';
        $this->Photo->id = $id;
        if (!empty($this->request->data)) {
            if ($this->Photo->saveField('title', $this->request->data['Photo']['title'])) {
                $this->set('flash', __d('cms', 'Błąd podczas zapisu tytułu'), 'flash/error');
            } else {
                $this->set('flash', __d('cms', 'Błąd podczas zapisu tytułu'), 'flash/error');
            }
            $this->render(false);
        } else {
            $this->request->data['Photo']['id'] = $id;
            $this->request->data['Photo']['title'] = $this->Photo->field('title');
        }
    }

    /**
     * Akcja edytująca tytuł zdjęcia
     * 
     * @param mixed $id 
     */
    public function admin_sort() {
        $this->layout = 'ajax';

        $model = $this->request->data['model'];
        $remote_id = $this->request->data['remote_id'];


        $modelId = Inflector::underscore($model);
        $conditions['Photo.' . $modelId . '_id'] = $this->request->data['remote_id'];

        $reLocate = $this->request->data['reLocate'];
        $order = 0;

        foreach ($reLocate as $photoId) {
            $conditions['Photo.id'] = $photoId;
            $this->Photo->updateAll(array('order' => $order), $conditions);
            $order++;
        }
        $this->render(false);
    }

    /**
     * 
     * 
     * @return void
     */
    public function admin_index($model = null, $remote_id = null) {
        $this->helpers[] = 'FebTime';

        $this->loadModel($model);
        $model = Inflector::classify($model);
        
        $tmpModel = explode('.', $model);
              
        $plugin = '';
        
         if (isSet($tmpModel[1])) {
             $targetModel = $model;
             $model = $tmpModel[1];
             $plugin = $tmpModel[0];
         } else {
             $targetModel = $model;
         }
        
        $this->$model->{$this->$model->primaryKey} = $remote_id;
        

        if (!$this->$model->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        
        
        $this->Photo->recursive = 0;
        $params = array();
        $modelId = Inflector::underscore($model);    
        
        $params['conditions']['Photo.'.$modelId.'_id'] = $remote_id;
        
        $photos = $this->Photo->find('all', $params);

        $this->set(compact('photos', 'remote_id', 'model', 'isParentPhotoOption', 'targetModel', 'plugin'));
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $model = $this->request->data['model'];
        $remote_id = $this->request->data['remote_id'];
        $modelId = Inflector::underscore($model);
        $params['conditions']['Photo.' . $modelId . '_id'] = $this->request->data['remote_id'];
        $params['conditions']['Photo.id'] = $id;
        $photo = $this->Photo->find('first', array('conditions' => array('Photo.id' => $id)));
        $this->set(compact('photo', 'model', 'remote_id'));
    }

    /**
     * 
     *
     * @return void
     */
    public function admin_add() {
        $this->Photo->recursive = -1;
        if ($this->request->is('post')) {
            $this->Photo->create();
            if ($this->Photo->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
    }

    /**
     * 
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Photo->recursive = -1;
        $this->Photo->id = $id;
        if (!$this->Photo->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Photo->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->request->data = $this->Photo->read(null, $id);
        }
    }

    /**
     * 
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $this->Photo->tmpModel = $this->request->data['model'];
        $this->Photo->tmpPlugin = $this->request->data['plugin'];
        $this->Photo->tmpRemoteId = $this->request->data['remote_id'];
        $this->Photo->tmpTargetModel = $this->request->data['targetModel'];


        $this->Photo->id = $id;
        if (!$this->Photo->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }

        $this->Photo->delete();
        $this->render(false);
    }

    /**
     * Akcja do podpowiadaina danych z formularza
     * 
     * @param type $term
     * @throws MethodNotAllowedException 
     */
    function admin_autocomplete($term = null) {
        $this->layout = 'ajax';
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $params = array();
        $params['fields'] = array('title');

        //Dodatkowe dane przekazywane z FebFormHelper-a
        //if (!empty($this->request->data['fields']['field_name'])) {
        //    $params['conditions']['Photo.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->Photo->recursive = -1;
        $params['conditions']["Photo.title LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->Photo->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

}
