<?php
App::uses('AppController', 'Controller');
/**
 * PromotionCodes Controller
 *
 * @property PromotionCode $PromotionCode
 */
class PromotionCodesController extends AppController {

    
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
		$this->PromotionCode->recursive = 0;
		$this->set('promotionCodes', $this->paginate());
	}

    /**
    * Akcja podglądu obiektu
    *
    * @param string $id
    * @return void
    */
	public function view($id = null) {
//        $slug = $this->PromotionCode->isSlug($slug);
//        if (!$slug) {
//            throw new NotFoundException(__('Strona nie istnieje.'));
//        }
//        if (!empty($slug['error'])) {
//            $this->redirect(array($slug['slug']), $slug['error']);
//        }
//        $this->PromotionCode->id = $slug['id'];
    
		$this->PromotionCode->id = $id;
		if (!$this->PromotionCode->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		$this->set('promotionCode', $this->PromotionCode->read(null, $id));
	}

    /**
    * Akcja dodająca obiekt
    *
    * @return void
    */
	public function add() {
		if ($this->request->is('post')) {
			$this->PromotionCode->create();
			if ($this->PromotionCode->save($this->request->data)) {
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
		$this->PromotionCode->id = $id;
		if (!$this->PromotionCode->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PromotionCode->save($this->request->data)) {
                $this->Session->setFlash(__d('public', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__d('public', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->PromotionCode->read(null, $id);
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
		$this->PromotionCode->id = $id;
		if (!$this->PromotionCode->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->PromotionCode->delete()) {
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
		$this->PromotionCode->recursive = 0;
		$this->set('promotionCodes', $this->paginate());
	}

    /**
    * Akcja podglądu obiektu
    *
    * @param string $id
    * @return void
    */
	public function admin_view($id = null) {
    
		$this->PromotionCode->id = $id;
		if (!$this->PromotionCode->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		$this->set('promotionCode', $this->PromotionCode->read(null, $id));
	}

    /**
    * Akcja dodająca obiekt
    *
    * @return void
    */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->PromotionCode->create();

			if ($this->PromotionCode->save($this->request->data)) {
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
		$this->PromotionCode->id = $id;
		if (!$this->PromotionCode->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PromotionCode->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->PromotionCode->read(null, $id);
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
		$this->PromotionCode->id = $id;
		if (!$this->PromotionCode->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->PromotionCode->delete()) {
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
        $params['fields'] = array('code');

        //Dodatkowe dane przekazywane z FebFormHelper-a
        //if (!empty($this->request->data['fields']['field_name'])) {
        //    $params['conditions']['PromotionCode.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->PromotionCode->recursive = -1;
        $params['conditions']["PromotionCode.code LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->PromotionCode->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }


}
