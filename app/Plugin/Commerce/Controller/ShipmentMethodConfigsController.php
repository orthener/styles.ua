<?php

App::uses('CommerceAppController', 'Commerce.Controller');

/**
 * ShipmentMethodConfigs Controller
 *
 * @property ShipmentMethodConfig $ShipmentMethodConfig
 */
class ShipmentMethodConfigsController extends CommerceAppController {

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
        $this->ShipmentMethodConfig->recursive = 0;
        $this->set('shipmentMethodConfigs', $this->paginate());
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->ShipmentMethodConfig->id = $id;
        if (!$this->ShipmentMethodConfig->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('shipmentMethodConfig', $this->ShipmentMethodConfig->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        $this->loadModel('Commerce.Order');
        if ($this->request->is('post')) {
            $this->ShipmentMethodConfig->create();
            if ($this->ShipmentMethodConfig->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
        $taxRates = $this->Order->taxRates;
        $shipmentMethods = $this->ShipmentMethodConfig->ShipmentMethod->find('list');
        $this->set(compact('shipmentMethods', 'taxRates'));
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->loadModel('Commerce.Order');
        $this->ShipmentMethodConfig->id = $id;
        if (!$this->ShipmentMethodConfig->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ShipmentMethodConfig->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->request->data = $this->ShipmentMethodConfig->read(null, $id);
        }
        $taxRates = $this->Order->taxRates;
        
        $shipmentMethods = $this->ShipmentMethodConfig->ShipmentMethod->find('list');
        $this->set(compact('shipmentMethods', 'taxRates'));
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
        $this->ShipmentMethodConfig->id = $id;
        if (!$this->ShipmentMethodConfig->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->ShipmentMethodConfig->delete()) {
            $this->Session->setFlash(__d('cms', 'Poprawnie usunięto.'));
            $this->redirect(array('action' => 'index'));
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
        $params['fields'] = array('price');

        //Dodatkowe dane przekazywane z FebFormHelper-a
        //if (!empty($this->request->data['fields']['field_name'])) {
        //    $params['conditions']['ShipmentMethodConfig.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->ShipmentMethodConfig->recursive = -1;
        $params['conditions']["ShipmentMethodConfig.price LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->ShipmentMethodConfig->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

}
