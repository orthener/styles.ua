<?php

App::uses('CommerceAppController', 'Commerce.Controller');

/**
 * OrderStatuses Controller
 *
 * @property OrderStatus $OrderStatus
 */
class OrderStatusesController extends CommerceAppController {

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
    public $components = array();
    
    

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
        $this->OrderStatus->recursive = 0;
        $this->set('orderStatuses', $this->paginate());
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->OrderStatus->id = $id;
        if (!$this->OrderStatus->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('orderStatus', $this->OrderStatus->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->OrderStatus->create();
            if ($this->OrderStatus->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
        $this->set('statusGroup', $this->OrderStatus->statusGroup);
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->OrderStatus->id = $id;
        if (!$this->OrderStatus->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->OrderStatus->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->request->data = $this->OrderStatus->read(null, $id);
        }
        $this->set('statusGroup', $this->OrderStatus->statusGroup);
    }

    /**
     * Akcja usuwająca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $status = $this->OrderStatus->read(null, $id);
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->OrderStatus->id = $id;
        if (!$this->OrderStatus->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($status['OrderStatus']['blocked'] == 0) {
            if ($this->OrderStatus->delete()) {
                $this->Session->setFlash(__d('cms', 'Poprawnie usunięto.'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $this->Session->setFlash(__d('cms', 'Nie można usunąć.'), 'flash/error');
        $this->redirect(array('action' => 'index'));
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
        //    $params['conditions']['OrderStatus.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->OrderStatus->recursive = -1;
        $params['conditions']["OrderStatus.name LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->OrderStatus->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

}
