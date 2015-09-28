<?php

App::uses('Commerce.Commerce', 'Vendor');

class CommerceComponent extends Component {

    var $components = array('Session');
    var $controller = null;
    var $theBestDiscount = 0;
    public static $customer = null;
    public static $customerOrders = array();

    function startup(&$controller) {
        $this->controller = &$controller;
        $user_id = $this->Session->read('Auth.User.id');
        if ($user_id) {
            $this->controller->loadModel('Commerce.Customer');
            $params['conditions']['Customer.user_id'] = $user_id;
            $this->controller->Customer->recursive = 1;
            $customer = $this->controller->Customer->find('first', $params);
            self::$customer = $this->initCustomer($customer);
        }
    }

    function getCustomerOrdersByUserId($user_id) {
        $this->controller->loadModel('Commerce.Customer');
        $params['conditions']['Customer.user_id'] = $user_id;
        $params['fields'] = array('id');
        $this->controller->Customer->recursive = -1;
        $customer = $this->controller->Customer->find('first', $params);
        $params2['conditions']['Order.customer_id'] = $customer['Customer']['id'];
        $params2['fields'] = array('id');
        $this->controller->Customer->Order->recursive = -1;
        $orders = $this->controller->Customer->Order->find('list', $params2);
        return $orders;
    }
    
    function getMyOrders() {
        $user_id = $this->Session->read('Auth.User.id');
        return $this->getCustomerOrdersByUserId($user_id);
    }
    
    function iAmOrderOwner($order_id){
        $myOrders = $this->getMyOrders();
        if (in_array($order_id, $myOrders)) {
            return true;
        } else {
            return false;
        }
        
    }

    private function createCustomer($userId=null) {
        $this->controller->loadModel('Commerce.Order');
        $this->controller->loadModel('Commerce.Customer');
        $this->controller->loadModel('Commerce.AddressDefault');
        $this->controller->loadModel('Commerce.InvoiceIdentityDefault');
        //Wybieram klienta na podstawie usera

        $customer['Customer']['user_id'] = $userId;
        $this->controller->Customer->create();
        $this->controller->Customer->save($customer);
        $customer['Customer']['id'] = $this->controller->Customer->getInsertID();


        $this->controller->Customer->AddressDefault->create();
        $this->controller->Customer->AddressDefault->saveField('customer_id', $customer['Customer']['id']);
        $this->controller->Customer->InvoiceIdentityDefault->create();
        $this->controller->Customer->InvoiceIdentityDefault->saveField('customer_id', $customer['Customer']['id']);

        $address_id = $this->controller->Customer->AddressDefault->getInsertID();
        $invoice_identity_id = $this->controller->Customer->InvoiceIdentityDefault->getInsertID();

        $customer['Customer']['address_id'] = $address_id;
        $customer['Customer']['invoice_identity_id'] = $invoice_identity_id;

        //debug($customer);

        $this->controller->Customer->save($customer);
        return $customer;
    }

