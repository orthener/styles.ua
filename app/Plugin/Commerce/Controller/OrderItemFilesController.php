<?php
App::uses('CommerceAppController', 'Commerce.Controller');
/**
 * OrderItemFiles Controller
 *
 * @property OrderItemFile $OrderItemFile
 */
class OrderItemFilesController extends CommerceAppController {

    
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
		$this->OrderItemFile->recursive = 0;
		$this->set('orderItemFiles', $this->paginate());
	}

    /**
    * Akcja podglądu obiektu
    *
    * @param string $id
    * @return void
    */
	public function admin_view($id = null) {
    
		$this->OrderItemFile->id = $id;
		if (!$this->OrderItemFile->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		$this->set('orderItemFile', $this->OrderItemFile->read(null, $id));
	}

    /**
    * Akcja dodająca obiekt
    *
    * @return void
    */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->OrderItemFile->create();
			if ($this->OrderItemFile->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
		}
		$orderItems = $this->OrderItemFile->OrderItem->find('list');
		$this->set(compact('orderItems'));
	}

    /**
    * Akcja edytująca obiekt
    *
    * @param string $id
    * @return void
    */
	public function admin_edit($id = null) {
		$this->OrderItemFile->id = $id;
		if (!$this->OrderItemFile->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OrderItemFile->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
			}
		} else {
			$this->request->data = $this->OrderItemFile->read(null, $id);
		}
		$orderItems = $this->OrderItemFile->OrderItem->find('list');
		$this->set(compact('orderItems'));
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
		$this->OrderItemFile->id = $id;
		if (!$this->OrderItemFile->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->OrderItemFile->delete()) {
			$this->Session->setFlash(__d('cms', 'Poprawnie usunięto.'));
			$this->redirect(array('action'=>'index'));
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
        //    $params['conditions']['OrderItemFile.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->OrderItemFile->recursive = -1;
        $params['conditions']["OrderItemFile.name LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->OrderItemFile->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }


}
