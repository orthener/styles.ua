<?php

App::uses('AppController', 'Controller');

/**
 * InfoCategories Controller
 *
 * @property InfoCategory $InfoCategory
 */
class InfoCategoriesController extends AppController {

    /**
     * Nazwa layoutu
     */
    public $layout = 'admin';

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array();

    /**
     * Tablica komponentów doładowywana do kontrolera
     */
    public $components = array(); //Slug.Slug

    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function admin_index() {
        $this->helpers[] = 'FebTime';
        $this->InfoCategory->recursive = 1;
        $this->InfoCategory->locale = Configure::read('Config.languages');
        $this->InfoCategory->bindTranslation(array($this->InfoCategory->displayField => 'translateDisplay'));
        $params['conditions']['InfoCategory.selection_id'] = $this->selection_id;
        $this->paginate = $params;
        $this->set('infoCategories', $this->paginate());
    }
    
    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->InfoCategory->id = $id;
        if (!$this->InfoCategory->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('infoCategory', $this->InfoCategory->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->InfoCategory->create();
            $this->request->data['InfoCategory']['selection_id'] = $this->selection_id;
            if ($this->InfoCategory->save($this->request->data)) {
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
        $this->InfoCategory->id = $id;
        if (!$this->InfoCategory->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['InfoCategory']['selection_id'] = $this->selection_id;
            if ($this->InfoCategory->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        } else {
            $this->InfoCategory->locale = Configure::read('Config.languages');
            $this->request->data = $this->InfoCategory->read(null, $id);
        }
    }

    /**
     * Akcja usuwająca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null, $all = null) {
        $this->FebI18n->delete($id, $all);
        $this->redirect(array('action' => 'index'), null, true);
    }

}
