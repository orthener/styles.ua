<?php

App::uses('AppController', 'Controller');

/**
 * Brands Controller
 *
 * @property Brand $Brand
 */
class BrandsController extends AppController {
    /**
     * Nazwa layoutu
     */
    public $layout = 'admin';

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array('FebTinyMce4');

    /**
     * Tablica komponentów doładowywana do kontrolera
     */
    public $components = array('Slug.Slug'); //Slug.Slug

    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('index', 'view', 'brands_front'));
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function index() {
        $this->layout = 'default';

        $this->Brand->recursive = 0;

        $brands = $this->Brand->find('all');

        $this->set('brands', $brands);
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->layout = 'default';
        $this->loadModel('StaticProduct.Product');

        $sorts = $this->params['named'];

        $id = $this->Slug->basic($id);
        $this->Brand->id = $id;
        if (!$this->Brand->exists()) {
            throw new NotFoundException(__('Invalid brand'));
        }
//        if (!empty($sorts)) {
//            $params['order'] = 'Product.' . $sorts['sort'] . ' ' . $sorts['direction'];
//        } else {
//            $params['order'] = 'Product.title ASC';
//        }
        $search_params = array();
        if (!empty($this->request->data['Search']['text'])) {
            $words = explode(' ', $this->request->data['Search']['text']);
            $search_params = $this->Product->search($words);
        }
        if ($this->referer() != "/") {
            $this->set('brand_filter', true);
        }
        $filterData = array();
        if ($this->request->is('post') && !empty($this->request->data)) {
            $filterData = $this->Product->frontFilterParams($this->request->data);  
        }   
        $search_params['conditions']['brand_id'] = $id;
        $productIds = $this->Product->find('list', array(
            'conditions' => $search_params['conditions'],
            'fields' => array('Product.id', 'Product.id')
        ));
        $sizes = $this->Product->getSizes($productIds); 
        
        $productPrice = $this->Product->find('first', array(
            'recursive' => -1,
            'order' => array('Product.price DESC')
        ));
        $price_max = round($productPrice['Product']['price']);     
        $price_from = (!empty($this->request->data['price_from'])) ? $this->request->data['price_from'] : 0;
        $price_to = (!empty($this->request->data['price_to'])) ? $this->request->data['price_to'] : $price_max;

        $this->set(compact('filterData', 'sizes','price_max', 'price_from', 'price_to'));
        $this->set('sorts', $sorts);
        $this->set('brand', $this->Brand->read(null, $id));
        $this->set('brand_all', $this->Brand->find('all'));
    }

    public function brands_front($limit = 8, $offset = 0) {
        $this->layout = 'default';

        $brands = $this->Brand->find('all', array('limit' => $limit, 'offset' => $offset));
        $this->set('brands', $brands);
        if (empty($this->request->params['requested'])) {
            throw new ForbiddenException();
        } else {
            return $this->render();
        }
            $this->set("referer_request", "aadddd");
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Brand->create();
            if ($this->Brand->save($this->request->data)) {
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
        $this->Brand->id = $id;
        if (!$this->Brand->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Brand->save($this->request->data)) {
                $this->Session->setFlash(__d('public', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('public', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        } else {
            $this->request->data = $this->Brand->read(null, $id);
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
        $this->Brand->id = $id;
        if (!$this->Brand->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->Brand->delete()) {
            $this->Session->setFlash(__d('public', 'Poprawnie usunięto.'));
            $this->redirect(array('action' => 'index'));
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
        $this->Brand->recursive = 1;
        $this->Brand->locale = Configure::read('Config.languages');
        $this->Brand->bindTranslation(array($this->Brand->displayField => 'translateDisplay'));
        $this->set('brands', $this->paginate());
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->Brand->id = $id;
        if (!$this->Brand->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('brand', $this->Brand->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Brand->create();
            if ($this->Brand->save($this->request->data)) {
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
        $this->Brand->id = $id;
        if (!$this->Brand->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Brand->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        } else {
            $this->Brand->locale = Configure::read('Config.languages');
            $this->request->data = $this->Brand->read(null, $id);
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
        //    $params['conditions']['Brand.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->Brand->recursive = -1;
        $params['conditions']["Brand.name LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->Brand->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

}