    function createOrder() {
//        debug('Tworze zamowienie!!');

        $this->controller->loadModel('Commerce.Order');
        $data = array('Order' => array());
        $myUser = $this->controller->Session->read('Auth.User');
        if (!empty($myUser)) { //jeżeli user jest zalogowany
            //Wyciągam jego 
            $data['Order']['customer_id'] = $this->customer['Customer']['id'];

        }
//        debug($data);      
        $this->controller->Order->create();
        $this->controller->Order->save($data);

        $id = $this->controller->Order->getInsertID();
        $this->controller->Order->id = $id;
        $year = date('Y');
        
        //debug($id);

        if (!empty($myUser)) { //jeżeli user jest zalogowany
            $this->controller->Order->saveField('hash', "{$id}/{$data['Order']['customer_id']}/{$year}");
        } else {
            $this->controller->Order->saveField('hash', "{$id}/0/{$year}");
        }

//        debug('ID UTWORZONGO ZAMOWIENIA');
//        debug($id);
//        exit(1);
        $this->controller->Cookie->write('Order.hash', $id, true, '+' . $this->controller->Order->cookieLifeTime . ' Hours');
        $_COOKIE['CakeCookie']['Order']['hash'] = "Q2FrZQ==." . base64_encode(Security::cipher($id, Configure::read('Security.salt')));

        return $id;
    }

//
//    function marageOrder($id, $customer_id) {
//        
//    }
    function getOrder() {
        $this->controller->loadModel('Commerce.Order');
        $this->controller->loadModel('Commerce.Customer');
//        debug('Pobieram ID');

//        $id = $this->controller->Session->read('Auth.User.id');
//        $user_id = !empty($id) ? $this->controller->Session->read('Auth.User.id') : false;
        $user_id = false;
        $order_id = $this->controller->Cookie->read('Order.hash');
        
        if ($order_id) {
            $params['conditions']['Order.id'] = $order_id;
            $params['conditions']['Order.order_status_id'] = 0;
            if (!$this->controller->Order->find('count', $params)) {
                $order_id = false;
            }
        }
        

        if (empty($user_id)) {
            if (!$order_id) {
                return false;
            }

            //Uzytkownik nie zalogowany
//            debug('Uzytkownik nie zalogowany');

            $this->controller->Order->id = $order_id;
            $customer_id = $this->controller->Order->field('customer_id');

            $this->customer = $this->controller->Customer->findById($customer_id);

            if (empty($this->customer)) {
//                debug("Nie jest klientem! Wyszukalem na pdostawie tego co jest w Order");
                $this->customer = $this->createCustomer();
                //Powiazuje z zamowieniem
//                debug("Dodalem go do klientow");
                $this->controller->Order->saveField('customer_id', $this->customer['Customer']['id']);
//                debug("Powiazalem z Orders");
            }// else {
//                debug("Jest JUZ Klientem o CUSTOMER_ID:");
//                debug($this->customer['Customer']['id']);
//            }
//            debug("Wybieram zamowienie dla danego order_id");
            //Czy Order przypisany jest do jakiegos klienta - ktory jest uzytkownikiem
//            debug("Czy Order przypisany jest do jakiegos klienta - ktory jest uzytkownikiem");
            if (empty($this->customer['Customer']['user_id'])) {
//                debug("NIE! Zaracam order_id");      
                return $order_id;
            } else {
                return $order_id;
//                debug("TAK!");
//                debug("Usuwam Ciasteczko i ID!");
                $this->controller->Cookie->delete('Order.hash');
                return false;
            }
//            break;
        } else {
            //Użytkownik zalogowany
//            debug("Jestem zalogowany");

            $customerFromUser = $this->controller->Customer->findByUserId($user_id);
            $customerFromUserFull = $customerFromUser;
            $customerFromUser = empty($customerFromUser) ? false : $customerFromUser['Customer']['id'];
            $cartFromUser = $this->controller->Order->find('first', array('conditions' => array('Order.customer_id' => $customerFromUser, 'Order.order_status_id' => 0), 'order' => 'Order.modified DESC'));
            $this->controller->Order->id = $order_id;
            $customerFromOrder = $order_id ? $this->controller->Order->field('customer_id') : false;

            if (!$order_id AND !$cartFromUser) {
                return false;
            } elseif (!$order_id) {
                $order_id = $cartFromUser['Order']['id'];
                $this->controller->Cookie->write('Order.hash', $order_id, true, '+' . $this->controller->Order->cookieLifeTime . ' Days');
                $_COOKIE['CakeCookie']['Order']['hash'] = "Q2FrZQ==." . base64_encode(Security::cipher($order_id, Configure::read('Security.salt')));
            }
            if ($customerFromUser) {
//                debug('Customer jest w powiazany z userem');
                $this->controller->Order->id = $order_id;
                $this->controller->Order->saveField('customer_id', $customerFromUser);
                $this->controller->Cookie->delete('Order.hash');
                $this->customer = $customerFromUserFull;
            } else if ($customerFromOrder) {
//                debug('Customer jest w powiazany z zamówieniem');
                $this->controller->Customer->id = $customerFromOrder;
                $this->customer = $this->controller->Customer->findById($customerFromOrder);
                $this->controller->Customer->saveField('user_id', $user_id);
            } else {
//                debug('Tworze uzytkownika');
                $this->customer = $this->createCustomer($user_id);
                $this->controller->Order->id = $order_id;
                $this->controller->Order->saveField('customer_id', $this->customer['Customer']['id']);
            }

            return $order_id;
        }
    }

