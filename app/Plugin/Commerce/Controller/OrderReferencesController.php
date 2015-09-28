<?php
App::uses('AppController', 'Controller');
/**
 * OrderReferences Controller
 *
 * @property OrderReference $OrderReference
 */
class OrderReferencesController extends AppController {

    
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
	public function index() {
        $this->helpers[] = 'FebTime';
		$this->OrderReference->recursive = 0;
		$this->set('orderReferences', $this->paginate());
	}

    /**
    * Akcja podglądu obiektu
    *
    * @param string $id
    * @return void
    */
	public function view($id = null) {
//        $slug = $this->OrderReference->isSlug($slug);
//        if (!$slug) {
//            throw new NotFoundException(__('Strona nie istnieje.'));
//        }
//        if (!empty($slug['error'])) {
//            $this->redirect(array($slug['slug']), $slug['error']);
//        }
//        $this->OrderReference->id = $slug['id'];
    
		$this->OrderReference->id = $id;
		if (!$this->OrderReference->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		$this->set('orderReference', $this->OrderReference->read(null, $id));
	}

    /**
    * Akcja dodająca obiekt
    *
    * @return void
    */
	public function add() {
		if ($this->request->is('post')) {
			$this->OrderReference->create();
			if ($this->OrderReference->save($this->request->data)) {
                $this->Session->setFlash(__d('public', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('public', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
		}
	}

    /**
    * Akcja edytująca obiekt
    *
    * @param string $id
    * @return void
    */
	public function edit($id = null) {
		$this->OrderReference->id = $id;
		if (!$this->OrderReference->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OrderReference->save($this->request->data)) {
                $this->Session->setFlash(__d('public', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__d('public', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->OrderReference->read(null, $id);
		}
	}

    /**
    * Akcja usuwająca obiekt
    *
    * @param string $id
    * @return void
    */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->OrderReference->id = $id;
		if (!$this->OrderReference->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->OrderReference->delete()) {
			$this->Session->setFlash(__d('public', 'Poprawnie usunięto.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__d('public', 'Nie można usunąć.'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
        /**
    * Akcja wyświetlająca listę obiektów
    * 
    * @return void
    */
	public function admin_index() {
        $this->helpers[] = 'FebTime';
		$this->OrderReference->recursive = 0;
		$this->set('orderReferences', $this->paginate());
	}

    /**
    * Akcja podglądu obiektu
    *
    * @param string $id
    * @return void
    */
	public function admin_view($id = null) {
    
		$this->OrderReference->id = $id;
		if (!$this->OrderReference->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		$this->set('orderReference', $this->OrderReference->read(null, $id));
	}

    /**
    * Akcja dodająca obiekt
    *
    * @return void
    */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->OrderReference->create();
			if ($this->OrderReference->save($this->request->data)) {
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
		$this->OrderReference->id = $id;
		if (!$this->OrderReference->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OrderReference->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->OrderReference->read(null, $id);
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
		$this->OrderReference->id = $id;
		if (!$this->OrderReference->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->OrderReference->delete()) {
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
        //    $params['conditions']['OrderReference.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->OrderReference->recursive = -1;
        $params['conditions']["OrderReference.name LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->OrderReference->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }


}
