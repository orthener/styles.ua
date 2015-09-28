<?php

App::uses('AppController', 'Controller');

/**
 * ProductCategories Controller
 *
 * @property ProductsCategory $ProductsCategory
 */
class ProductsCategoriesController extends AppController {

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
        $this->Auth->allow(array('view', 'front_list', 'front_ajax', 'front_text_list', 'next_products'));
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function index() {
        $this->helpers[] = 'FebTime';
        $this->ProductsCategory->recursive = 0;
        $this->set('productCategories', $this->paginate());
    }

    /**
     * Akcja wyświetlająca listę obiektów - graficznie
     * 
     * @return void
     */
    public function front_list() {
        $this->layout = false;
        $this->helpers[] = 'FebTime';
        $this->ProductsCategory->recursive = 0;
        $params['order'] = 'lft ASC';
//        $params['fields'] = array('slug', 'name');

        $productCategories = $this->ProductsCategory->find('all', $params);
        $this->set('productCategories', $productCategories);
        $this->render();
    }

    /**
     * Akcja wyświetlająca listę obiektów - tekstow
     * 
     * @return void
     */
    public function front_text_list() {
        $this->layout = false;
        $this->helpers[] = 'FebTime';
        $this->ProductsCategory->recursive = 0;
        $params['order'] = 'lft ASC';
//        $params['fields'] = array('slug', 'name');

        $productCategories = $this->ProductsCategory->find('all', $params);
        $this->set('productCategories', $productCategories);
        $this->render();
    }

    function front_ajax($category_slug) {
//        $category_slug = $this->request->data['id'];
        $this->loadModel('StaticProduct.Product');
        $this->Product->locale = Configure::read('Config.languages');
        $this->Product->bindTranslation(array('title' => 'translateDisplay'));
        $this->layout = false;
        $this->Product->recursive = 0;
        if (isset($category_slug)) {
            $id = $this->ProductsCategory->getIdBySlug($category_slug);
        }
        if (!empty($id)) {
            $params['joins'] = array(
                array(
                    'table' => 'products_product_categories',
                    'alias' => 'ProductsProductCategory',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'ProductsProductCategory.product_id = Product.id',
                    )
                )
            );
            $params['group'] = "Product.id";
            $params['conditions']['ProductsProductCategory.product_category_id'] = $id;
        }
        $params['limit'] = 3;
        $params['order'] = 'Product.promoted DESC,RAND()';

        $this->Product->bindPromotion(true);
        $category = $this->ProductsCategory->find('all', array('conditions' => array('ProductsCategory.id' => $id)));
        $products = $this->Product->find('all', $params);

//        debug($products);
        $this->set(compact('products', 'category_slug', 'category'));
        $this->render('Elements/ProductsCategories/popup');
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function view($slug = null) {
        $slug = $this->ProductsCategory->isSlug($slug);

        $sorts = $this->params['named'];
//        debug($sorts);
        if (!$slug) {
            throw new NotFoundException(__('Strona nie istnieje.'));
        }
        if (!empty($slug['error'])) {
            $this->redirect(array($slug['slug']), $slug['error']);
        }
//        $this->ProductsCategory->id = $slug['id'];
        $id = $slug['id'];
        $category_id = $id;
        $this->loadModel('StaticProduct.Product');
        $this->layout = 'default';
        $this->ProductsCategory->id = $id;
        $params = '';
        if (!empty($id)) {
            $params['joins'] = array(
                array(
                    'table' => 'products_product_categories',
                    'alias' => 'ProductsProductCategory',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'ProductsProductCategory.product_id = Product.id',
                    )
                )
            );
        }
                
        $params['group'] = "Product.id";
        $params['conditions']['ProductsProductCategory.product_category_id'] = $id;
        if (!empty($sorts)) {
            $params['order'] = 'Product.'.$sorts['sort'].' '.$sorts['direction'];
        } else {
            $params['order'] = 'Product.title ASC';
        }

        if (!$this->ProductsCategory->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }

        $this->ProductsCategory->recursive = 1;
        $this->Product->recursive = 0; 
        $this->Product->bindPromotion(false);

