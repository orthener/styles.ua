<?php

App::uses('CommerceAppController', 'Commerce.Controller');

/**
 * Customers Controller
 *
 * @property Customer $Customer
 */
class CustomersController extends CommerceAppController {

    /**
     * Nazwa layoutu
     */
    public $layout = 'default';

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array('Filter', 'FebNumber', 'Number');

    /**
     * Tablica komponentów doładowywana do kontrolera
     */
    public $components = array('Commerce.Commerce', 'Filtering', 'Email');

    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('add', 'edit', 'my_orders_in_chart', 'my_orders_active', 'my_orders_status_ended', 'my_settings', 'my_discount', 'my_invoice', 'my_orders', 'order_item', 'order_details', 'check_email'));
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function admin_index() {
        $this->helpers[] = 'FebTime';
        $this->layout = 'admin';
        $this->Customer->recursive = 0;
        $regions = $this->Customer->InvoiceIdentityDefault->Region->find('list');
        $this->filters = array(
            'Customer.conatact_person' => array('param_name' => 'osoba', 'default' => '', 'form' => array('label' => __('Osoba kontaktowa', true))),
            'Customer.email' => array('param_name' => 'email', 'default' => '', 'form' => array('label' => __('Email', true))),
            'Customer.name' => array('param_name' => 'nazwa', 'default' => '', 'form' => array('label' => __('Nazwa / Imię i Nazwisko', true))),
            'Customer.address' => array('param_name' => 'ulica', 'default' => '', 'form' => array('label' => __('Ulica', true))),
            'Customer.post_code' => array('param_name' => 'kod', 'default' => '', 'form' => array('label' => __('Kod pocztowy', true))),
            'Customer.city' => array('param_name' => 'miejscowosc', 'default' => '', 'form' => array('label' => __d('cms', 'Miejscowość', true))),
//            'Customer.region_id' => array('param_name' => 'woj', 'default' => '', 'form' => array('options' => $regions, 'label' => __('Województwo', true), 'empty' => __('dowolne', true))),
        );
        $this->set('filtersSettings', $this->filters);
        $params = $this->Filtering->getParams();

        $paginate = $this->Customer->filterParams($this->request->data);
        $paginate['conditions']['Customer.email <>'] = null;

        $this->paginate = $paginate;
        $this->set('customers', $this->paginate());
        $this->set('filtersParams', $params);
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->Customer->id = $id;
        if (!$this->Customer->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('customer', $this->Customer->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        $this->layout = 'admin';
        if ($this->request->is('post')) {
            $this->Customer->create();
            if ($this->Customer->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
        $users = $this->Customer->User->find('list');
        $addresses = $this->Customer->Address->find('list');
        $this->set(compact('users', 'addresses'));
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->layout = 'admin';
        $this->Customer->id = $id;
        if (!$this->Customer->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Customer->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                //$this->redirect($this->request->data['Customer']['referer']);
                $this->redirect(array('admin' => 'admin', 'plugin' => 'commerce', 'controller' => 'customers', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->request->data = $this->Customer->read(null, $id);
        }
        $referer = $this->referer();
        $users = $this->Customer->User->find('list');
        $addresses = $this->Customer->Address->find('list');
        $this->set(compact('users', 'addresses', 'referer'));
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
        $this->Customer->id = $id;
        if (!$this->Customer->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->Customer->delete()) {
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
        $params['fields'] = array('contact_person');

        //Dodatkowe dane przekazywane z FebFormHelper-a
        //if (!empty($this->request->data['fields']['field_name'])) {
        //    $params['conditions']['Customer.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->Customer->recursive = -1;
        $params['conditions']["Customer.contact_person LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->Customer->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }

    function order_item($id = null) {
        if (!$id) {
            throw new NotFoundException();
        }
        $uid = $this->Auth->user('id');
        if (empty($uid)) {
            $this->Session->setFlash(__('Zaloguj się aby uzyskać dostęp do tego zasobu', true), 'flash/error');
            $this->redirect(array('plugin' => false, 'controller' => 'users', 'action' => 'login'));
        }
        $this->Customer->Order->id = $id;
        $this->Customer->Order->recursive = 1;
        $this->Customer->Order->unbindModel(array('belongsTo' => array('Customer', 'OrderStatus'), 'hasOne' => array('Invoice'), 'hasMany' => array('Note', 'Payment')));
        $actualOrder = $this->Customer->Order->read(null);

        $fileStatus = true;
        $this->set(compact('actualOrder', 'fileStatus'));
    }

    public function order_details($id = null) {
        return $this->order_item($id);
    }

    function my_orders_in_chart() {
        $uid = $this->Auth->user('id');
        if (empty($uid)) {
            $this->Session->setFlash(__('Zaloguj się aby uzyskać dostęp do tego zasobu', true), 'flash/error');
            $this->redirect(array('plugin' => false, 'controller' => 'users', 'action' => 'login'));
        }

        $this->request->data = $this->Commerce->customer;
        //debug($this->request->data);
        if (isset($this->request->data['Order'])) {
            foreach ($this->request->data['Order'] as $k => &$data) {
                if ($this->request->data['Order'][$k]['order_status_id'] != 0) {
                    unset($this->request->data['Order'][$k]);
                }
            }
        }
    }

    function my_orders_active() {
        
        if ($this->disable_shop) {
            $this->redirect(array('action' => 'my_settings', 'login'));
        }
        $uid = $this->Auth->user('id');
        if (empty($uid)) {
            $this->Session->setFlash(__('Zaloguj się aby uzyskać dostęp do tego zasobu', true), 'flash/error');
            $this->redirect(array('plugin' => 'user', 'controller' => 'users', 'action' => 'login'));
        }
//        debug($this->Commerce->customer);
        $this->request->data = $this->Commerce->customer;

//        debug($this->Commerce->customer);

        if (isset($this->request->data['Order'])) {
            foreach ($this->request->data['Order'] as $k => &$data) {
                if ($this->request->data['Order'][$k]['order_status_id'] == 0 || $this->request->data['Order'][$k]['order_status_id'] >= 60) {
                    unset($this->request->data['Order'][$k]);
                } else {
                    $this->request->data['Order'][$k]['paymentTotal'] = $this->Customer->Order->Payment->total($this->request->data['Order'][$k]['id'], 'Order', 'Commerce');
                }
            }
        } else {
            $this->request->data['Order'] = array();
        }
        $orderStatuses = $this->Customer->Order->OrderStatus->find('list');
        $this->set(compact('orderStatuses'));
    }

    function my_orders_status_ended() {
        $uid = $this->Auth->user('id');
        if (empty($uid)) {
            $this->Session->setFlash(__('Zaloguj się aby uzyskać dostęp do tego zasobu', true), 'flash/error');
            $this->redirect(array('plugin' => 'user', 'controller' => 'users', 'action' => 'login'));
        }
        $this->request->data = $this->Commerce->customer;

        if (isset($this->request->data['Order'])) {
            foreach ($this->request->data['Order'] as $k => &$data) {
                if ($this->request->data['Order'][$k]['order_status_id'] < 60) {
                    unset($this->request->data['Order'][$k]);
                } else {
                    $this->request->data['Order'][$k]['paymentTotal'] = $this->Customer->Order->Payment->total($this->request->data['Order'][$k]['id'], 'Order', 'Commerce');
                }
            }
        } else {
            $this->request->data['Order'] = array();
        }
    }

    public function check_email() {
        if ($this->request->is('post')) {
            $this->loadModel('User');
//            pr($this->request->data);
            $flag = !$this->Customer->validateUniqueEmail($this->request->data, null);

            $this->set('flag', $flag);
            $this->set('_serialize', array('flag'));
        }
        $this->render(false);
    }

    function my_settings($type = null) {
        //debug($type);
        $this->helpers[] = 'Jcrop.Jcrop';
        $uid = $this->Auth->user('id');
        //debug($uid);
        if (empty($uid)) {
            $this->Session->setFlash(__('Zaloguj się aby uzyskać dostęp do tego zasobu', true), 'flash/error');
            $this->redirect(array('plugin' => 'user', 'controller' => 'users', 'action' => 'login'));
        }
        if (!$type) {
            $this->redirect(array('action' => 'my_settings', 'contact'));
        }

        //$this->request->data['User']['email'] = $this->Commerce->customer['User']['email'];
        $countries = $this->Customer->Address->Country->find('list');
        $regions = $this->Customer->Address->Region->find('list');
        $this->set(compact('countries', 'regions'));

        $customer = $this->Commerce->customer;
        //debug($customer);
        $this->set(compact('customer'));
        if (!empty($this->request->data)) {
            $this->request->data['InvoiceIdentityDefault']['id'] = $customer['InvoiceIdentityDefault']['id'];
            $this->request->data['InvoiceIdentityDefault']['customer_id'] = $customer['Customer']['id'];
            $this->request->data['AddressDefault']['id'] = $customer['AddressDefault']['id'];
            $this->request->data['AddressDefault']['customer_id'] = $customer['Customer']['id'];

            //$this->Customer->create();
            if (isset($this->request->data['User']['email']))
                unset($this->request->data['User']['email']); //Brak mozliwosci zmiany emaila

                
//Jezeli jest ustawione haslo
            if (!empty($this->request->data['User']['newpass']) || !empty($this->request->data['User']['oldpass'])) {

                $this->request->data['User']['id'] = $customer['User']['id'];

                $this->Customer->User->id = $customer['User']['id'];
                $password = $this->Customer->User->field('pass');

                if ($password !== $this->Auth->password($this->request->data['User']['oldpass'])) {
                    $this->Session->setFlash(__('Podaj poprawne hasło', true), 'flash/error');
                    $this->Customer->User->validationErrors = array('oldpass' => 'Podaj poprawne hasło');
                    return false;
                }


                if (($this->request->data['User']['newpass'] === $this->request->data['User']['confirmpass']) && !empty($this->request->data['User']['newpass'])) {
                    $this->request->data['User']['pass'] = $this->Auth->password($this->request->data['User']['newpass']);
                } else {
                    //nowe haslo nie zgadza sie
                    $this->Session->setFlash(__('Sprawdź formularz i spróbuj ponownie', true), 'flash/error');
                    $this->Customer->User->validationErrors = array('newpass' => 'hasła się nie zgadzaja', 'confirmpass' => 'powtórzone hasło jest inne');
                    $this->request->data['User']['email'] = $this->Commerce->customer['User']['email'];
                    return false;
                }
            }

            $user = $this->Customer->User->read(null, $this->request->data['User']['id']);
            $old_avatar = $user['User']['avatar'];
            if ($old_avatar != $this->request->data['User']['avatar'] && !empty($this->request->data['User']['avatar'])) {
                if (!empty($old_avatar)) {
                    unlink(APP . WEBROOT_DIR . DS . 'files' . DS . 'user' . DS . $old_avatar);
                }
            }
            if ($this->Customer->saveAll($this->request->data)) {
                if (!empty($this->request->data['User']['newpass']) || !empty($this->request->data['User']['oldpass'])) {

                    if ($this->Session->check('Auth.User.id')) {
                        $this->Customer->User->logAction('Wylogowano poprawnie', $this->Session->read('Auth.User.id'));
                    }
                    if ($this->Cookie->read('Auth.User')) {
                        $this->Cookie->delete('Auth.User');
                    }
                    $this->Session->setFlash(__('Hasło zostało poprawnie zmienione. Zaloguj ponownie.', true));
                    $this->Session->delete('Permissions');
                    $redirect_url = $this->Auth->logout();
                    //$this->Session->destroy();
                    $this->redirect(array('plugin' => 'user', 'controller' => 'users', 'action' => 'login'));
                }
                $user = $this->Customer->User->read(null, $this->request->data['User']['id']);
                $this->Session->setFlash(__('Dane zostaly poprawnie zapisane.', true));
                $this->redirect(array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'my_settings', 'login'));
            } else {
                $this->Session->setFlash(__('Sprawdź formularz i spróbuj ponownie!', true), 'flash/error');
            }
        } else {
            $this->request->data = $customer;
        }
    }

    function my_discount() {
        $uid = $this->Auth->user('id');

        if (!empty($uid)) {
            //Program Partnerski
            $customer = $this->Commerce->customer;
            $affiliateDiscountForCustomer = $this->Commerce->getAffiliateDiscountForCustomer();
            $affiliateLevels = $this->Commerce->affiliateProgram;

            $toNextLevel = $this->Commerce->getTotalPriceForNextAffiliateLevel();
            $total = $this->Commerce->totalCustomerSummaryOrders;
        } else {
            $this->loadModel('Commerce.AffiliateProgram');
            $affiliateLevels = $this->AffiliateProgram->find('all', array('order' => 'AffiliateProgram.minimum ASC'));
        }

        $this->loadModel('Page');
        $page = $this->Page->find('first', array('conditions' => array('Page.slug' => 'program-partnerski')));
        $this->set(compact('customer', 'affiliateDiscountForCustomer', 'affiliateLevels', 'page', 'toNextLevel', 'total'));
    }

    function my_invoice() {
        $uid = $this->Auth->user('id');
        if (empty($uid)) {
            $this->Session->setFlash(__('Zaloguj się aby uzyskać dostęp do tego zasobu', true), 'flash/error');
            $this->redirect(array('plugin' => false, 'controller' => 'users', 'action' => 'login'));
        }
        $this->request->data = $this->Commerce->customer;
    }

//    function my_orders() {
//        $uid = $this->Auth->user('id');
//        if (empty($uid)) {
//            $this->Session->setFlash(__('Zaloguj się aby uzyskać dostęp do tego zasobu', true), 'flash/error');
//            $this->redirect(array('plugin' => 'user', 'controller' => 'users', 'action' => 'login'));
//        }
//        
//        $this->request->data = $this->Commerce->customer;
//
//        if (isset($this->request->data['Order'])) {
//            foreach ($this->request->data['Order'] as $k => &$data) {
//                $this->request->data['Order'][$k]['paymentTotal'] = $this->Customer->Order->Payment->total($this->request->data['Order'][$k]['id'], 'Order', 'Commerce');
//            }
//        } else {
//            $this->request->data['Order'] = array();
//        }
//
//        $orderStatuses = $this->Customer->Order->OrderStatus->find('list');
//        $this->set(compact('orderStatuses'));
//    }

    function add() {
        $order_id = $this->Commerce->getOrder();
        $order = $this->Customer->Order->read(null, $order_id);
        if (!empty($this->Commerce->customer['Customer']['id'])) {
            $this->redirect(array('action' => 'edit', $order['Customer']['id']));
        }
    }

    function edit() {
        $myUser = $this->Session->read('Auth.User');
        $this->set(compact('myUser'));


        $order_id = $this->Commerce->getOrder();

        //$customer = $this->Commerce->customer;
        //debug($customer);
        //if (!$order_id) $this->redirect('/');
        //debug($id);
        $this->Customer->Order->recursive = 1;
        $order = $this->Customer->Order->read(null, $order_id);

//        debug($order); exit;

        if (!empty($this->request->data)) {

            //Jezeli dane do wysylki inne niz do faktury
            if (empty($this->request->data['Customer']['dane_do_wysylki_inne_niz_do_faktury'])) {
                $this->request->data['AddressDefault'] = $this->request->data['InvoiceIdentityDefault'];
            }
//            
            //Jezeli Nie jest zalogowany, proboje zrobic usera
            if (empty($myUser)) {
                //Jezeli ustawil aby go zarejestrowac
                if (isset($this->request->data['Customer']['register_me'])) {
                    $this->request->data['Customer']['user_id'] = $this->createUser();
                }
            } else {
                $this->request->data['Customer']['user_id'] = $myUser['id'];
            }
            //$customer = $this->Customer->findById($id);   

            $this->request->data['AddressDefault']['id'] = $order['Customer']['address_id'];
            $this->request->data['AddressDefault']['customer_id'] = $order['Customer']['id'];
            $this->request->data['InvoiceIdentityDefault']['id'] = $order['Customer']['invoice_identity_id'];
            $this->request->data['InvoiceIdentityDefault']['customer_id'] = $order['Customer']['id'];
            $this->request->data['Customer']['id'] = $order['Customer']['id'];

            //if ($this->Customer->save($this->request->data) AND $this->Customer->InvoiceIdentityDefault->save($this->request->data) AND $this->Customer->AddressDefault->save($this->request->data) AND $this->request->data['Customer']['user_id'] != -2) {
            if ($this->request->data['Customer']['user_id'] != -2 AND $this->Customer->saveAll($this->request->data, array('validate' => 'first'))) {

                $customer = $this->Customer->find('first', array('recursive' => -1, 'conditions' => array('Customer.id' => $order['Customer']['id'])));

                $this->Customer->AddressDefault->recursive = -1;
                $this->Customer->InvoiceIdentityDefault->recursive = -1;

                $toSave['Order'] = array(
                    'id' => $order_id,
                    'address' => json_encode($this->Customer->AddressDefault->findById($customer['Customer']['address_id'])),
                    'invoice_identity' => json_encode($this->Customer->InvoiceIdentityDefault->findById($customer['Customer']['invoice_identity_id']))
                );

                //debug($toSave);
                $this->Customer->Order->save($toSave);
                //exit(1);
                $this->redirect(array('controller' => 'orders', 'action' => 'summary'));
            } else {
                $this->Customer->InvoiceIdentityDefault->saveAll($this->request->data, array('validate' => 'only'));
                $this->Customer->AddressDefault->saveAll($this->request->data, array('validate' => 'only'));
                $this->Session->setFlash(__d('public', 'Twoje zamówienie nie zostało zapisane. Sprawdź formularz i popraw odpowiednie dane.', true), 'flash/error');
            }
        }

        if (empty($this->request->data)) {

            //$customer = $this->Order->Customer->findById($id);
            $customer = $this->Commerce->customer;
            if ($customer != null) {
                $this->request->data['Customer'] = $customer['Customer'];
                $this->request->data['InvoiceIdentityDefault'] = $customer['InvoiceIdentityDefault'];
                $this->request->data['AddressDefault'] = $customer['AddressDefault'];

                if (!empty($customer['User'])) {
                    $this->request->data['Customer']['email'] = $customer['User']['email'];
                }
            } else {
                $this->request->data['InvoiceIdentityDefault']['iscompany'] = '1';
            }
            if (empty($this->request->data['InvoiceIdentityDefault']['iscompany'])) {
                $this->request->data['InvoiceIdentityDefault']['iscompany'] = '0';
            }

            $this->request->data['Customer']['dane_do_wysylki_inne_niz_do_faktury'] = 0;
            if (empty($this->request->data['InvoiceIdentityDefault']['country_id'])) {
                $this->request->data['InvoiceIdentityDefault']['country_id'] = 'DE';
                $this->request->data['InvoiceIdentityDefault']['region_id'] = 9;
            }
            if (empty($this->request->data['AddressDefault']['country_id'])) {
                $this->request->data['AddressDefault']['country_id'] = 'DE';
                $this->request->data['AddressDefault']['region_id'] = 9;
            }

            foreach ($this->request->data['AddressDefault'] AS $key => $value) {
                if (!in_array($key, array('id', 'created', 'modified', 'phone'))) {
                    if ($this->request->data['AddressDefault'][$key] != $this->request->data['InvoiceIdentityDefault'][$key]) {
                        $this->request->data['Customer']['dane_do_wysylki_inne_niz_do_faktury'] = 1;
                        break;
                    }
                }
            }
            $this->request->data['Customer']['register_me'] = 1;
            $this->request->data['InvoiceIdentityDefault']['iscompany'] = 0;
        }

        $regions = $this->Customer->Address->Region->find('list');
        $countries = $this->Customer->Address->Country->find('list');

        $hidenCart = true;
        $this->set(compact('regions', 'countries', 'hidenCart'));
    }

    private function createUser() {
        if ($this->request->data['Customer']['register_me'] == 1) {
            $data = array(
                'User' => array(
                    'name' => $this->request->data['Customer']['contact_person'],
                    'email' => $this->request->data['Customer']['email'],
                )
            );
            $not_unique = $this->Customer->User->find('count', array('conditions' => array('User.name' => $this->request->data['Customer']['contact_person'])));
            if ($not_unique) {
                $data['User']['name'] = $this->request->data['Customer']['email'];
            }

            $users_alias = 'users';
            $this->Customer->User->Group->recursive = -1;
            $group = $this->Customer->User->Group->find('first', array('conditions' => array('Group.alias' => $users_alias), 'fields' => array('id')));
            $users_group_id = $group['Group']['id'];
            $data['Group']['Group'][] = $users_group_id;

            $this->Customer->User->create();
            if (!$this->Customer->User->saveAll($data, array('validate' => 'only'))) {
                $this->Session->setFlash(__('Błąd. Sprawdź formularz i spróbuj ponownie.', true), 'flash/error');
                return -2;
            }

            $assigned_password = "password";
            $data['User']['pass'] = $this->Auth->password($assigned_password);
            //$data['User']['active'] = 1;
            $this->Auth->userScope = array();
            if ($this->Customer->User->save($data)) {

                $user = $this->Customer->User->findById($this->Customer->User->getInsertID());
                $user['User']['md5'] = md5($user['User']['created']);
                $this->set('user', $user);

                App::uses('FebEmail', 'Lib');
                $email = new FebEmail('public');

                $email->viewVars(array('user' => $user));
                $email->template('User.user_register')
                        ->emailFormat('both')
                        ->to(array($user['User']['email'] => $user['User']['email']))
                        ->from(array(Configure::read('App.WebSenderEmail') => Configure::read('App.WebSenderName')))
                        ->subject(__d('email', '[www] Przejdź do aktywacji konta', true));
                $email_sent = $email->send();
                $email->reset();




                $user = $this->Customer->User->recursive = -1;
                $user = $this->Customer->User->find('first', array('conditions' => array('User.email' => $data['User']['email'])));

                if ($this->Auth->login($user['User'])) {
                    $this->Session->setFlash(__('Konto zostało utworzone. Odbierz pocztę email aby ustawić hasło do konta. Zostałeś zalogowany, możesz dokończyć proces zamówienia.', true));
                    //Powiazanie z zamówieniem jako user_id
                    return $user['User']['id'];
                }

                $this->Session->setFlash(__('Error 0', true), 'flash/error');
                return null;
            } else {
                $this->Session->setFlash(__('Błąd. Sprawdź formularz i spróbuj ponownie.', true), 'flash/error');
                return null;
            }
        }
    }

}