    function getAffiliateDiscountForCustomer() {
        if (empty($this->affiliateProgram)) {
            $this->controller->loadModel('Commerce.AffiliateProgram');
            $this->affiliateProgram = $this->controller->AffiliateProgram->find('all', array('order' => 'AffiliateProgram.minimum ASC'));
        }

        if ($this->totalCustomerSummaryOrders === null) {
            $this->controller->loadModel('Commerce.Order');
    
            //debug($orderStatuses);

            $this->controller->Order->recursive = 1;
            $params['conditions']['Order.customer_id'] = $this->customer['Customer']['id'];
            $params['conditions']['Order.order_status_id'] = $this->controller->Order->OrderStatus->findStatuses(2);
            $params['fields'][] = "SUM(`total`) as `suma`";

            $this->controller->Order->recursive = -1;
            $totalCustomerSummaryOrders = $this->controller->Order->find('first', $params);
            $this->totalCustomerSummaryOrders = $totalCustomerSummaryOrders[0]['suma'];
            if($this->totalCustomerSummaryOrders == null){
                $this->totalCustomerSummaryOrders = 0;
            }
        }
        if (empty($this->totalCustomerSummaryOrders)) {
            return 0;
        }
        $this->discountFromAfiliateProgram = 0;
        foreach ($this->affiliateProgram as $key => $level) {
            if ($level['AffiliateProgram']['minimum'] < $this->totalCustomerSummaryOrders) {
                $this->discountFromAfiliateProgram = $level['AffiliateProgram'];
            }
        }
        return $this->discountFromAfiliateProgram;
    }

    function getTotalPriceForNextAffiliateLevel() {
        $toNextLevel = false;
        $best = $this->getTheBestDiscount();
        $count = count($this->affiliateProgram);
        if (!$best) {
            $toNextLevel = $this->affiliateProgram[0]['AffiliateProgram']['minimum'] - $this->totalCustomerSummaryOrders;
        } else if ($best >= $this->affiliateProgram[$count-1]['AffiliateProgram']['discount']) {
            //debug('cos');
        } else {
            foreach($this->affiliateProgram as $k => $level) {
                if ($best < $level['AffiliateProgram']['discount']) {
//                     if ($count == ($k+1)) {
//                         $toNextLevel = $this->affiliateProgram[$k]['AffiliateProgram']['minimum'] - $this->totalCustomerSummaryOrders;
//                     } else {
                         $toNextLevel = $this->affiliateProgram[$k]['AffiliateProgram']['minimum'] - $this->totalCustomerSummaryOrders;
                         break;
//                     }
                }
            }    
        }
        return $toNextLevel;
    }
    
    
    function initCustomer($customer) {
        //usuwanie zmiennych 

        $this->discountFromAfiliateProgram = null;
        $this->totalCustomerSummaryOrders = null;
        $this->theBestDiscount = 0;

        $this->customer = $customer;
        //Można podać albo calą tablice klienta, albo tylko jego numer ID
        if (!is_array($this->customer)) {
            $this->controller->loadModel('Commerce.Customer');


            //$this->Recipe->unbindModel(array('hasOne' => array('RecipesTag')));

            $this->controller->Customer->recursive = 1;

            $params['conditions']['Customer.id'] = $this->customer;
            $this->customer = $this->controller->Customer->find('first', $params);
        }
        return $this->customer;
    }

    function getTheBestDiscount() {
        //To-Do zbadać dlaczego zmienna musi być statyczna
        $this->customer = self::$customer;
        if (!$this->theBestDiscount) {
            if (empty($this->customer)) {
                return 0;
            }
            $this->discountFromAfiliateProgram = $this->getAffiliateDiscountForCustomer(); //$this->customer['Customer']['id']);
            //debug($this->discountFromAfiliateProgram);

            if ($this->discountFromAfiliateProgram['discount'] > $this->customer['Customer']['discount']) {
                $this->theBestDiscount = $this->discountFromAfiliateProgram['discount'];
            } else {
                $this->theBestDiscount = $this->customer['Customer']['discount'];
            }
            
//            debug($this->theBestDiscount);
//        echo 'wtk'; exit;
        }

        return $this->theBestDiscount;
    }

    function getDiscountPriceFromCustomer($standardPrice, $option=false) {

        //To-Do Dokończyć pomysł aby pobierać cenę z upustem w zależnośći od tego czego potrzebuję
//        switch ($option) {
//            case AFFILIATE_PROGRAM:
//
//
//                break;
//            case ONLY_CUSTOMER_SELF:
//                break;
//            
//            case ONLY_FROM_AFFILIATE_PROGRAM:
//                
//                break;
//        }
        //To-Do zbadać dlaczego zmienna musi być statyczna
        $this->customer = self::$customer;
        if (empty($this->customer)) {
            return $standardPrice;
        }
        $theBestDiscount = $this->getTheBestDiscount();
        //calculateByPriceType
        $theBestPriceForProduct = Commerce::recalculatePriceWhereDiscount($standardPrice, $theBestDiscount);

        return $theBestPriceForProduct;
    }


    //SELECT * FROM `shipment_method_configs` WHERE `shipment_method_id` = 2 AND `weight` >= 30.2 ORDER BY `price` ASC LIMIT 1
}

?>