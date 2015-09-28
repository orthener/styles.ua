<?php

App::uses('AppModel', 'Model');

class PricesComparisionXmlsController extends AppController {

    /**
     * Nazwa layoutu
     */
    public $layout = 'admin';

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('xml'));
    }

    /**
     * Generate XML with products
     * 
     * @param type $type
     * @throws NotFoundException
     */
    public function xml($type = null) {
        if ($type == null) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        // To add new xml, just add one element to array below, and put view script with $type name
        $allowed = array('ceneo', 'okazje', 'nokaut');
        
        if (!in_array($type, $allowed)) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }

        $this->layout = 'xml/default';
        // XML
        $this->response->type('xml');
        $this->loadModel('StaticProduct.Product');
        $this->loadModel('StaticProduct.ProductsCategory');

        $this->Product->recursive = 0;
        $this->Product->bindPromotion(false);
        $this->Product->Behaviors->attach('Containable');
        $this->Product->contain(array('Photo', 'ProductsCategory', 'ProductsPromotion'));

        $products = $this->Product->find('all');

        $products_categories = $this->ProductsCategory->find('all');

        $this->set('products', $products);
        $this->set('products_categories', $products_categories);

        $this->render($type);
    }

}
