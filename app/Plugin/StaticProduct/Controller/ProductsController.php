<?php

App::uses('AppController', 'Controller');

/**
 * Products Controller
 *
 * @property Product $Product
 */
class ProductsController extends AppController {

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array('Filter', 'Number', 'FebTinyMce4', 'FebNumber');

    /**
     * Tablica komponentów doładowywana do kontrolera
     */
    public $components = array('Filtering', 'Cookie', 'Commerce.Commerce');

    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('front', 'next_products', 'index', 'view', 'rating', 'search', 'front_filter'));
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function index($slug = null) {
        $this->layout = 'default';
        $this->request->data['Search']['text'] = '/';
        $this->search();
        
//        $filterData = array();
//        if ($this->request->is('post') && !empty($this->request->data)) {
//            $filterData = $this->Product->frontFilterParams($this->request->data);  
//        }   
//        $productIds = $this->Product->find('list', array(
////            'conditions' => array('Product.brand_id' => $id),
//            'fields' => array('Product.id', 'Product.id')
//        ));
//        $sizes = $this->Product->getSizes($productIds); 
//        
//        $productPrice = $this->Product->find('first', array(
//            'recursive' => -1,
//            'order' => array('Product.price DESC')
//        ));
//        $price_max = round($productPrice['Product']['price']);     
//        $price_from = (!empty($this->request->data['price_from'])) ? $this->request->data['price_from'] : 0;
//        $price_to = (!empty($this->request->data['price_to'])) ? $this->request->data['price_to'] : $price_max;
//
//        $this->set(compact('filterData', 'sizes','price_max', 'price_from', 'price_to'));
    }

    
    public function front($brand = null) {
        $this->layout = false;
        $this->Product->locale = Configure::read('Config.languages');
        $this->Product->bindTranslation(array('title' => 'translateDisplay'));
        $this->Product->recursive = 0;
//        $limit = 24;
//        if (!empty($limit)) {
//            $params['limit'] = $limit;
//        }
//        $params['order'] = 'Product.created DESC, RAND()';
        $sorts = $this->params['named'];

        $params['order'] = 'Product.title ASC';
        if (!empty($sorts['sort']) && !empty($sorts['direction'])) {
            $params['order'] = 'Product.' . $sorts['sort'] . ' ' . $sorts['direction'];
        } else {
            $params['order'] = 'Product.title ASC';
        }
        $this->Product->bindPromotion(true);
        if (!empty($brand)) {
            $params['conditions'] = array('Product.brand_id' => $brand);
        }

        if (!empty($this->params['named']['filterData']) && !empty($params['conditions'])) {
            $filterData = unserialize($this->params['named']['filterData']);
            $params['conditions'] = array_merge($params['conditions'], $filterData);
        }
        
        $this->Product->bindPromotion();
   //     $products = $this->Product->find('all', $params);
        
        if (!empty($this->params['named']['page'])) {
            $params['limit'] = $this->Product->productsLimitAjax;
        }
        else {
            $params['limit'] = $this->Product->productsLimit;   
        }
        $params['recursive'] = 1;
        $this->paginate = $params;

        $products = $this->paginate();
        
        $params['limit'] = $this->Product->productsLimitAjax+1;   
        $isMoreThanPage = $this->Product->find('list', $params);
        if (count($isMoreThanPage) > $this->Product->productsLimit) {
            $this->set('moreThanPage', true);
        }
        
        $this->set(compact('products', 'brand'));
        $this->render();
    }

    public function front_filter($filter = null, $category_id = null, $text_name = null) {
        $this->layout = false;
        $this->Product->locale = Configure::read('Config.languages');
        $this->Product->bindTranslation(array('title' => 'translateDisplay'));
        $this->Product->recursive = 1;
        
        $params['order'] = 'Product.created DESC, RAND()';
        $params['limit'] = 24;

//        if (!empty($text_name)) {
//            $this->request->data['Product']['title'] = $text_name;
//        }
        
        $this->Product->bindPromotion(true);
        $params['conditions']['Product.price >'] = 0;
        if (!empty($filter)) {
            if($filter == 'popular') {
                $params['order'] = 'Product.hit_counter DESC';
            } elseif($filter == 'promoted') {
                $params['order'] = 'Product.created DESC';
//            } elseif($filter == 'sale') {
//                $params['conditions'] = array('Product.' . $filter => 1);
            } else {
                $params['order'] = 'Product.price ASC';
            }
            
            if (!empty($category_id)) {
                $params['joins'][] = array(
                    'table' => 'products_product_categories',
                    'alias' => 'ProductProductsCategory',
                    'type' => 'INNER',
                    'conditions' => array(
                        "ProductProductsCategory.product_category_id = {$category_id}",
                        'ProductProductsCategory.product_id = Product.id',
                    )
                );
            }
        }        
        if (!empty($this->params['named']['filterData'])) {
            $filterData = unserialize($this->params['named']['filterData']);
            $params['conditions'] = array_merge($params['conditions'], $filterData);
        }
        
        if (!empty($text_name)) {
            if (strlen(trim($text_name)) != 0) {
                $words = explode(' ', $text_name);
                $params = $this->Product->search($words);
            }
        }
        
        $this->Product->bindPromotion();
//       $products = $this->Product->find('all', $params);
        $params['limit'] = $this->Product->productsLimitAjax;
        $this->paginate = $params;
        $products = $this->paginate();
        $this->set(compact('products'));
        $this->render('front');
    }
    
    public function view($slug = null) {
        $this->helpers[] = 'Fancybox.Fancybox';
        $slug = $this->Product->isSlug($slug);
        $id = $slug['id'];
        //debug($id);
        
        if (!$slug) {
            throw new NotFoundException(__('Invalid localization'));
        }
        if (!empty($slug['error'])) {
            $this->redirect(array($slug['slug']), $slug['error']);
        }
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->Product->bindPromotion();
        $product = $this->Product->read(null, $id);
        $this->Product->saveField('hit_counter', $product['Product']['hit_counter'] + 1);
        
//        // Stary system rozmiarów
//        $sizes = $this->Product->find('list', array('fields' => array('Product.id', 'Product.size'), 'conditions' => array('Product.id' => $id)));
//        $new_sizes = explode('|', $sizes[$id]);
//        $this->set('sizes', $new_sizes);
        
        // Nowy system rozmiarow
        $sizes = $this->Product->getSizes($product['Product']['id']);
        $sizes_quantity = $this->Product->getSizesQuantity($product['Product']['id']);
        $this->set(compact('sizes', 'sizes_quantity'));
        
        $this->Product->recursive = 1;
        $this->Product->bindPromotion(false);
        $this->Product->Behaviors->attach('Containable');
        $this->Product->contain(array('Photo', 'Photos', 'ProductsCategory', 'ProductsPromotion', 'Brand'));
        $product = $this->Product->read(null, $id);
        $accessories = $this->Product->getAccesories($product['Product']['id']);
        $simiarProducts = $this->Product->getSimilarProduct($product['Product']['id']);
        //Uznaję, że pierwszy z brzegu to poprawny
        $activeProductsCategory = @$product['ProductsCategory'][0]['id'];

        foreach($simiarProducts as $simProduct) {
            if (!empty($simProduct['ProductsCategory'][0])) {
                $category_id = $this->Product->ProductsCategory->find('first', array(
                    'conditions' => array('ProductsCategory.id' => $simProduct['ProductsCategory'][0]['id']),
                    'order' => array('RAND()')
                ));
                break;
            }
        }
        if (!empty($category_id)) {
            $this->set('category_id', $category_id['ProductsCategory']['slug']);
            $this->set('category_id_int', $category_id['ProductsCategory']['id']);
        } else {
            $this->set('category_id', false);
            $this->set('category_id_int', false);
        }
        
        $productCategories = $this->Product->ProductsCategory->find('first', array('conditions' => array('ProductsCategory.id' => $activeProductsCategory)));
        $this->set(compact('product', 'simiarProducts', 'accessories', 'activeProductsCategory', 'productCategories'));
        $LastViewedProductsIds = $this->Cookie->read('LastViewedProductsIds');

//        if (!is_array($LastViewedProductsIds)) {
        if (empty($LastViewedProductsIds)) {
            $LastViewedProductsIds = array();
        }
        if (!empty($LastViewedProductsIds)) {
            $LastViewedProductsIds = explode(';', $LastViewedProductsIds);
            while (($key = array_search($product['Product']['id'], $LastViewedProductsIds)) !== false) {
                unSet($LastViewedProductsIds[$key]);
            }
        }
        $LastViewedProductsIds[] = $product['Product']['id'];
        $this->Cookie->write('LastViewedProductsIds', implode(';', array_values($LastViewedProductsIds)), false, 3600 * 365 * 24);
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function admin_index() {
        $this->layout = 'admin';
        $this->helpers[] = 'FebTime';
        $this->Product->recursive = 1;

        $this->Product->locale = Configure::read('Config.languages');
        $this->Product->bindTranslation(array('title' => 'translateDisplay'));
//        $this->paginate = $params;

        $productCategories = $this->Product->ProductsCategory->find('list');
        $producents = $this->Product->find('list', array('fields' => array('Product.producer', 'Product.producer'), 'order' => 'Product.producer ASC'));
        $genders = $this->Product->genders;
        $brands = $this->Product->Brand->find('list');

        $this->filters = array(
            'Product.title' => array(
                'param_name' => "tytul", 'default' => '',
                'form' => array('label' => __d('cms', 'Tytuł'), 'type' => 'text')
            ),
            'Product.code' => array(
                'param_name' => "kod", 'default' => '',
                'form' => array('label' => __d('cms', 'Kod produktu'), 'type' => 'text')
            ),
            'Product.barcode' => array(
                'param_name' => "kod_kreskowy", 'default' => '',
                'form' => array('label' => __d('cms', 'Kod kreskowy'), 'type' => 'text')
            ),
            'Product.producer' => array(
                'param_name' => "producent", 'default' => '',
                'form' => array('multiple' => true, 'label' => __d('cms', 'Producent'), 'options' => $producents, 'empty' => __d('cms', 'wybierz ...'))
            ),
            'Product.brand' => array(
                'param_name' => "marka", 'default' => '',
                'form' => array('multiple' => true, 'label' => __d('cms', 'Marka'), 'options' => $brands, 'empty' => __d('cms', 'wybierz ...'))
            ),
            'Product.product_category_id' => array(
                'param_name' => "kategoria", 'default' => '',
                'form' => array('multiple' => true, 'label' => __d('cms', 'Kategoria'), 'options' => $productCategories, 'empty' => __d('cms', 'wybierz ...'), 'style' => 'height: 150px')
            ),
            'Product.size' => array(
                'param_name' => "rozmiar", 'default' => '',
                'form' => array('label' => __d('cms', 'Rozmiar produktu'), 'empty' => "", 'type' => 'text')
            ),
            'Product.gender' => array(
                'param_name' => "kolekcja", 'default' => '',
                'form' => array('multiple' => true, 'label' => __d('cms', 'Kolekcja damska/męska'), 'empty' => "", 'options' => $genders)
            ),
            'Product.quantity' => array(
                'param_name' => "ilosc", 'default' => '',
                'form' => array('label' => __d('cms', 'Ilość'), 'empty' => "", 'type' => 'text')
            ),
            'Product.promoted' => array(
                'param_name' => "promocja", 'default' => '',
                'form' => array('label' => __d('cms', 'Promowany na stronie głównej'), 'empty' => __d('cms', 'wybierz ...'), 'type' => 'checkbox')
            ),
            'Product.sale' => array(
                'param_name' => "wyprzedaz", 'default' => '',
                'form' => array('label' => __d('cms', 'Wyprzedaż'), 'empty' => __d('cms', 'wybierz ...'), 'type' => 'checkbox')
            ),
            'Product.on_blog' => array(
                'param_name' => "na_blogu", 'default' => '',
                'form' => array('label' => __d('cms', 'Promowany na blogu'), 'empty' => __d('cms', 'wybierz ...'), 'type' => 'checkbox')
            ),
            /* 'Product.best_seler' => array(
              'param_name' => "bestseller", 'default' => '',
              'form' => array('label' => __d('cms', 'Bestseller'), 'empty' => "wybierz ...", 'type' => 'checkbox')
              ), */
            'Product.price_min' => array(
                'param_name' => "cena_min", 'default' => '',
                'form' => array('label' => __d('cms', 'Cena minimalna'), 'type' => 'text')
            ),
            'Product.price_max' => array(
                'param_name' => "cena_max", 'default' => '',
                'form' => array('label' => __d('cms', 'Cena maksymalna'), 'type' => 'text')
            ),
            'Product.tax' => array(
                'param_name' => "podatek", 'default' => '',
                'form' => array('label' => __d('cms', 'Podatek'), 'type' => 'text')
            ),
            'Product.created_begin' => array(
                'param_name' => 'data_utworzenia_begin', 'default' => '',
                'form' => array('label' => __d('cms', 'Najwcześniejsza data utworzenia'), 'type' => 'text')
            ),
            'Product.created_end' => array(
                'param_name' => 'data_utworzenia_end', 'default' => '',
                'form' => array('label' => __d('cms', 'Najpóźniejsza data utworzenia'), 'type' => 'text')
            ),
            'Product.modified_begin' => array(
                'param_name' => 'data_modyfikacji_begin', 'default' => '',
                'form' => array('label' => __d('cms', 'Najwcześniejsza data modyfikacji'), 'type' => 'text')
            ),
            'Product.modified_end' => array(
                'param_name' => 'data_modyfikacji_end', 'default' => '',
                'form' => array('label' => __d('cms', 'Najpóźniejsza data modyfikacji'), 'type' => 'text')
            ),
            'ProductPromotion.on_promotion' => array(
                'param_name' => "on_promotion", 'default' => '',
                'form' => array('label' => __d('cms', 'Produkt na promocji'), 'empty' => "wybierz ...", 'type' => 'checkbox')
            ),
            'ProductPromotion.date' => array(
                'param_name' => "date", 'default' => '',
                'form' => array('label' => __d('cms', 'Dzień promocji'), 'type' => 'text', 'div' => array('class' => 'input text product_promotion_date'))
            )
        );
        $filtersParams = $this->Filtering->getParams();
        $params = $this->Product->filterParams($this->request->data);
        $params['limit'] = 50;
        $this->paginate = $params;
        $filtersSettings = $this->filters;
        $products = $this->paginate();
        $this->set(compact('productCategories', 'filtersParams', 'filtersSettings', 'products', 'brands'));
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->layout = 'admin';
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('product', $this->Product->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_import() {
        $this->layout = 'admin';
        if ($this->request->isPost() && !empty($this->data['ProductCsv']['csv']['tmp_name'])) {
            if (empty($this->data['ProductCsv']['csv']['size'])) {
                $this->Session->setFlash(__d('cms', 'Nie wysłano pliku, albo plik pusty'), 'flash/error');
            } elseif (!empty($this->data['ProductCsv']['csv']['error'])) {
                $this->Session->setFlash(__d('cms', 'Bład podczas wysyłania pliku'), 'flash/error');
            } else {
//                $_SESSION['importPricesFile'] = APP . 'tmp' . DS . 'cache' . DS . uniqid() . '.csv';
                if (!is_uploaded_file($this->data['ProductCsv']['csv']['tmp_name'])) { //, $_SESSION['importPricesFile'])) {
//                    unSet($_SESSION['importPricesFile']);
                    $this->Session->setFlash(__d('cms', 'Bład podczas dostępu do pliku.'), 'flash/error');
                } else {
                    $data = $this->prepareData($this->data['ProductCsv']['csv']['tmp_name']);
                    $data = Set::combine($data, "{n}.0", "{n}");
                    $subiekt_ids = Set::extract("{n}.0", $data);
                    $products = $this->Product->find('all', array(
                        'recursive' => -1,
                        'conditions' => array(
                            'Product.subiekt_id' => $subiekt_ids,
                        ),
                        'fields' => array('id', 'subiekt_id', 'title', 'quantity', 'jm', 'tax', 'barcode')
                    ));

                    if (empty($products)) {
                        $this->Session->setFlash(__d('cms', 'Żaden z towarów wymienionych w pliku csv nie jest dostępny w sklepie.'), 'flash/error');
                    } else {
                        $products = Set::combine($products, "{n}.Product.subiekt_id", "{n}.Product");
                        $this->set('systemProducts', $products);
                        $this->set('subiektProducts', $data);
                    }
                }
            }
        } elseif ($this->request->isPost() && !empty($this->data['Product'])) {

            $data = array();

            foreach ($this->data['Product'] AS $product) {
                if (!empty($product['id'])) {
                    $data[] = $product;
                }
            }
            if ($this->Product->saveMany($data)) {
                $this->Session->setFlash(__d('cms', 'Zaktualizowano ilości produktów'), 'flash/error');
            }
        }
    }

    protected function prepareData($filePath) {
//        $filePath = 'C:\Dziki\praca\zysio\_htdocs\ko24\app\webroot\towary.csv';
//        header('Content-type: text/html; charset=utf-8');
        $content = file($filePath);

        foreach ($content AS $i => $row) {
            $content[$i] = str_getcsv($row, ';', '"', '"');
            if(count($content[$i]) > 20) {
                $this->Session->setFlash(__d('csv', 'Nieprawidłowa liczba kolumn'));
                $this->redirect(array('action' => 'index'));
            }
            
            //$content[$i] = str_getcsv(iconv('windows-1250', 'UTF-8', $row), ';', '"', '"');
        }
        unSet($content[0]);
//        $data = array_chunk(str_getcsv($content, ';', '"', '"'), 5);
        return $content;
    }
    
    
    protected function saveRelatedProductsSizes(){
        $i = 0;
        foreach($this->data['ProductsSize'] AS $key => $value){
            if (empty($value['name'])) {
                continue;
            }
            if (empty($value['quantity'])) {
                $value['quantity'] = 0;
            }
            if(!empty($value['delete']) AND !empty($value['id'])){
                $this->Product->ProductsSize->delete($value['id']);
            } else {
                $this->Product->ProductsSize->create();
                $data = array('ProductsSize' => $value);
                $data['ProductsSize']['product_id'] = $this->Product->id;
                $this->Product->ProductsSize->save($data);
            }
        }
    }  
    
    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        $this->layout = 'admin';
        App::uses('Order', 'Commerce.Model');
        $this->loadModel('Brand');
        $brands = $this->Brand->find('list');
        $tax = Order::$taxRates;
        if ($this->request->is('post')) {
//            $this->saveRelatedProductsSizes();
        //    $this->Product->addUpdateSize($this->request->data['Product']['size']);
//            debug($this->request->data);
            $data = $this->request->data;
            if (!empty($data['Product']['price'])) {
                $this->request->data['Product']['price'] = str_replace(',', '.', $data['Product']['price']);
            }
            $this->Product->create();
            if ($this->Product->save($this->request->data)) {
                $this->Product->id = $this->Product->getLastInsertID();
                $this->saveRelatedProductsSizes();
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }

//        $productCategories = $this->Product->ProductsCategory->generateTreeList();
        $productCategories = $this->Product->ProductsCategory->find('list');
        $genders = $this->Product->genders;
        $this->set(compact('photos', 'productCategories', 'tax', 'genders', 'brands'));
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->layout = 'admin';
        $this->Product->id = $id;
        App::uses('Order', 'Commerce.Model');
        $this->loadModel('Brand');
        $brands = $this->Brand->find('list');
        $tax = Order::$taxRates;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->saveRelatedProductsSizes();
       //     $this->Product->addUpdateSize($this->request->data['Product']['size']);
            
            $data = $this->request->data;
            if (!empty($data['Product']['price'])) {
                $this->request->data['Product']['price'] = str_replace(',', '.', $data['Product']['price']);
            }
            if ($this->Product->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->Product->locale = Configure::read('Config.languages');
            $this->request->data = $this->Product->read(null, $id);
        }

        $productCategories = $this->Product->ProductsCategory->find('list');
        $genders = $this->Product->genders;
//        $productCategories = $this->Product->ProductsCategory->generateTreeList();
        $this->set(compact('photos', 'productCategories', 'tax', 'genders', 'brands'));
    }

    /**
     * Akcja usuwająca obiekt
     *
     * @param string $id
     * @return void
     */
    function admin_delete($id = null, $all = null) {
        $this->Product->deletePhotos($id);
        $this->FebI18n->delete($id, $all);
        $this->redirect(array('action' => 'index'), null, true);
    }

    /**
     * Akcja renderująca widok na liście produktów
     */
    public function admin_multiselect_index() {
        $success = 0;
        $products = array();
        $ids = $this->request->data['ids'];

        if (!empty($ids)) {
            $this->Product->locale = Configure::read('Config.languages');
            $this->Product->bindTranslation(array('title' => 'translateDisplay'));
            $params['conditions']['Product.id'] = $ids;
            $products = $this->Product->find('all', $params);
        }

        $this->set(compact('products', 'success', 'ids'));
    }

    /**
     * Akcja kasuje produkty podobne z bazy
     * $id - id produktu
     * $similar_id - id produktu podobnego
     */
    public function admin_ajax_multiselect_remove() {
        $this->loadModel('ProductsSimilarProduct');
        if (isset($this->request->data)) {
            if (isset($this->request->data['product_id']) && isset($this->request->data['similar_id'])) {
                $params['conditions']['ProductsSimilarProduct.product_id'] = $this->request->data['product_id'];
                $params['conditions']['ProductsSimilarProduct.similar_product_id'] = $this->request->data['similar_id'];
                $similarProduct = $this->ProductsSimilarProduct->find('first', $params);
                $id = $similarProduct['ProductsSimilarProduct']['id'];
                if (!empty($id)) {
                    $this->ProductsSimilarProduct->delete($id);
                }
            }
        }
        exit;
        $this->render(false);
    }

    /**
     * Akcja wyciągająca dane do multiselecta
     */
    public function admin_multiselect() {

        $params = array();
        $conditions = $this->postConditions($this->request->data, array(
            'Product.id' => '<>',
        ));
        unSet($conditions['Product.category_id']);

        $this->Product->ProductsCategory->displayField = 'name';
        $categories = $this->Product->ProductsCategory->generateTreeList();
        $params['conditions'] = $conditions;

        if (!empty($this->request->data['Product']['category_id'])) {
            $params['joins'][] = array(
                'table' => 'products_product_categories',
                'alias' => 'ProductsProductsCategory',
                'type' => 'INNER',
                'conditions' => array(
                    'ProductsProductsCategory.product_id = Product.id',
                    "ProductsProductsCategory.product_category_id = {$this->request->data['Product']['category_id']}",
                )
            );
        }
        $this->Product->locale = Configure::read('Config.languages');
        $this->Product->bindTranslation(array('title' => 'translateDisplay'));
        $products = $this->Product->find('all', $params);

//        debug($categories);
//        debug($products);
        $this->set(compact('categories', 'products'));
    }

    public function admin_ctg_by_selection() {

        $categories = $this->Product->ProductsCategory->generateTreeList($this->postConditions($this->request->data));

        $this->set(compact('categories'));
        $this->render('/Elements/Products/product_select');
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
        $params['fields'] = array('title');

        //Dodatkowe dane przekazywane z FebFormHelper-a
        //if (!empty($this->request->data['fields']['field_name'])) {
        //    $params['conditions']['Product.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->Product->recursive = -1;
        $params['conditions']["Product.title LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->Product->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

    function rating() {
        $data['ProductsRating']['product_id'] = $_POST['idBox'];
        $data['ProductsRating']['rate'] = $_POST['rate'];
        $this->Product->ProductsRating->create();
        $return = $this->Product->ProductsRating->save($data);
        $this->render(false);
        return json_encode($return);
    }
    
    public function search($slug = null) {
        $this->layout = 'default';
        $this->Product->locale = Configure::read('Config.languages');
        $this->Product->bindTranslation(array('title' => 'translateDisplay'));
        $this->Product->bindPromotion();
        if (isset($slug)) {
            $this->request->data['Search']['text'] = $slug;
            
        }
        if (empty($this->request->data['Search']['text'])) {
             $this->redirect('/');
        }
        $params = array('conditions' => array());
        if ($this->request->is('post') or !empty($slug)) {
            $this->Product->recursive = 0;
            if (!empty($this->request->data['Search']['text'])) {
                if (strlen(trim($this->request->data['Search']['text'])) != 0) {
                    $words = explode(' ', $this->request->data['Search']['text']);
                    $params = $this->Product->search($words);
                    if (!empty($params['fields'])) {
                        $params['fields'][] = 'ProductsPromotion.*';
                    }
                }
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
        }
        if (!empty($this->request->data['Search']['text'])) {
            $search_text = $this->request->data['Search']['text'];
        }
        
        $org_params = $params;
        $filterData = array();
        if ($this->request->is('post') && !empty($this->request->data)) {
            $filterData = $this->Product->frontFilterParams($this->request->data);
            $params['conditions'] = array_merge($params['conditions'], $filterData);
        }
        
        $params['limit'] = 12;
        $params['recursive'] = 0;
        $this->paginate = $params;
        $products = $this->paginate();
        $this->set('sorts', $this->params['named']);

        $producents = $this->Product->find('list', array('fields' => array('Product.producer', 'Product.producer'), 'order' => 'Product.producer ASC'));
        $this->set(compact('products', 'producents'));

        
        $productIds = $this->Product->find('list', array(
            'conditions' => $org_params['conditions'],
            'fields' => array('Product.id', 'Product.id')
        ));

        $sizes = $this->Product->getSizes($productIds); 
        
        $productPrice = $this->Product->find('first', array(
            'conditions' => $org_params['conditions'],
            'recursive' => -1,
            'order' => array('Product.price DESC')
        ));
        $price_max = round($productPrice['Product']['price']);     
        $price_from = (!empty($this->request->data['price_from'])) ? $this->request->data['price_from'] : 0;
        $price_to = (!empty($this->request->data['price_to'])) ? $this->request->data['price_to'] : $price_max;

        $this->set(compact('filterData', 'sizes','price_max', 'price_from', 'price_to', 'search_text'));
        $this->render('index');
    }

    public function admin_multi_edit() {
        $this->layout = 'admin';
        if (!empty($this->request->data['Multiedit']['to_send'])) {
            $to_send = $this->request->data['Multiedit']['to_send'];
            $ids = explode('|', $to_send);
            $params['conditions']['Product.id'] = $ids;
            $params['limit'] = 50;
            $params['recursive'] = 0;
            $products = $this->Product->find('all', $params);
            $brands = $this->Product->Brand->find('list');
            //debug($products);
            $product_tpl = $products[0];
            $equal_value = array();
            $equal_value['price'] = $this->product_diff_value_by_key($products, 'price');
            $equal_value['tax'] = $this->product_diff_value_by_key($products, 'tax');
            $equal_value['producer'] = $this->product_diff_value_by_key($products, 'producer');
            $equal_value['brand_id'] = $this->product_diff_value_by_key($products, 'brand_id');
            $equal_value['execution_time'] = $this->product_diff_value_by_key($products, 'execution_time');
            $equal_value['quantity'] = $this->product_diff_value_by_key($products, 'quantity');
            $equal_value['on_blog'] = $this->product_diff_value_by_key($products, 'on_blog');
            $equal_value['promoted'] = $this->product_diff_value_by_key($products, 'promoted');
            //$equal_value['sale'] = $this->product_diff_value_by_key($products, 'sale');
            //$equal_value['popular'] = $this->product_diff_value_by_key($products, 'popular');
            //$equal_value['best_seler'] = $this->product_diff_value_by_key($products, 'best_seler');
            App::uses('Order', 'Commerce.Model');
            $tax = Order::$taxRates;

            $this->set(compact('products', 'equal_value', 'product_tpl', 'tax', 'to_send', 'brands'));
        } else if (!empty($this->request->data['Products'])) {
            $ids = explode('|', $this->request->data['Ids']['ids']);
            $result['ok'] = 0;
            $result['fail'] = 0;
            foreach ($ids as $id) {
                $myProduct = array();
                $myProduct['Product'] = $this->request->data['Products'];
                
                if(empty($this->request->data['Products']['price'])) {
                    $product = $this->Product->find('first', array('conditions' => array('Product.id' => $id)));
                    $myProduct['Product']['price'] = $product['Product']['price'];
                }
                $this->Product->id = $id;
                if ($this->Product->save($myProduct)) {
                    $result['ok']++;
                } else {
                    $result['fail']++;
                }
            }
            if($result['fail']) {
                $this->Session->setFlash('Błąd aktualizacji wystąpił dla ' . $result['fail'] . ' produktów');
            } else {
                $this->Session->setFlash(__('Liczba produktów poprawnie zaktualizowanych ') . $result['ok']);
            }
            $this->redirect(array('action' => 'index'));
        } else {
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * Funkcja porównuje wartości tablicy Product dla danego klucza
     * @param type $array - tablica tablic zawierających te same klucze
     * @param type $key - porównywany klucz
     * @return true - jeśli wszystkie wartości dla danego klucza są równe
     *         false - w przeciwnym wypadku
     */
    private function product_diff_value_by_key($array, $key) {
        $result = true;

        for ($i = 0; $i < count($array); $i++) {
            if (!isset($array[$i]['Product'][$key])) {
                return false;
            }
        }

        if (count($array) > 1) {
            for ($i = 0; $i < count($array) - 1; $i++) {
                if ($array[$i]['Product'][$key] != $array[$i + 1]['Product'][$key]) {
                    $result = false;
                    break;
                }
            }
        } else if (count($array) == 1) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * Funkcja importuje dane z pliku csv do bazy danych
     */
    public function admin_csv_import() {
        $this->layout = 'admin';

        if ($this->request->isPost() && !empty($this->data['ProductCsv']['csv']['tmp_name'])) {
            if (empty($this->data['ProductCsv']['csv']['size'])) {
                $this->Session->setFlash(__d('cms', 'Nie wysłano pliku, albo plik pusty'), 'flash/error');
            } elseif (!empty($this->data['ProductCsv']['csv']['error'])) {
                $this->Session->setFlash(__d('cms', 'Bład podczas wysyłania pliku'), 'flash/error');
            } else {
                if (!is_uploaded_file($this->data['ProductCsv']['csv']['tmp_name'])) {
                    $this->Session->setFlash(__d('cms', 'Bład podczas dostępu do pliku.'), 'flash/error');
                } else {
                    $this->checkCsvFile($this->data['ProductCsv']);
                    $data = $this->prepareData($this->data['ProductCsv']['csv']['tmp_name']);
                    //debug($data);

                    $productsFromCsv = $this->array2AssociativeArray($data);
                    if($productsFromCsv == false) {
                        $this->Session->setFlash(__('Plik zawiera błędne dane'));
                        $this->redirect(array('action' => 'index'));
                    }
//                    debug($productsFromCsv);
                    $productsFromSystem = $this->Product->find('all', array('recursive' => 1));
                    //debug($productsFromSystem);
                    
                    $brands = $this->Product->Brand->find('list');
//                    debug($brands);
                    $this->setProductBrandId(&$productsFromCsv, $brands);
                    //debug($productsFromCsv);
                    
                    $productCategories = $this->Product->ProductsCategory->find('all');
                    $productCategoriesList = $this->Product->ProductsCategory->find('list');
                    //debug($productCategoriesList);
                    $this->setProductCategoryId(&$productsFromCsv, $productCategoriesList);
//                    debug($productsFromCsv);
                    
                    $productsDiff = $this->diffProductsTable($productsFromSystem, &$productsFromCsv);
//                    debug($productsDiff);

                    $this->set(compact('productsFromCsv', 'productsDiff', 'productCategoriesList', 'brands'));
                }
            }
            // zapis importu do bazy danych
        } elseif ($this->request->isPost() && empty($this->data['ProductCsv']['csv']['tmp_name'])) {
            if (isset($this->request->data['Update']) && !empty($this->request->data['Update'])) {
                foreach ($this->request->data['Update'] AS $product) {
                    $productCategories = $this->Product->ProductsCategory->find('list');
                    $productCategory_id = $product['ProductCategory']['id'];
                    $product['ProductsCategory']['ProductsCategory'][] = $productCategory_id;
                    unset($product['ProductCategory']);
                    if (!empty($product['Product']['url'])) {
                        $this->Product->deletePhotos($product['Product']['id']);
                    }
                    $this->Product->importPhotos($product);
                    if (!$this->Product->saveAssociated($product)) {
                        $this->Session->setFlash(__d('cms', 'Błąd aktualizacji produktu'));
                        $this->redirect(array('admin' => 'admin', 'plugin' => 'static_product', 'controller' => 'products', 'action' => 'index'));
                    } else {
                        $product_id = $this->Product->getID();
                        $product = $this->Product->read(null, $product_id);
                        $photo_id = empty($product['Photos'][0]['id'])? null: $product['Photos'][0]['id'];
                        $this->Product->id = $product_id;
                        $this->Product->saveField('photo_id', $photo_id);
                    }
                }
            }
            if (isset($this->request->data['New']) && !empty($this->request->data['New'])) {
                $this->request->data['New'] = $this->createSizes($this->request->data['New']);
                foreach ($this->request->data['New'] AS $product) {
                    $productCategories = $this->Product->ProductsCategory->find('list');
                    $productCategory_id = $product['ProductCategory']['id'];
                    $product['ProductsCategory']['ProductsCategory']['id'] = $productCategory_id;
                    unset($product['ProductCategory']);
                    $this->Product->importPhotos($product);

       //             $product['Product']['quantity_string'] = $product['Product']['quantity'];
                    $this->Product->create();
                    if (!$this->Product->saveAssociated($product)) {
                        $this->Session->setFlash(__d('cms', 'Nie można dodać produktu'));
                    } else{
                        $product_id = $this->Product->getLastInsertID();
                        $photo_id = $this->Product->Photos->getLastInsertID();
                        $this->Product->id = $product_id;
                        $this->Product->saveField('photo_id', $photo_id);
                    }
                }
            }
            $this->Session->setFlash(__d("cms", "Dane zostały wprowadzone do bazy"));
            $this->redirect(array('admin' => 'admin', 'plugin' => 'static_product', 'controller' => 'products', 'action' => 'index'));
        }
    }
    /**
     * Funkcja sprawdza poprawność importowanego pliku produktów
     * @param type $csvData - dane z pliku csv
     */
    private function checkCsvFile($csvData) {
        $info = pathinfo($csvData['csv']['name']);
        if(strtolower($info['extension']) != 'csv') {
            $this->Session->setFlash(__d('cms', 'To nie jest plik *.csv wybierz plik o prawidłowym formacie'));
            $this->redirect(array('action' => 'index'));
        }
    }



    /**
     * Funkcja konwertuje zwykłą tablicę opisu produktu 
     * na tablicę assocjacyjną produktu zamieniając np:
     * array(1 => 'abc') na -
     * array(1 => array('Product' => array('name' => 'abc')));
     * @param $_array - tablica zwykła 
     * @return zwraca tablice asocjacyjną
     */
    public function array2AssociativeArray($_array) {
        $assoc = array();
        $assoc['NEW'] = array();
        $assoc['UPDATE'] = array();

        foreach ($_array as $key => $value) {
            $tmp = trim($value[0]);
            if (empty($tmp)) {
                $mode = 'NEW';          // produkt nowy - puste id (value[0]
            } else {
                $mode = 'UPDATE';       // produkt istnieje - do aktualizacji
            }
            
            $assoc[$mode][$key]['Product']['id'] = trim($value[0]);
            if(empty($value[1])) { return false;}
            $assoc[$mode][$key]['Product']['title'] = trim($value[1]);
            $assoc[$mode][$key]['Product']['barcode'] = trim($value[2]);
            $assoc[$mode][$key]['Product']['code'] = trim($value[3]);
            $assoc[$mode][$key]['Product']['producer'] = trim($value[4]);
            $assoc[$mode][$key]['Brand']['name'] = trim($value[5]);
            $assoc[$mode][$key]['ProductCategory']['name'] = trim($value[6]);
            $assoc[$mode][$key]['Product']['gender'] = trim($value[7]);
            $assoc[$mode][$key]['Product']['size'] = strtoupper(trim($value[8]));
            $assoc[$mode][$key]['Product']['weight'] = trim($value[9]);
            if(empty($value[10])) { return false;}
            $assoc[$mode][$key]['Product']['quantity'] = trim($value[10]);
            //          $assoc[$mode][$key]['Product']['quantity_string'] = trim($value[10]);
            $assoc[$mode][$key]['Product']['execution_time'] = trim($value[11]);
            if(empty($value[12])) { return false;}
            $assoc[$mode][$key]['Product']['price'] = trim($value[12]);
            $assoc[$mode][$key]['Product']['tax'] = trim($value[13]);
            $assoc[$mode][$key]['Product']['promoted'] = trim($value[14]);
            $assoc[$mode][$key]['Product']['sale'] = trim($value[15]);
            $assoc[$mode][$key]['Product']['on_blog'] = trim($value[16]);
            $assoc[$mode][$key]['Product']['img'] = trim($value[17]);
            $assoc[$mode][$key]['Product']['content'] = trim($value[18]);
            $assoc[$mode][$key]['Product']['sized'] = trim($value[19]);
        }
        return $assoc;
    }
    

    private function createSizes($products) {
        foreach($products as $key => $product) {
            if (empty($product['Product']['sized'])) {
                continue;
            }
            $sizes = explode('|', $product['Product']['size']);
            $quantity = explode('|', $product['Product']['quantity']);
            
            foreach($sizes as $i => $size) {
                $sizeRow = array();
                $sizeRow['name'] = $size;
                if (!empty($quantity[$i])) {
                    $sizeRow['quantity'] = $quantity[$i]; 
                }
                else {
                    $sizeRow['quantity'] = 0; 
                }
                $sizeRow['delete'] = 0; 
                $products[$key]['ProductsSize'][] = $sizeRow;
            }
        }
        return $products;
    }
    
    /**
     * Funkcja ustawia id marki dla produktu csv wyszukując go w tablicy marek po nazwie
     * jeśli znajdzie to przypisuje id do produktu z csv
     *          null w przeciwnym razie
     * @param type $_productsCsv - tablica produktów z CSV
     * @param type $_brands - tablica marek
     */
    public function setProductBrandId($_productsCsv, $_brands) {
        foreach($_productsCsv as $productsCsvModeKey => $productsCsvModeValue) {
            foreach ($productsCsvModeValue as $productCsvKey => $productCsvValue) {
                $csvBrandName = $productCsvValue['Brand']['name'];
                $_productsCsv[$productsCsvModeKey][$productCsvKey]['Brand']['id'] = null;
                    
                foreach ($_brands as $brandListKey => $brandListValue) {
                    if (strtolower($brandListValue) == strtolower($csvBrandName)) {
                        $_productsCsv[$productsCsvModeKey][$productCsvKey]['Brand']['id'] = $brandListKey;
                        break;
                    }
                }
                if(empty($_productsCsv[$productsCsvModeKey][$productCsvKey]['Brand']['id'])) {
                    unset($_productsCsv[$productsCsvModeKey][$productCsvKey]['Brand']['name']);
                }
            }
        }
    }
    /**
     * Funkcja ustawia id dla produktu csv wyszukując go w tablicy kategorii po nazwie
     * jeśli znajdzie to przypisuje id do produktu z csv
     *          null w przeciwnym razie
     * @param type $_productsCsv - tablica produktów z CSV
     * @param type $_productCategory - tablica kategorii
     */
    public function setProductCategoryId($_productsCsv, $_productCategoriesList) {
        foreach($_productsCsv as $productsCsvModeKey => $productsCsvModeValue) {
            foreach ($productsCsvModeValue as $productCsvKey => $productCsvValue) {
                $csvCategoryName = $productCsvValue['ProductCategory']['name'];
                $_productsCsv[$productsCsvModeKey][$productCsvKey]['ProductCategory']['id'] = null;

                foreach ($_productCategoriesList as $categoriesListKey => $categoriesListValue) {
                    if (strtolower($categoriesListValue) == strtolower($csvCategoryName)) {
                        $_productsCsv[$productsCsvModeKey][$productCsvKey]['ProductCategory']['id'] = $categoriesListKey;
                        break;
                    }
                }
            }
        }
    }

    /**
     * Funkcja porównuje tablice produktów systemowych i produktów z pliku CSV
     * porównywanie odbywa sie po id produktu, jeśli w obu tablicach są produkty
     * o tym samym id, 
     *      które różnią się od siebie 
     *          to są wpisywane do tablicy wynikowej, i kasowane z tablicy csv
     *      jeśli nie różnią się od siebie
     *          to nie są wpisywane do tablicy wynikowej, ale kasowane z tablicy csv
     * @param type $_productsSystem - produkty znajdujace się w sklepie
     * @param type $_productsCsv - produkty z pliku csv
     */
    public function diffProductsTable($_productsSystem, $_productsCsv) {
//        debug($_productsCsv);
//        debug($_productsSystem);
        $diffTable = array();
        if(isset($_productsCsv['UPDATE'])) {
            foreach ($_productsCsv['UPDATE'] as $key => $value) {
                $id = $value['Product']['id'];
                $productSysId = null;
                foreach ($_productsSystem as $keySys => $valueSys) {
                    if($valueSys['Product']['id'] == $id) {
                        $productSysId = $keySys;
                        break;
                    }
                }
                if(isset($_productsSystem[$productSysId])) {
                    $equal = $this->isEqualProducts($_productsSystem[$productSysId], $value);
                    if(!$equal) {
                        $diffTable[$id]['system'] = $_productsSystem[$productSysId];
                        $diffTable[$id]['csv'] = $value;
                    }
                    unset($_productsCsv['UPDATE'][$key]);
                } else {
                    $value['Product']['id'] = null;
                    array_push($_productsCsv['NEW'], $value);
                    unset($_productsCsv['UPDATE'][$key]);
                }
            }
        }
        return $diffTable;
    }

    /**
     * Funkcja porównuje dwa produkty ze sobą
     * @param $_productSys - produkt sysemowy
     * @param $_productCsv - produkt csv
     * @return zwraca 1 jeśli równe, 0 w przeciwnym razie
     */
    public function isEqualProducts($_productSys, $_productCsv) {
        $diff = 1;
//        debug($_productSys);
//        debug($_productCsv);
        if ($_productSys['Product']['title'] != $_productCsv['Product']['title']) {
            return 0;
        }
        if ($_productSys['Product']['code'] != $_productCsv['Product']['code']) {
            return 0;
        }
        if ($_productSys['Product']['barcode'] != $_productCsv['Product']['barcode']) {
            return 0;
        }
        if ($_productSys['Product']['producer'] != $_productCsv['Product']['producer']) {
            return 0;
        }
        if ($_productSys['Product']['brand_id'] != $_productCsv['Brand']['id']) {
            return 0;
        }
        if ($_productSys['Product']['quantity'] != $_productCsv['Product']['quantity']) {
            return 0;
        }
//        if (!empty($_productSys['Product']['sized']) && $_productSys['Product']['quantity_string'] != $_productCsv['Product']['quantity']) {
//            return 0;
//        }
        if ($_productSys['Product']['weight'] != $_productCsv['Product']['weight']) {
            return 0;
        }
        if ($_productSys['Product']['execution_time'] != $_productCsv['Product']['execution_time']) {
            return 0;
        }
        if ($_productSys['Product']['price'] != $_productCsv['Product']['price']) {
            return 0;
        }
        if ($_productSys['Product']['promoted'] != $_productCsv['Product']['promoted']) {
            return 0;
        }
        if ($_productSys['Product']['sale'] != $_productCsv['Product']['sale']) {
            return 0;
        }
        if ($_productSys['Product']['on_blog'] != $_productCsv['Product']['on_blog']) {
            return 0;
        }
        if ($_productSys['Product']['content'] != $_productCsv['Product']['content']) {
            return 0;
        }
        if ($_productSys['Product']['gender'] != $_productCsv['Product']['gender']) {
            return 0;
        }
        if ($_productSys['Product']['size'] != $_productCsv['Product']['size']) {
            return 0;
        }
        if ($_productSys['Product']['sized'] != $_productCsv['Product']['sized']) {
            return 0;
        }
        // jesli produkty mają chociaz jedna wspolna kategorie to sa rowne
        $_productCsv['ProductCategory']['EqualCategory'] = 0;
        foreach ($_productSys['ProductsCategory'] as $item) {
            if ($item['id'] == $_productCsv['ProductCategory']['id']) {
                $_productCsv['ProductCategory']['EqualCategory'] = 1;
                break;
            }
        }
        if (!$_productCsv['ProductCategory']['EqualCategory']) {
            return 0;
        }

        if (!isset($_productCsv['Product']['img']) || empty($_productCsv['Product']['img'])) {
            return 1;
        } else {
            return 0;
        }
        return $diff;
    }

}