        $thisCat = $this->ProductsCategory->find('all', array('conditions' => array('ProductsCategory.id' => $id)));
        $thisCategorySlug = $thisCat[0]['ProductsCategory']['slug'];
        
        $org_params = $params;
        $filterData = array();
        if ($this->request->is('post') && !empty($this->request->data)) {
            $this->request->data['category_id'] = $id;
            $filterData = $this->Product->frontFilterParams($this->request->data);
            $params['conditions'] = array_merge($params['conditions'], $filterData);
        }
        
        $productPrice = $this->Product->find('first', array(
            'recursive' => -1,
            'order' => array('Product.price DESC')
        ));
        $price_max = round($productPrice['Product']['price']);     
        $price_from = (!empty($this->request->data['price_from'])) ? $this->request->data['price_from'] : 0;
        $price_to = (!empty($this->request->data['price_to'])) ? $this->request->data['price_to'] : $price_max;
        
        $params['limit'] = $this->Product->productsLimit+1;
        $params['recursive'] = 1; 
       $this->paginate = $params;
       $productCategory = $this->paginate('Product');
        $productCategory = $this->Product->find('all', $params);         
        $org_params['fields'] = array('Product.id', 'Product.id');
        $org_params['conditions']['Product.sized'] = true;
        $productCategoryList = $this->Product->find('list', $org_params);           
        $sizes = $this->Product->getSizes($productCategoryList, true); 
        $this->set('sorts', $sorts);
        $this->set(compact('productCategory', 'params', 'category_id', 'thisCategorySlug', 'filterData', 'thisCat', 'sizes', 'price_max', 'price_from', 'price_to'));
    }

    
    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function admin_index() {
        $this->helpers[] = 'FebTime';
        $this->ProductsCategory->recover();

        $this->ProductsCategory->recursive = 1;
        $this->ProductsCategory->locale = Configure::read('Config.languages');
        $this->ProductsCategory->bindTranslation(array('name' => 'translateDisplay'));
        $tree = $this->ProductsCategory->findTree();

        $this->set(compact('tree'));
        if ($this->request->is('ajax')) {
            $this->render('/Elements/ProductsCategories/table_index');
        }
    }

    function admin_update() {
        if (empty($this->request->data['dest_id']) or empty($this->request->data['id'])) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }

        if (empty($this->data['mode'])) {
            $this->request->data['mode'] = null;
        }

        $valid = $this->ProductsCategory->validateDepth($this->data['id'], $this->data['dest_id'], $this->data['mode']);

        if ($valid === false) {
            $this->Session->setFlash($this->ProductsCategory->validate['depth']['message']);
        }

        if ($valid === true && $this->ProductsCategory->moveNode($this->data['id'], $this->data['dest_id'], $this->data['mode'])) {
            $this->Session->setFlash(__d('public', 'Zmieniono pozycję'));
        }

        $this->render(false);
    }

    public function admin_reload() {
        $this->ProductsCategory->recursive = 1;
        $this->ProductsCategory->locale = Configure::read('Config.languages');
        $this->ProductsCategory->bindTranslation(array('title' => 'translateDisplay'));
        $productCategories = $this->ProductsCategory->findTree();

        $this->set(compact('productCategories'));
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->ProductsCategory->id = $id;
        if (!$this->ProductsCategory->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('productCategory', $this->ProductsCategory->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->ProductsCategory->create();

            $this->request->data['ProductsCategory']['selection_id'] = $this->selection_id;

            if ($this->ProductsCategory->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'add'));
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
        $this->ProductsCategory->id = $id;
        if (!$this->ProductsCategory->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ProductsCategory->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->ProductsCategory->locale = Configure::read('Config.languages');
            $this->request->data = $this->ProductsCategory->read(null, $id);
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
        //    $params['conditions']['ProductsCategory.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->ProductsCategory->recursive = -1;
        $params['conditions']["ProductsCategory.name LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->ProductsCategory->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

    function front() {
        return $this->ProductsCategory->find('all');
    }

}
