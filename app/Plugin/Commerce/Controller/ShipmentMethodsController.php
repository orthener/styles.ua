<?php

App::uses('CommerceAppController', 'Commerce.Controller');

/**
 * ShipmentMethods Controller
 *
 * @property ShipmentMethod $ShipmentMethod
 */
class ShipmentMethodsController extends CommerceAppController {

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
        $this->ShipmentMethod->recursive = 0;
        $this->set('shipmentMethods', $this->paginate());
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->ShipmentMethod->id = $id;
        if (!$this->ShipmentMethod->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('shipmentMethod', $this->ShipmentMethod->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->ShipmentMethod->create();
            if ($this->ShipmentMethod->save($this->request->data)) {
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
        $this->ShipmentMethod->id = $id;
        if (!$this->ShipmentMethod->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ShipmentMethod->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->request->data = $this->ShipmentMethod->read(null, $id);
        }
    }

    /**
     * Akcja usuwająca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->ShipmentMethod->id = $id;
        if (!$this->ShipmentMethod->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        try {
            if ($this->ShipmentMethod->delete()) {
                $this->Session->setFlash(__d('cms', 'Poprawnie usunięto.'));
                $this->redirect(array('action' => 'index'));
            }
        } catch (PDOException $e) {
            throw new PDOException('Nie można usunąć metody dostawy pownieważ jest powiązana z zamówieniem');
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
        //    $params['conditions']['ShipmentMethod.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->ShipmentMethod->recursive = -1;
        $params['conditions']["ShipmentMethod.name LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->ShipmentMethod->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

}
