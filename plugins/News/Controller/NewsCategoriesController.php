<?php
App::uses('AppController', 'Controller');
/**
 * NewsCategories Controller
 *
 * @property NewsCategory $NewsCategory
 */
class NewsCategoriesController extends AppController {

    
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
        $this->Auth->allow(array('setup_slug'));
    }

    /**
    * Akcja wyświetlająca listę obiektów
    * 
    * @return void
    */
	public function index() {
        $this->helpers[] = 'FebTime';
            		$this->NewsCategory->recursive = 0;
        		$this->set('newsCategories', $this->paginate());
	}

    /**
    * Akcja podglądu obiektu
    *
    * @param string $id
    * @return void
    */
	public function view($id = null) {
//        $slug = $this->NewsCategory->isSlug($slug);
//        if (!$slug) {
//            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
//        }
//        if (!empty($slug['error'])) {
//            $this->redirect(array($slug['slug']), $slug['error']);
//        }
//        $this->NewsCategory->id = $slug['id'];
    
		$this->NewsCategory->id = $id;
		if (!$this->NewsCategory->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		$this->set('newsCategory', $this->NewsCategory->read(null, $id));
	}

    /**
    * Akcja dodająca obiekt
    *
    * @return void
    */
	public function add() {
		if ($this->request->is('post')) {
			$this->NewsCategory->create();
			if ($this->NewsCategory->save($this->request->data)) {
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
	public function edit($id = null) {
		$this->NewsCategory->id = $id;
		if (!$this->NewsCategory->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->NewsCategory->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
			}
		} else {
			$this->request->data = $this->NewsCategory->read(null, $id);
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
		$this->NewsCategory->id = $id;
		if (!$this->NewsCategory->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->NewsCategory->delete()) {
			$this->Session->setFlash(__d('cms', 'Poprawnie usunięto.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__d('cms', 'Nie można usunąć.'), 'flash/error');
		$this->redirect(array('action' => 'index'));
	}
    /**
    * Akcja wyświetlająca listę obiektów
    * 
    * @return void
    */
	public function admin_index() {
        $this->helpers[] = 'FebTime';
                	$this->NewsCategory->recursive = 1;
            $this->NewsCategory->locale = Configure::read('Config.languages');
            $this->NewsCategory->bindTranslation(array($this->NewsCategory->displayField => 'translateDisplay'));
        		$this->set('newsCategories', $this->paginate());
	}

    /**
    * Akcja podglądu obiektu
    *
    * @param string $id
    * @return void
    */
	public function admin_view($id = null) {
    
		$this->NewsCategory->id = $id;
		if (!$this->NewsCategory->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		$this->set('newsCategory', $this->NewsCategory->read(null, $id));
	}

    /**
    * Akcja dodająca obiekt
    *
    * @return void
    */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->NewsCategory->create();
			if ($this->NewsCategory->save($this->request->data)) {
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
		$this->NewsCategory->id = $id;
		if (!$this->NewsCategory->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->NewsCategory->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
			}
		} else {
            $this->NewsCategory->locale = Configure::read('Config.languages');
			$this->request->data = $this->NewsCategory->read(null, $id);
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
        //    $params['conditions']['NewsCategory.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->NewsCategory->recursive = -1;
        $params['conditions']["NewsCategory.name LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->NewsCategory->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

    public function front_text_list() {
        $this->layout = false;
        $this->helpers[] = 'FebTime';
        $this->NewsCategory->recursive = 0;
        $params['order'] = 'lft ASC';
//        $params['fields'] = array('slug', 'name');

        $newsCategories = $this->NewsCategory->find('all', $params);
        $this->set('newsCategories', $newsCategories);
        $this->render();
    }
    
    /**
     * Funckcja konwertuje wszystkie slugi w modelu News z cyrylicy na polskie znaki
     */
    public function setup_slug() {
        $newsCategories = $this->NewsCategory->find('all', array('recursive' => 0));
        //debug($newsCategories);
        $ok = 0;
        $fail = 0;
           
        foreach ($newsCategories as $newsCategory) {
            //debug($newsCategory);
            $newsCategory['NewsCategory']['slug'] = '';
            $newsCategory_id = $newsCategory['NewsCategory']['id'];
            
            $this->NewsCategory->id = $newsCategory_id;
            
            if($this->NewsCategory->save($newsCategory)) {
                $ok++;
            } else {
                $fail++;
            }
            echo 'ok:' . $ok . ' fail:' . $fail . '<br/>';
        }
        $this->render(false);        
    }

}
