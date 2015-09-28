<?php

App::uses('CommerceAppController', 'Commerce.Controller');

/**
 * OrderItems Controller
 *
 * @property OrderItem $OrderItem
 */
class OrderItemsController extends CommerceAppController {

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
    public $components = array('Commerce.Commerce');

    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('preview', 'add', 'upload_file', 'delete_file', 'window_configurator'));
    }

    function delete_file($id, $orderItemFile) {
        $this->layout = null;
        $error = "";

        if (!$id || !$orderItemFile) {
            $error = __d('commerce', 'Nie ustawiony identyfikator, lub plik');
        } else {
            $params['conditions']['OrderItem.id'] = $id;
            $this->OrderItem->recursive = 1;
            $orderItem = $this->OrderItem->find('first', $params);
            if ($this->Commerce->iAmOrderOwner($orderItem['Order']['id']) || $orderItem['Order']['order_status_id'] == 0) {
                if ($this->OrderItem->OrderItemFile->delete($orderItemFile)) {
                    $orderItem = $this->OrderItem->find('first', $params);
//                    $orderItem = $orderItem['OrderItem'];
//                    if (!empty($ret['OrderItemFile']['id'])) {
//                        $orderItem['OrderItemFile'] = $ret['OrderItemFile'];
//                    }
                } else {
                    $error = __d('commerce', 'Wystąpiły błędy podczas usuwania.');
                }
            } else {
                $error = __d('commerce', 'Zamówienie nie należy do Ciebie.');
            }
        }

        $orderItem = array_merge($orderItem, $orderItem['OrderItem']);

        $this->set(compact('orderItem', 'error'));
        $this->render('/Elements/Orders/project_file');
    }

    function upload_file($koszyk = null) {
        $this->layout = null;
        $error = "";

        $params['conditions']['OrderItem.id'] = $this->request->data['OrderItem']['id'];
        $this->OrderItem->recursive = 2;
        $orderItem = $this->OrderItem->find('first', $params);

        //Małe zabezpieczenie przeciwko html hakerom
        if (!empty($orderItem['OrderItemFile']['id'])) {
            $this->request->data['OrderItemFile']['id'] = $orderItem['OrderItemFile']['id'];
        }

        if ($this->Commerce->iAmOrderOwner($orderItem['Order']['id']) || $orderItem['Order']['order_status_id'] == 0) {
            //$this->OrderItem->create();
            if (isSet($this->request->data['OrderItemFile']['name']['name'])) {
                $this->request->data['OrderItemFile']['name']['name'] = $orderItem['Order']['id'] . '_' . $this->request->data['OrderItemFile']['name']['name'];
            }

            if ($this->OrderItem->OrderItemFile->save($this->request->data)) {
                $this->OrderItem->recursive = 1;
                $ret = $this->OrderItem->find('first', $params);
                $orderItem = $orderItem['OrderItem'];
                $orderItem['OrderItemFile'] = $ret['OrderItemFile'];
            } else {
                $orderItem = is_array($orderItem) ? $orderItem : array();
                $orderItem['OrderItem'] = is_array($orderItem['OrderItem']) ? $orderItem['OrderItem'] : array();
                $orderItem = array_merge($orderItem, $orderItem['OrderItem']);
                if (empty($this->OrderItem->OrderItemFile->validationErrors['name'])) {
                    $error = __d('commerce', "Nie można zapisac pliku z tym rozszerzeniem", true);
                } else {
                    $error = $this->OrderItem->OrderItemFile->validationErrors['name'];
                }
            }
        } else {
            $error = __d('commerce', "Zamówienie nie należy do Ciebie", true);
            //debug($error);
        }

        //if(!empty($error)){
        //   echo $error; exit;
        //}
        //Sprawdzam czy jest juz plik        
        $this->set(compact('orderItem', 'error', 'koszyk'));
        $this->render('/Elements/Orders/project_file');
    }

    function preview($id = null) {


        if (!$this->request->is('ajax')) {
            $this->layout = 'default';
        }

        $this->OrderItem->id = $id;
        if (!$this->OrderItem->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $orderItem = $this->OrderItem->find('first', array('conditions' => array(
                'OrderItem.id' => $id,
                )));

        $this->set('orderItem', $orderItem);
    }

    function add($product_id = null, $quantity = 1, $size = null, $productModel = 'Paint') {
        if(!empty($this->request->data['OrderItem']['product_model'])){
            $productModel= $this->request->data['OrderItem']['product_model'];
        }
        if(!empty($this->request->data['OrderItem']['product_id'])){
            $product_id= $this->request->data['OrderItem']['product_id'];
        }
        if(!empty($this->request->data['OrderItem']['quantity'])){
            $quantity = $this->request->data['OrderItem']['quantity'];
        }
        if(!empty($this->request->data['OrderItem']['size'])){
            $size = $this->request->data['OrderItem']['size'];
        }
        
        if (empty($this->OrderItem->$productModel) OR !($this->OrderItem->$productModel instanceof OrderItemProductModel)) {
            throw new NotFoundException("$productModel is not instance of OrderItemProductModel");
        }
        
        $productQuantity = $this->OrderItem->$productModel->ProductsSize->find('first', array(
            'conditions' => array(
                'ProductsSize.product_id' => $product_id,
                'ProductsSize.name' => $size)
        ));
//        if (empty($productQuantity['ProductsSize']['quantity'])) {
//            throw new NotFoundException(__d('public', 'Produkt nie jest dostępny w tym rozmiarze.'));
//        }
        
        if (!empty($productQuantity['ProductsSize']['quantity']) && $this->request->data['OrderItem']['quantity'] > $productQuantity['ProductsSize']['quantity']) {
            throw new NotFoundException(__d('front', 'Przekroczono dozwoloną ilość produktu dla tego rozmiaru.'));
        }
        
        //debug($this->Cookie->read());exit;
        if (!empty($product_id)) {
            $this->request->data['OrderItem']['product_model'] = $productModel;
            $this->request->data['OrderItem']['product_id'] = $product_id;
            $this->request->data['OrderItem']['quantity'] = $quantity;
            $this->request->data['OrderItem']['size'] = $size;
        }

        if (empty($this->request->data)) {
            $this->Session->setFlash(__('Dodanie do koszyka nie powiodło się, nieprawidłowy link.', true), 'flash/error');
            return;
        }

        $order_id = $this->Commerce->getOrder();
        if (!$order_id) {
            $order_id = $this->Commerce->createOrder();
        }

        $this->OrderItem->Order->id = $order_id; //$this->Cookie->read('Order.hash');
        //czy rzecz już jest w koszyku?
//        $this->OrderItem->recursive = -1;
//        $orderItem = $this->OrderItem->find('first', array('conditions' => array(
//            'OrderItem.product_model' => $this->request->data['OrderItem']['product_model'],
//            'OrderItem.product_id' => $this->request->data['OrderItem']['product_id'],
//            'OrderItem.order_id' => $order_id,
//        )));
        $this->OrderItem->create();
        //podbić ilość, jeśli rzecz już jest w koszyku
//        if (!empty($orderItem)) {
//            $this->OrderItem->id = $orderItem['OrderItem']['id'];
////            $this->OrderItem->saveField('quantity', $orderItem['OrderItem']['quantity'] + $this->request->data['OrderItem']['quantity']);
//            $this->request->data['OrderItem']['quantity'] = $orderItem['OrderItem']['quantity'] + $this->request->data['OrderItem']['quantity'];
//        }

        $orderItemFields = $this->OrderItem->$productModel->orderItemFields($this->request->data['OrderItem']['product_id']);
        
        $data = array('OrderItem' => $orderItemFields + array(
        'order_id' => $order_id,
        'product_model' => $this->request->data['OrderItem']['product_model'],
        'product_id' => $this->request->data['OrderItem']['product_id'],
        'quantity' => $this->request->data['OrderItem']['quantity'],
        'size' => $this->request->data['OrderItem']['size'],
        'discount' => $this->Commerce->getTheBestDiscount(),
                ));
        
        $tmp = $this->OrderItem->Order->read(null, $order_id);
     
        $this->OrderItem->Order->updateCookieLifeTime($order_id);

        $this->OrderItem->save($data);
        //$this->Session->setFlash(__('Produkt został dodany do koszyka', true));
        $this->redirect(array('controller' => 'orders', 'action' => 'cart'));
//        return array(
//            'order_item_id' => $this->OrderItem->getLastInsertID()
//        );
    }

    function add_many($products, $productModel = 'Paint') {
        if (empty($this->OrderItem->$productModel) OR !($this->OrderItem->$productModel instanceof OrderItemProductModel)) {
            throw new NotFoundException("$productModel is not instance of OrderItemProductModel");
        }
        $this->loadModel('Paint');
        $product = array();
        $paints = explode('|', $products);
        foreach ($paints as $key => $paint) {
            if (!empty($paint)) {
                $temp = explode('-', $paint);
                $product[$key]['id'] = $temp[0];
                $product[$key]['quantity'] = $temp[1];
            }
        }

        foreach ($product as $elem) {
            $product_id = $elem['id'];
            //debug($this->Cookie->read());exit;
            if (!empty($product_id)) {
                $this->request->data['OrderItem']['product_model'] = $productModel;
                $this->request->data['OrderItem']['product_id'] = $product_id;
                $this->request->data['OrderItem']['quantity'] = $elem['quantity'];
            }

            if (empty($this->request->data)) {
                $this->Session->setFlash(__('Dodanie do koszyka nie powiodło się, nieprawidłowy link.', true), 'flash/error');
                return;
            }

            $order_id = $this->Commerce->getOrder();
            if (!$order_id) {
                $order_id = $this->Commerce->createOrder();
            }
//        debug($order_id);
//            $this->OrderItem->Order->id = $order_id; //$this->Cookie->read('Order.hash');
            //czy rzecz już jest w koszyku?
//            $this->OrderItem->recursive = -1;
//            $orderItem = $this->OrderItem->find('first', array('conditions' => array(
//                    'OrderItem.product_model' => $this->request->data['OrderItem']['product_model'],
//                    'OrderItem.product_id' => $this->request->data['OrderItem']['product_id'],
//                    'OrderItem.order_id' => $order_id,
//                    )));
//debug($orderItem);exit;
            $this->OrderItem->create();


            //podbić ilość, jeśli rzecz już jest w koszyku
//            if (!empty($orderItem)) {
//                $this->OrderItem->id = $orderItem['OrderItem']['id'];
//            $this->OrderItem->saveField('quantity', $orderItem['OrderItem']['quantity'] + $this->request->data['OrderItem']['quantity']);
//                $this->request->data['OrderItem']['quantity'] = $orderItem['OrderItem']['quantity'] + $this->request->data['OrderItem']['quantity'];
//            }


            $orderItemFields = $this->OrderItem->$productModel->orderItemFields($this->request->data['OrderItem']['product_id']);

            $this->OrderItem->save(array('OrderItem' => $orderItemFields + array(
            'order_id' => $order_id,
            'product_model' => $this->request->data['OrderItem']['product_model'],
            'product_id' => $this->request->data['OrderItem']['product_id'],
            'quantity' => $this->request->data['OrderItem']['quantity'],
            'discount' => $this->Commerce->getTheBestDiscount(),
                    )));

            //$this->Session->setFlash(__('Produkt został dodany do koszyka', true));
        }
        $this->redirect(array('controller' => 'orders', 'action' => 'cart'));
    }
    
    public function window_configurator($order_item_id = null) {
        $this->layout = 'default';
        $order_id = $this->Commerce->getOrder();
        if (!$order_id) {
            $order_id = $this->Commerce->createOrder();
        }
        $this->OrderItem->Order->id = $order_id;
        $this->OrderItem->id = $order_item_id;
        
        if (!$this->OrderItem->exists()) {
            throw new NotFoundException('Nie ma takiego zamówienia');
        }
        
        if (!$this->OrderItem->Order->exists()) {
            throw new NotFoundException("Nie ma takiego zamówienia w koszyku");
        }
        
        if ($this->request->is('post')) {
            $this->request->data['OrderItem']['id'] = $order_item_id;
            if ($this->OrderItem->save($this->request->data, array('fieldList' => array('desc')))) {
                $this->redirect(array('controller' => 'orders', 'action' => 'cart'));
            }
        }
        
        $orderItem = $this->OrderItem->find('first',array(
            'recursive' => -1,
            'conditions' => array('OrderItem.id' => $order_item_id)
        ));
        if($order_id != $orderItem['OrderItem']['order_id']){
            $this->OrderItem->saveField('order_id',$order_id);
        }
        $this->set('orderItem', $orderItem);
        
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function admin_index() {
        $this->helpers[] = 'FebTime';
        $this->OrderItem->recursive = 0;
        $this->set('orderItems', $this->paginate());
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->OrderItem->id = $id;
        if (!$this->OrderItem->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('orderItem', $this->OrderItem->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->OrderItem->create();
            if ($this->OrderItem->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
        $orders = $this->OrderItem->Order->find('list');
        $this->set(compact('orders'));
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->OrderItem->id = $id;
        if (!$this->OrderItem->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->OrderItem->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->request->data = $this->OrderItem->read(null, $id);
        }
        $orders = $this->OrderItem->Order->find('list');
        $this->set(compact('orders'));
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
        $this->OrderItem->id = $id;
        if (!$this->OrderItem->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->OrderItem->delete()) {
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
        $params['fields'] = array('name');

        //Dodatkowe dane przekazywane z FebFormHelper-a
        //if (!empty($this->request->data['fields']['field_name'])) {
        //    $params['conditions']['OrderItem.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->OrderItem->recursive = -1;
        $params['conditions']["OrderItem.name LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->OrderItem->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }
    
    

}
