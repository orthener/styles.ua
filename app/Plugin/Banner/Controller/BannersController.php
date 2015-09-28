<?php

App::uses('AppController', 'Controller');

/**
 * Banners Controller
 *
 * @property Banner $Banner
 */
class BannersController extends AppController {

    /**
     * Nazwa layoutu
     */
    public $layout = 'admin';

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array('Filter', 'Number');

    /**
     * Tablica komponentów doładowywana do kontrolera
     */
    public $components = array();

    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('view', 'front_list', 'front_ajax', 'front_text_list'));
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function index() {
        $this->helpers[] = 'FebTime';
        $this->Banner->recursive = 0;
        $this->set('banners', $this->paginate());
    }

    /**
     * Akcja wyświetlająca listę obiektów - graficznie
     * 
     * @return void
     */
    public function front_list() {
        $this->layout = false;
        $this->helpers[] = 'FebTime';
        $this->Banner->recursive = 0;
        $params['order'] = 'lft ASC';
//        $params['fields'] = array('slug', 'name');

        $banners = $this->Banner->find('all', $params);
        $this->set('banners', $banners);
        $this->render();
    }


    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function admin_index() {
        $this->helpers[] = 'FebTime';
        $this->Banner->recover();

        $this->Banner->recursive = 1;
        $this->Banner->locale = Configure::read('Config.languages');
        $this->Banner->bindTranslation(array('name' => 'translateDisplay'));
        $tree = $this->Banner->findTree();

        $this->set(compact('tree'));
        if ($this->request->is('ajax')) {
            $this->render('/Elements/Banners/table_index');
        }
    }

    function admin_update() {
        if (empty($this->request->data['dest_id']) or empty($this->request->data['id'])) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }

        if (empty($this->data['mode'])) {
            $this->request->data['mode'] = null;
        }

        $valid = $this->Banner->validateDepth($this->data['id'], $this->data['dest_id'], $this->data['mode']);

        if ($valid === false) {
            $this->Session->setFlash($this->Banner->validate['depth']['message']);
        }

        if ($valid === true && $this->Banner->moveNode($this->data['id'], $this->data['dest_id'], $this->data['mode'])) {
            $this->Session->setFlash(__d('public', 'Zmieniono pozycję'));
        }

        $this->render(false);
    }

    public function admin_reload() {
        $this->Banner->recursive = 1;
        $this->Banner->locale = Configure::read('Config.languages');
        $this->Banner->bindTranslation(array('title' => 'translateDisplay'));
        $banners = $this->Banner->findTree();

        $this->set(compact('banners'));
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->Banner->id = $id;
        if (!$this->Banner->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('banner', $this->Banner->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Banner->create();
            //$this->request->data['Banner']['selection_id'] = $this->selection_id;
            if ($this->Banner->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Banner->id = $id;
        if (!$this->Banner->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Banner->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->Banner->locale = Configure::read('Config.languages');
            $this->request->data = $this->Banner->read(null, $id);
        }
    }

    /**
     * Akcja usuwająca obiekt
     *
     * @param string $id
     * @return void
     */
    function admin_delete($id = null, $all = null) {
        $this->FebI18n->delete($id, $all);
        $this->redirect(array('action' => 'index'), null, true);
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
        $params['fields'] = array('name');

        //Dodatkowe dane przekazywane z FebFormHelper-a
        //if (!empty($this->request->data['fields']['field_name'])) {
        //    $params['conditions']['Banner.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->Banner->recursive = -1;
        $params['conditions']["Banner.name LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->Banner->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

    function front() {
        return $this->Banner->find('all');
    }

}
