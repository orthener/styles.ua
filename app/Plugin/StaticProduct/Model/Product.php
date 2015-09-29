<?php

App::uses('AppModel', 'Model', 'ProductsProductCategory');
App::uses('FebCategory', 'Category');
App::uses('OrderItemProductModel', 'Commerce.Vendor/Interface');

/**
 * Product Model
 *
 * @property Photo $Photo
 * @property ProductsCategory $ProductsCategory
 */
class Product extends AppModel implements OrderItemProductModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array(
        'Image.Upload',
        'Slug.Slug',
        'Translate.TranslateRelated',
        'Translate' => array('title', 'content', 'slug', 'execution_time', 'producer', 'code'),
    );

    /**
     * Display field
     *
     * @var string 
    */
    public $displayField = 'title';

    /**
     * Domyślne sortowanie
     *
     * @var string
     */
    public $order = 'Product.created DESC';

    /**
     *  
     * @var type 
     */
    public $genders = array(
        '' => 'nieustalone',
        'm' => "man",
        'w' => "woman"
    );

    public $productsLimit = 12;
    public $productsLimitAjax = 12;
    
    /**
     * Validation rules
     *
     * @var array
     */

    function beforeValidate($options = array()) {
        if ($this->data['Product']['price'] == "0.00") {
            $this->data['Product']['price'] = null;
        }
        $this->validate = array(
            'slug' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'title' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    'message' => __d('cms', 'Pole formularza nie może być puste'),
                )
            ),
            'brand_id' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    'message' => __d('cms', 'Pole formularza nie może być puste'),
                )
            ),
            'price' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    'message' => __d('cms', 'Pole formularza nie może być puste'),
                )
            ),
        );
    }

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Photo' => array(
            'className' => 'Photo.Photo',
            'foreignKey' => 'photo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'brand_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Photos' => array(
            'className' => 'Photo.Photo',
            'foreignKey' => 'product_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'Photos.order ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'ProductsSize' => array(
                'className' => 'StaticProduct.ProductsSize',
                'foreignKey' => 'product_id',
                'conditions' => '',
                'fields' => '',
                'order' => 'ProductsSize.created ASC, ProductsSize.id ASC'
        )
    );
//    public $hasOne = array(
//        'ProductsRating' => array(
//            'className' => 'ProductsRating',
//            'conditions' => array('ProductsRating.product_id'),
//            'group' => array('ProductsRating.product_id'),
//            'fields' => array('SUM(ProductsRating.rate)   AS sum', 'COUNT(ProductsRating.rate)  AS count'),
//            'dependent' => true
//            ));

    public $hasAndBelongsToMany = array(
        'ProductsCategory' => array(
            'className' => 'StaticProduct.ProductsCategory',
            'joinTable' => 'products_product_categories',
            'foreignKey' => 'product_id',
            'associationForeignKey' => 'product_category_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'SimilarProduct' => array(
            'className' => 'StaticProduct.SimilarProduct',
            'joinTable' => 'products_similar_products',
//            'foreignKey' => 'similar_product_id',
//            'associationForeignKey' => 'product_id',
            'foreignKey' => 'product_id',
            'associationForeignKey' => 'similar_product_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'SimilarProductRevert' => array(
            'className' => 'StaticProduct.SimilarProduct',
            'joinTable' => 'products_similar_products',
//            'foreignKey' => 'product_id',
//            'associationForeignKey' => 'similar_product_id',
            'foreignKey' => 'similar_product_id',
            'associationForeignKey' => 'product_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Accessory' => array(
            'className' => 'StaticProduct.Accessory',
            'joinTable' => 'products_accessories',
            'foreignKey' => 'accessory_id',
            'associationForeignKey' => 'product_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

    /**
     * Wyciąga dane do modułu frontowych boxów
     * 
     * @return type array
     */
    public function frontBox($params, $selection = 0) {
        $this->Behaviors->attach('Containable');

        $this->contain('Photo');

        return $this->find('all', array(
                    'conditions' => array(
                        'Product.promoted' => 1,
                        'Product.selection_id' => $selection
                    )
        ));
    }

    public function bindPromotion($reset = false) {
        $this->bindModel(array('hasOne' => array(
                'ProductsPromotion' => array(
                    'className' => 'ProductsPromotion',
                    'conditions' => array('ProductsPromotion.date_from < NOW() AND ProductsPromotion.date_to > NOW()'),
                    'dependent' => true
                )
            )), $reset);
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (empty($this->data['Product']['quantity'])) {
            $this->data['Product']['quantity'] = 0;
        }
    }

    public function afterFind($results, $primary = false) {
        foreach ($results as $k => &$r) {
            if (isSet($r['SimilarProductRevert']) && isSet($r['SimilarProduct'])) {
                $r['SimilarProduct'] = am($r['SimilarProduct'], $r['SimilarProductRevert']);
            }
        }
        return $results;
    }

    public function getAccesories($productId = null) {
        $params['joins'][] = array(
            'table' => 'products_accessories',
            'alias' => 'ProductsAccessory',
            'type' => 'INNER',
            'conditions' => array(
                "ProductsAccessory.accessory_id = {$productId}",
                "ProductsAccessory.product_id = Product.id",
            )
        );
        return $this->find('all', $params);
    }

    public function getSimilarProduct($productId = null, $fields = array()) {
//        $params['joins'][] = array(
//            'table' => 'products_similar_products',
//            'alias' => 'ProductsSimilarProduct',
//            'type' => 'INNER',
//            'conditions' => array(
//                "ProductsSimilarProduct.product_id = {$productId}",
//                "ProductsSimilarProduct.similar_product_id = Product.id"
//            )
//        );                      
        $categories_id = $this->ProductsProductCategory->find('list', array(
            'fields' => array('ProductsProductCategory.product_category_id'),
            'conditions' => array('ProductsProductCategory.product_id' => $productId)
        ));
        if (!empty($categories_id)) {
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
            $params['ProductsProductCategory.product_category_id'] = $categories_id;
            $params['conditions']['Product.id <>'] = $productId;
        }
        $params['limit'] = 6;
        $params['order'] = 'Product.promoted DESC,RAND()';
        return $this->find('all', $params);
    }

    public function getPopularProducts($days = 60, $limit = 6, $status = null) {
        $orderItem = ClassRegistry::init('Commerce.OrderItem');
        $order = ClassRegistry::init('Commerce.Order');

        if (!empty($status)) {
            $conditions['OrderItem.order_id'] = $order->find('list', array(
                'recursive' => -1,
                'conditions' => array('Order.order_status_id' => $status),
                'fields' => array('Order.id'),
                'order' => array('Order.id DESC'),
                'limit' => 20,
            ));
        }
        $conditions['OrderItem.created >'] = date('Y-m-d', (strtotime('-' . $days . ' days')));

        $params['Product.id'] = $orderItem->find('list', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'fields' => array('OrderItem.product_id'),
            'group' => array('OrderItem.product_id'),
            'order' => array('COUNT(*) DESC'),
            'limit' => $limit,
        ));
        return $this->find('all', $params);
    }
    /**
     * Funkcja wyszukuje najpopularniejsze produkty po ilości wyświetleń
     * @params $limit - ilość produktów do wyszukania
     */
    public function getPopularProductsByHit($limit = 6) {
        $params['limit'] = $limit;
        $params['order'] = 'Product.hit_counter DESC';
        $popularProducts = $this->find('all', $params);
        return $popularProducts;
    }
    

    public function getDynaTreeCategories($activeProductsCategory = null) {

        $productProductsCategory = ClassRegistry::init('StaticProduct.ProductsCategory');

        $productCategories = $this->ProductsCategory->findTree();

        //Pierwszy z brzegu
        $this->activeProductsCategory = $activeProductsCategory;

        $parents = $this->ProductsCategory->getPath($activeProductsCategory);

        $this->dynaTreeParents = Set::combine($parents, '{n}.ProductsCategory.id', '{n}.ProductsCategory.id');

        $this->categoryWithProducts = $productProductsCategory->find('list', array(
            'fields' => array(
                'product_category_id', 'product_category_id'
            ),
            'group' => 'product_category_id'
        ));

        FebCategory::reorganizeDataTree($productCategories, 'ProductsCategory', $this, function($data, $_this) {
                    $data['title'] = $data['name'];

                    $data['isFolder'] = true;

                    if (in_array($data['id'], $_this->categoryWithProducts)) {
                        $data['isFolder'] = false;
                    }

                    $data['isActive'] = 0;

                    if ($_this->activeProductsCategory == $data['id']) {
                        $data['isActive'] = 1;
                    }

                    if (in_array($data['id'], $_this->dynaTreeParents)) {
                        $data['expand'] = true;
                    }
                });

        unSet($this->dynaTreeParents, $this->activeProductsCategory);

        return $productCategories;
    }

    /**
     * Konstruktor klasy modelu
     * 
     * @param int $id
     * @param array $table
     * @param bool $ds 
     */
    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->genders = array(
            '' => __d('cms', 'nieustalone'),
            'm' => __d('cms', "man"),
            'w' => __d('cms', "woman")
        );
        
//$this->virtualFields = array('fullname' => "CONCAT({$this->alias}.field_1, ' ', {$this->alias}.field_2)");
//        $this->getEventManager()->dispatch(new CakeEvent('Model.Product.afterInit', $this));
        // $this->virtualFields = array('promotion_price' => "SELECT price FROM products_promotions WHERE product_id = {$this->alias}.id AND data_from < NOW() AND data_to > NOW() ORDER BY price DESC LIMIT 1");
    }

    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {

        if (!is_array($this->locale) and empty($extra['group'])) {
            $results = $this->find('first', array(
                'conditions' => $conditions,
                'fields' => array('COUNT(DISTINCT Product.id) AS cnt', 'Product.title', 'Product.content')
            ));
            return $results[0]['cnt'];
        } else {
            if (!empty($extra['group'])) {
                $field = $extra['group'];
                unSet($extra['group']);
                $params = array_merge(
                        array('conditions' => $conditions), array('fields' => array("COUNT(DISTINCT {$field}) AS count")), $extra
                );
                $results = $this->find('all', $params);
                return $results[0][0]['count'];
            }

            $params = array_merge(array('conditions' => $conditions), $extra);
            return $this->find('count', $params);
        }
    }

    public function orderItemFields($id = null) {
        $this->recursive = 0;
        $this->bindPromotion();
        $product = $this->findById($id);

        $price = empty($product['ProductsPromotion']['price']) ? $product['Product']['price'] : $product['ProductsPromotion']['price'];
        if(PRICE_TYPE == PRICE_GROSS) {
            $tax_value = round($price - ($price/(1+$product['Product']['tax'])), 2);
        } else {
            $tax_value = round($price * $product['Product']['tax'], 2);
        }
        return array(
            'product' => json_encode($product),
            'desc' => $product['Product']['content'],
            'name' => $product['Product']['title'],
            'price' => ($product['ProductsPromotion']['price'] ? $product['ProductsPromotion']['price'] : $product['Product']['price']),
            'tax_rate' => $product['Product']['tax'],
            'tax_value' => $tax_value,
            'weight' => $product['Product']['weight'],
        );

    }
    
    public function frontFilterParams($data) {
        $params = array();
//        if (!empty($data['size'])) {
//            $params['Product.size LIKE'] = '%'.$data['size'].'%';
//        }        
        if (!empty($data['Product']['title'])) {
            $words = explode(' ', $data['Product']['title']);
            $params = $this->search($words);
        }
        if (!empty($data['woman']) && empty($data['man'])) {
            $params['Product.gender LIKE'] = '%'.$data['woman'].'%';
        }
        if (empty($data['woman']) && !empty($data['man'])) {
            $params['Product.gender LIKE'] = '%'.$data['man'].'%';
        }
        
        if (!empty($data['price_from']) || !empty($data['price_to'])) {
            if (!empty($data['price_from']) && ($data['price_from'] != 0) && !empty($data['price_to']) && ($data['price_to'] != 0)) {
                $params['AND'] = array(
                    array('Product.price >=' => $data['price_from']), 
                    array('Product.price <=' => $data['price_to'])
                );
            } elseif (!empty($data['price_from']) && $data['price_from'] != 0) {
                $params['Product.price >='] = $data['price_from'];
            } elseif (!empty($data['price_to']) && $data['price_to'] != 0) {
                $params['Product.price <='] = $data['price_to'];
            }
        }
        
        if (!empty($data['Product']['size'])) {
            if (!empty($data['category_id'])) {
                $params['Product.id'] = $this->findProductsCategoryBySize($data);
                $params['Product.sized'] = true;
            }
            else {
                $params['Product.id'] = $this->ProductsSize->find('list', array(
                                            'conditions' => array(
                                                'ProductsSize.name' => $data['Product']['size']),
                                            'group' => array('ProductsSize.product_id'),
                                            'fields' => array('ProductsSize.product_id', 'ProductsSize.product_id')
                                        ));
                $params['Product.sized'] = true; 
            }
        }
        return $params;
    }

    // Funkcja pobierająca produkty z kategorii na podstawie rozmiaru
    private function findProductsCategoryBySize($data) {
        $params = '';
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
        $params['conditions']['ProductsProductCategory.product_category_id'] = $data['category_id'];
        $params['fields'] = array('Product.id', 'Product.id');
        $productIds = $this->find('list', $params);  
        
        return $this->ProductsSize->find('list', array(
            'conditions' => array(
                'ProductsSize.product_id' => $productIds,
                'ProductsSize.name' => $data['Product']['size']),
            'group' => array('ProductsSize.product_id'),
            'fields' => array('ProductsSize.product_id', 'ProductsSize.product_id')
        ));
    }
    
    public function getSizes($product_id, $filters = null) {
    //    $productsSize = ClassRegistry::init('StaticProduct.ProductsSize');
  //      debug($product_id);
        
        if (empty($filters)) {
            $sizes = $this->ProductsSize->find('list', array(
                'conditions' => array('ProductsSize.product_id' => $product_id, 'ProductsSize.quantity > 0'),
                'fields' => array('ProductsSize.name', 'ProductsSize.name'),
//                'group' => array('ProductsSize.name'),
                'order' => array('ProductsSize.created' => 'ASC')
            ));
        }
        else {
            $sizes = $this->ProductsSize->find('list', array(
                'conditions' => array('ProductsSize.product_id' => $product_id, 'ProductsSize.quantity > 0'),
                'fields' => array('ProductsSize.name', 'ProductsSize.name'),
                'group' => array('ProductsSize.name'),
                'order' => array('ProductsSize.created' => 'ASC')
            ));    
        }
            $sizes = $this->sortSizes($sizes);
        $sizes = array_unique($sizes);
        return $sizes;
    }      
    
    public function sortSizes($sizes) {
        $pattern = Configure::read('Sizes.pattern');
        if (empty($pattern)) {
            return $sizes;
        }
        
        $patternSizes = explode(',', $pattern);
        
        $sortedSizes = array();
        foreach($patternSizes as $patternSize) {
            if (in_array($patternSize, $sizes)) {
                $sortedSizes[$patternSize] = $patternSize;
                unset($sizes[$patternSize]);
            }
        }
        sort($sizes);
        $sortedSizes = array_merge($sortedSizes, $sizes);
        return $sortedSizes;
    }
    
    public function getSizesQuantity($product_id) {
        $sizes = $this->ProductsSize->find('list', array(
            'conditions' => array('ProductsSize.product_id' => $product_id),
            'fields' => array('ProductsSize.name', 'ProductsSize.quantity'),
            'group' => array('ProductsSize.name'),
            'order' => array('ProductsSize.created' => 'ASC')
        ));
        return $sizes;
    }    
    
    public function addUpdateSize($data) {
        $productsSize = ClassRegistry::init('StaticProduct.ProductsSize');
        
        $sizes = explode('|', $data);
        $toSave = array();
        foreach($sizes as $size) {
            if (!empty($size)) {
                $isAlready = $productsSize->find('first', array(
                    'conditions' => array('ProductsSize.name' => $size) 
                ));
                if (empty($isAlready)) {
                    $toSave['name'] = $size;
                    $productsSize->create();
                    $productsSize->save($toSave);
                }
            }
        }
        
        $sizes = $productsSize->find('list');
        foreach($sizes as $size) {
            $isAlready = $this->find('first', array(
                'recursive' => -1,
                'conditions' => array('Product.size LIKE' => '%'.$size.'%')
            ));
            
            if (empty($isAlready)) {
                $productsSize->deleteAll(array('ProductsSize.name' => $size));
            }
        }
        
        
    }
    
    /**
     * Logika dla globalnej wyszukiwarki w cms
     * nadpisuje metodę z AppModel
     * 
     * @param array $options
     * @param array $params
     * @return type array
     */
//    public function search($options, $params = array()) {
//        $fraz = $options['Searcher']['fraz'];
//        $params['OR']["Product.title LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }

    public function filterParams($data) {
        $params = array();
        if (!empty($data['Product']['title'])) {
            $data['Product']['title'] = str_replace('/', '', $data['Product']['title']);
            $words = array_filter(explode(' ', $data['Product']['title']));
            $params = $this->search($words);
        }
        if (!empty($data['Product']['code'])) {
            $params['conditions']['Product.code'] = $data['Product']['code'];
        }
        if (!empty($data['Product']['barcode'])) {
            $params['conditions']['Product.barcode'] = $data['Product']['barcode'];
        }
        if (!empty($data['Product']['producer'])) {
            $params['conditions']['Product.producer'] = $data['Product']['producer'];
        }
        if (!empty($data['Product']['brand'])) {
            $params['conditions']['Product.brand_id'] = $data['Product']['brand'];
        }
//        if (!empty($data['Product']['size'])) {
//            $sizes = explode('|', $data['Product']['size']);
//            foreach ($sizes as $size) {
//                $params['conditions']['OR'][]['Product.size LIKE'] = '%' . $size . '%';
//            }
//        }
        if (!empty($data['Product']['gender'])) {
            $params['conditions']['Product.gender'] = $data['Product']['gender'];
        }
        if (!empty($data['Product']['quantity'])) {
            $params['Product.quantity'] = $data['Product']['quantity'];
        }
        if (!empty($data['Product']['promoted'])) {
            $params['Product.promoted'] = $data['Product']['promoted'];
        }
        if (!empty($data['Product']['sale'])) {
            $params['Product.sale'] = $data['Product']['sale'];
        }
        if (!empty($data['Product']['on_blog'])) {
            $params['Product.on_blog'] = $data['Product']['on_blog'];
        }
        /* if (!empty($data['Product']['best_seler'])) {
          $params['Product.best_seler'] = $data['Product']['best_seler'];
          } */
        if (!empty($data['Product']['price_min'])) {
            $params['Product.price >='] = $data['Product']['price_min'];
        }
        if (!empty($data['Product']['price_max'])) {
            $params['Product.price <='] = $data['Product']['price_max'];
        }
        if (!empty($data['Product']['tax'])) {
            $params['Product.tax'] = $data['Product']['tax'];
        }
        if (!empty($data['Product']['created_begin'])) {
            $params['Product.created >='] = $data['Product']['created_begin'];
        }
        if (!empty($data['Product']['created_end'])) {
            $params['Product.created <='] = $data['Product']['created_end'];
        }
        if (!empty($data['Product']['modified_begin'])) {
            $params['Product.modified >='] = $data['Product']['modified_begin'];
        }
        if (!empty($data['Product']['modified_end'])) {
            $params['Product.modified <='] = $data['Product']['modified_end'];
        }

        if (!empty($data['Product']['product_category_id'])) {
            $params['joins'][] = array(
                'table' => 'products_product_categories',
                'alias' => 'ProductsProductCategory',
                'type' => 'LEFT',
                'conditions' => array(
                    'ProductsProductCategory.product_id = Product.id',
                )
            );
            $params['group'] = "Product.id";
            $params['ProductsProductCategory.product_category_id'] = $data['Product']['product_category_id'];
        }
        if (!empty($data['ProductPromotion']['on_promotion']) && $data['ProductPromotion']['on_promotion'] == 1) {
            $promotionDate = empty($data['ProductPromotion']['date']) ? date('Y-m-d') : $data['ProductPromotion']['date'];
            $params['joins'][] = array(
                'table' => 'products_promotions',
                'alias' => 'ProductsPromotion',
                'type' => 'LEFT',
                'conditions' => array(
                    'ProductsPromotion.product_id = Product.id',
                    'ProductsPromotion.date_from <=' => $promotionDate,
                    'ProductsPromotion.date_to >=' => $promotionDate,
                )
            );
            $params[] = 'ProductsPromotion.id IS NOT NULL';
        }
        return $params;
    }

    public function deletePhotos($id) {
        $photos = $this->Photo->find('list', array('conditions' => array('product_id' => $id)));
        foreach ($photos as $id => $photo) {
            $this->Photo->delete($id);
        }
    }

    //public function importPhotos($urls, &$photos) {
    /**
     * Funkcja importuje zdjęcia do modelu produktu
     * 
     * @param type $product
     */
    public function importPhotos(&$product) {
        $urls = $product['Product']['url'];        
        $url_tab = explode("|", $urls);
        if(!empty($url_tab[0])) {
            foreach ($url_tab as $ukey => $uvalue) {
                $product['Photos'][$ukey]['url'] = $uvalue;
                $file = basename($uvalue);
                $product['Photos'][$ukey]['img'] = $file;
                $product['Photos'][$ukey]['path'] = dirname($uvalue);
                $tmp = explode(".", $file);
                $product['Photos'][$ukey]['img_name'] = $tmp[0];
                $product['Photos'][$ukey]['img_ext'] = $tmp[1];
            }
            
            foreach ($product['Photos'] as &$photo) {
                $photo_name = $photo['img'];
                while (file_exists('files/photo/' . $photo_name)) {
                    $photo_name = Inflector::slug("img" . rand(100000, 999999) . "_" . $photo['img_name']);
                    $photo_name = $photo_name . '.' . $photo['img_ext'];
                }
                $photo['img'] = $photo_name;
            }
            unset($photo);       

            foreach ($product['Photos'] as $id => $photo) {
                if ($img = @file_get_contents($photo['url'])) {
                    file_put_contents('files/photo/' . $photo['img'], $img);
                } else {
                    unset($photos['Photos'][$id]);
                }
            }
        }
    }
    
    /**
     * Wyszukiwarka tekstowa
     */
    public function search($words) {
        foreach ($words AS $word) {
            $params['conditions']['OR'][0]['AND'][]['Product.title LIKE'] = '%' . $word . '%';
            $params['conditions']['OR'][1]['AND'][]['Product.tiny_content LIKE'] = '%' . $word . '%';
            
            
//            $params['conditions']['OR'][]['Product.title LIKE'] = '%' . $word . '%';
//            $params['conditions']['OR'][]['Product.tiny_content LIKE'] = '%' . $word . '%';
            //$cond_fields['Product.title'][] = 'Product.title LIKE "%' . $word . '%"';
            //$cond_fields['Product.tiny_content'][] = 'Product.tiny_content LIKE "%' . $word . '%"';
        }
        //$condition_order_fields = $this->prepare_condfields($cond_fields);
        //debug($condition_order_fields);
        //$params['fields'] = array_merge(array_values($condition_order_fields), array('Product.*', 'Photo.*'));
        //$params['fields'] = array('Product.*', 'Photo.*');
//        $params['order'] = array('ProductTitleOrder ASC, ProductTiny_contentOrder ASC');
        return $params;
    }

    private function prepare_condfields($cond_fields) {
        $return = array();
        foreach ($cond_fields AS $key => $value) {
            $name = explode('.', $key);
            foreach ($name AS &$n) {
                $n = ucfirst($n);
            }
            $name[] = 'Order';
            $name = implode('', $name);
            $return[$name] = '((' . implode(') + (', $value) . ')) AS ' . $name;
        }
        return $return;
    }

}

