<?php

App::uses('AppController', 'Controller');
App::uses('FacebookApi', 'Facebook.Lib');

class UsersController extends AppController {

    public $name = 'Users';
    public $components = array('Email', 'Cookie', 'Filtering');
    public $helpers = array('FebForm');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('new_pass', 'pass_recall', 'login', 'logout', 'register', 'ajaxlogin', 'activate', 'new_pass', 'register_by_facebook_check', 'admin_reset', 'login_facebook', 'register_by_facebook', 'facebook_register_ok', 'rules', 'register_by_facebook_non_auth', 'register_ok', 'user_ajax_pass_check', 'admin_back_login');
        if (Configure::read('Facebook.on')) {
            $this->components[] = "'Facebook.Connect'";
        }
    }

    /**
     * Standardowe Funkcje
     */
    function login() {
        if ($this->Session->check('Auth.User.id')) {
            if ($this->Session->check('Auth.Groups.admins')) {
                $this->layout = 'admin';
            } else {
                $this->layout = 'default';
            }
        } else {
//            $this->layout = 'login';
            $this->remember();
        }
        $this->login_check();
    }

    function ajaxlogin() {
        if ($this->request->is('ajax')) {
            $this->render('/Elements/Users/ajaxlogin');
            if ($loginAuth = $this->Auth->login($this->request->data['User'])) {
                $this->render(false);
            } else {
                $this->Session->setFlash(__d('users', 'Nieprawodłowy login lub hasło'));
            }
        }
        $this->set('loginAuth', $loginAuth);
        unset($this->request->data['User']['pass']);

        $this->render('/Elements/Users/ajaxlogin');
    }

    private function remember($user = null) {
        //lowanie za pomocą ciasteczka
        if (empty($this->request->data)) {
            $cookie = $this->Cookie->read('Auth.User');
            if (!is_null($cookie)) {
                $this->User->recursive = -1;
                $user = $this->User->find('first', array('conditions' => array('User.remember' => $cookie['remember']), 'fields' => array('User.id', 'User.name', 'User.email', 'User.remember')));
                $rememberCheck = $this->Auth->password($user['User']['id'] . '|' . $cookie['time']);
                if (
                //sprawdzam czy has zgadza sie z tym co jest w bazie
                        ($rememberCheck == $user['User']['remember']) and
                        //sprawdzam czy ciastko jest aktualne
                        ($cookie['time'] > strtotime('-2 weeks'))
                ) {
                    $auth = array();
                    $auth['id'] = $user['User']['id'];
                    $auth['email'] = $user['User']['email'];
                    $auth['name'] = $user['User']['name'];
                    //proba logowania
                    $this->Auth->login($auth);
                    $this->redirectAuth($user);
                } else { // Delete invalid Cookie
                    $this->Cookie->delete('Auth.User');
                }
            }
        }
    }

    function admin_login_like($user_id = null) {

        $this->User->id = $user_id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__d('users', 'Nie ma takiego użytkownika'));
        }

        $user = $this->User->findById($user_id);
        $user['User']['_referer_id'] = $this->Auth->user('id');
        $user['User']['_referer_name'] = $this->Auth->user('name');
        $user['User']['_referer_email'] = $this->Auth->user('email');
        $user['User']['_referer_back_redirect'] = $this->referer();

        $this->Auth->login($user['User']);
        $this->Session->setFlash(__d('users', 'Korzystasz z panelu jako ' . $user['User']['name'] . ' (' . $user['User']['email'] . ')'));
        $this->redirect('/admin');
    }

    function admin_back_login() {
        if ($this->Auth->user('_referer_id')) {
            $this->User->id = $this->Auth->user('_referer_id');
            if (!$this->User->exists()) {
                throw new NotFoundException(__d('users', 'Nie ma takiego użytkownika'));
            }
            $user = $this->User->findById($this->User->id);
            $this->Auth->login($user['User']);

            $this->Session->setFlash(__d('users', 'Przełączono użytkownika na ' . $user['User']['name'] . ' (' . $user['User']['email'] . ')'));
        }

        $this->redirect($this->referer());
    }

    public function ajax_pass_check() {
        $this->layout = false;
        $status = 0;
        $redirect = false;
        $notification = array(
            'title' => __d('users', "Błędna dane logowania"),
            'content' => __d('users', "Wprowadzony login bądź hasło jest niepoprawny. Pamiętaj, że wielkość liter ma znaczenie."),
            'icon' => "!"
        );
        $user = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'])));
        if ($this->Auth->password($this->request->data['User']['pass']) == $user['User']['pass']) {
            $this->Auth->login($user['User']);
            $status = 1;
            $redirect = $this->redirectAuth($user);
        }
        $this->set(compact('status', 'redirect', 'notification', 'user'));
        $this->set('_serialize', array('status', 'redirect', 'notification', 'user'));
//            $this->render(false);
    }

    public function user_ajax_pass_check() {
        $this->layout = false;
        $status = 0;
        $redirect = false;
        $notification = array(
            'title' => __d('users', "Błędna dane logowania"),
            'content' => __d('users', "Wprowadzony login bądź hasło jest niepoprawny. Pamiętaj, że wielkość liter ma znaczenie."),
            'icon' => "!"
        );
        $user = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'])));
        if ($this->Auth->password($this->request->data['User']['pass']) == $user['User']['pass']) {
            $this->Auth->login($user['User']);
            $status = 1;
        }
//        pr($user);
        $this->set(compact('status', 'notification', 'user'));
        $this->set('_serialize', array('status', 'notification', 'user'));
    }

    private function login_check() {
        //Sprawdzenie czy prawidlowy formularz zostal przeslany
        if (!empty($this->request->data)) {
            //log do logowania:
            $this->User->recursive = -1;
            $user = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'])));

            //jesli konto nie jest aktywne - inny komunikat
            if (!empty($user) && $user['User']['active'] == 0) {
                $this->User->logAction('Próba logowania - nieaktywowane konto', $user['User']['id'], $user['User']['name'], $user['User']['email']);
                $this->register_email($user);

                $this->Session->setFlash(__d('users', "Logowanie nie jest możliwe, ponieważ konto nie zostało aktywowane. 
                Na Twój adres email wysłana została wiadomość z linkiem aktywacyjnym, sprawdź pocztę email.
                W razie problemów z aktywacją konta skontaktuj się z nami pod adresem").
                " <a href=\"mailto:" . Configure::read('App.AdminEmail') . "\">" . Configure::read('App.AdminEmail') . "</a>", 'flash/warning', array(), 'auth');

                return true;
            }
            if ($this->Auth->password($this->request->data['User']['pass']) == $user['User']['pass']) {
                $data['id'] = $user['User']['id'];
                $data['name'] = $user['User']['name'];
                $data['email'] = $user['User']['email'];
                $this->Auth->login($data);

                //remember przygotowanie ciasteczka
                if (isset($this->request->data['User']['remember']) AND $this->request->data['User']['remember'] == 1) {
                    $cookie = array();
                    $this->User->recursive = -1;
                    $user = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email']), 'fields' => 'User.id'));
                    if ($user) {
                        $cookie['id'] = $user['User']['id'];
                        $cookie['time'] = time();

                        $cookie['remember'] = $this->Auth->password(implode('|', $cookie));
                        unset($cookie['id']);

                        $this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');

                        $this->User->id = $user['User']['id'];
                        $this->User->saveField('remember', $cookie['remember']);

                        //unset($this->request->data['User']['zapamietaj']);
                    }
                }
                if (!empty($this->request->data['User']['from_shopping_step'])) {
                    $this->Session->write('Auth.redirect', Router::url(array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'summary')));
                }
                if (!empty($this->request->data['User']['from_home_page'])) {
                    $this->Session->write('Auth.redirect', Router::url($this->request->data['User']['from_home_page']));
                }
                $params['conditions']['User.id'] = $user['User']['id'];
                $params['recursive'] = 1;
                $userGroup = $this->User->find('first', $params);
                unset($this->request->data);
                $this->User->logAction(__d('users', 'Zalogowano poprawnie'), $user['User']['id']);
                $this->Session->setFlash(__d('users', 'Zalogowano poprawnie', true), 'flash/confirm');
                
//                debug($userGroup);
//                exit;
                foreach($userGroup['Group'] as $groups){
                    if($groups['alias'] == 'superAdmins' || $groups['alias'] == 'admins') {
                        $this->redirect('/admin');
                    } elseif (!empty($userGroup['Customer']['user_id']) && $userGroup['Customer']['user_id'] == $user['User']['id']){
                        $this->redirect(array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'my_orders_active'));
                    }
                }
//                exit;

//                $this->redirect('/');
                //            $this->redirect(array('admin' => 'admin', 'plugin' => false, 'controller' => false, 'action' => 'index'));
                //$this->redirect('/admin');
                $this->redirect($this->referer());
                $this->redirectAuth($user);
            } else {
                if (!empty($user)) {
                    $this->User->logAction('Próba zalogowania - błędne hasło', $user['User']['id'], $user['User']['name'], $user['User']['email']);
                    $this->Session->setFlash(__d('users', 'Błędne hasło'));
                } else {
                    $this->User->logAction('Próba zalogowania - błędny login', 0, $this->request->data['User']['email'], $this->request->data['User']['email']);
                    $this->Session->setFlash(__d('users', 'Błędny login'));
                }
            }
        }
    }

    private function redirectAuth($user = null) {
        $redirect = null;
        $redirect = $this->Session->read('Auth.redirect');
        $redirect = empty($redirect) ? '/' : str_replace(Router::url('/'), '/', $redirect);
        $isLogin = (strtolower(Router::url('/' . $this->params->url, true)) == strtolower(Router::url($this->Auth->loginAction, true)));

        if (($this->Session->read('Auth.User.id') and $this->Session->read('Auth.redirect')) OR $isLogin) {
            $this->Session->delete('Auth.redirect');
            $this->redirect($redirect);
        }
    }

    function logout() {
        if ($this->Session->check('Auth.User.id')) {
            $this->User->logAction(__d('users', 'Wylogowano poprawnie'), $this->Session->read('Auth.User.id'));
        }

        if ($this->Cookie->read('Auth.User')) {
            $this->Cookie->delete('Auth.User');
        }
        $this->Cookie->delete('Order.hash');
        $this->Session->delete('Permissions');
        $redirect_url = $this->Auth->logout();
        $this->Session->destroy();
        $this->redirect('/');
    }

    function register() {
        $this->loadModel('Commerce.Customer');
        if ($this->request->is('post') || $this->request->is('put')) {
//            $this->request->data['User']['login'] = $this->request->data['User']['name'];
            $flag = false;
            $status = 0;
            //Rejestracja ajaxowo z checkouta zamĂłwienia
            if (!isset($this->request->data['User'])) {
                $this->request->data['User']['email'] = $this->request->data['email'];
                $this->request->data['User']['name'] = $this->request->data['name'];
                $this->request->data['User']['login'] = $this->request->data['name'];
                $flag = true;
            }
            $this->request->data['User']['pass'] = $this->request->data['User']['newpassword'] = 'rejestracja - nie aktywowany';

            $users_alias = 'users';
            $this->User->Group->recursive = -1;
            $group = $this->User->Group->find('first', array('conditions' => array('Group.alias' => $users_alias), 'fields' => array('id')));
            $users_group_id = $group['Group']['id'];
            $this->request->data['Group']['Group'][] = $users_group_id;
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $user = $this->User->findById($this->User->getInsertID());
                $this->Customer->create();
                $customer_data = array('Customer' => array('user_id' => $user['User']['id'], 'email' => $user['User']['email'], 'contact_person' => $user['User']['name']));
                if (!$this->Customer->save($customer_data, false)) {
                    $errors = $this->Customer->validationErrors;
                }
                $this->register_email($user);
                if ($flag) {
                    $status = 1;
                    $this->set(compact('status'));
                    $this->set('_serialize', array('status'));
                    $this->render(false);
                    $this->Auth->login($user['User']);
                } else {
                    $this->Session->setFlash(__d('users', 'Konto zostało utworzone. Odbierz pocztę email, aby przejść do kolejnego kroku rejestracji.'));
                    $this->redirect(array('controller' => 'users', 'action' => 'register_ok'));
                }
            } else {
                $this->Session->setFlash(__d('users', 'Rejestracja nie powiodła się. Sprawdź formularz i spróbuj ponownie.'));
                if ($flag) {
                    $errors = $this->User->validationErrors;
                    $status = 0;
                    $this->set(compact('status', 'errors'));
                    $this->set('_serialize', array('status', 'errors'));
                    $this->render(false);
                }
            }
        }
    }

    private function register_email($user = array()) {
        $user['User']['md5'] = md5($user['User']['created']);
        $this->set('user', $user);

        App::uses('FebEmail', 'Lib');

        $email = new FebEmail('public');
        $email->viewVars(array('user' => $user));
        $email->template('User.user_register')
                ->emailFormat('both')
                ->to(array($user['User']['email'] => $user['User']['email']))
                ->from(array(Configure::read('App.WebSenderEmail') => Configure::read('App.WebSenderName')))
                ->subject(Configure::read('App.AppName') . __d('users', ' - rejestracja konta'));
        $email_sent = $email->send();
        $email->reset();
    }

    function activate($user_id = null, $md5 = null) {
        $user = $this->User->find('first', array('conditions' => array('User.id' => $user_id, 'MD5(User.created) = "' . $md5 . '"')));

        if ($user['User']['active'] == 1) {
            $this->Session->setFlash(__d('users', 'Konto było już aktywowane, zaloguj się aby korzystać z konta.'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }

        if (!empty($this->request->data)) {
            $this->request->data = array('User' => array(
                    'id' => $user['User']['id'],
                    'name' => $this->request->data['User']['name'],
                    'active' => 1,
                    'pass' => $this->Auth->password($this->request->data['User']['newpassword']),
                    'newpassword' => $this->request->data['User']['newpassword'],
                    'confirmpassword' => $this->request->data['User']['confirmpassword'],
            ));
            if ($this->User->save($this->request->data)) {
//                $this->Auth->login($user['User']);
                $this->Session->setFlash(__d('users', 'Konto zostało aktywowane.'));
//                $this->redirect('/');
                $this->redirect(array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'my_settings', 'login'));
            } else {
                $this->Session->setFlash(__d('users', 'Sprawdź formularz i spróbuj ponownie'));
                $this->request->data['User']['email'] = $user['User']['email'];
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->User->read(null, $user['User']['id']);
        }
        $this->set('md5', $md5);
        $this->set('user_id', $user_id);
    }

    /**
     * Sekcja Odzyskiwania Hasła
     */
    function new_pass($id = null, $hash = null) {
        if (!$this->User->checkResetPassHash($id, $hash) || !$id || !$hash) {
            $this->Session->setFlash(__d('users', 'Link jest nieprawidłowy lub stracił ważność, skontaktuj się z administratorem.'), 'flash/error');
            $this->redirect('/');
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->saveAll($this->request->data, array('validate' => 'only'))) {
                $this->User->id = $id;
                if ($this->User->saveField('pass', $this->Auth->password($this->request->data['User']['newpassword']))) {
                    $this->Session->setFlash(__d('users', 'Hasło zostało zmienione. Zaloguj się.'));
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->Session->setFlash(__d('users', 'Nie udało się zapisać zmian.'));
                }
            }
        }
        $this->set('id', $id);
        $this->set('hash', $hash);
    }

    function pass_recall() {
        if (!empty($this->request->data)) {
            $ip = $this->User->getUserIP();
            $check = $this->User->findByEmail($this->request->data['User']['email']);

            if (!empty($check) && $check['User']['active'] == 1) {

                $resetLink = array('action' => 'new_pass', $check['User']['id']);
                $resetLink[] = Security::hash($check['User']['id'] . $check['User']['modified'], null, true);

//                //wysyłanie mail-a
//                $this->set('resetLink', $resetLink);
//                $this->set('user', $check['User']);
//                $this->set('ip', $ip);

                App::uses('FebEmail', 'Lib');
                $email = new FebEmail('public');

                $email->viewVars(array('user' => $check['User'], 'resetLink' => $resetLink, 'ip' => $ip));
                $email->template('User.user_passreset')
                        ->emailFormat('both')
                        ->to(array($check['User']['email'] => $check['User']['email']))
                        ->from(array(Configure::read('App.WebSenderEmail') => Configure::read('App.WebSenderName')))
                        ->subject(Configure::read('App.AppName') . __d('users', ' - link resetowania hasła'));
                $email_sent = $email->send();
                $email->reset();



////                $this->Email->delivery = 'debug';
//                $this->Email->to = $check['User']['email'];
//                $this->Email->template = 'User.user_passreset';
//                $this->Email->sendAs = 'both';
//                $this->Email->subject = Configure::read('App.AppName') . __d('users', ' - link resetowania hasła');
//                $this->Email->from = Configure::read('App.WebSenderEmail');
//                $this->Email->send();
//                debug($this->Session->read('Message.email.message'));
//                exit;
                $this->Session->setFlash(__d('users', 'Odbierz pocztę.'));
                $this->redirect('/');
            } else {
                $this->Session->setFlash(__d('users', 'Podany e-mail nie istnieje w bazie, lub konto nie zostało aktywowane.'), 'flash/error');
            }
        }
    }

    function pass_rename() {

        $id = $this->Session->read('Auth.User.id');
        if ($this->request->is('post') || $this->request->is('put')) {
            $user = $this->User->findById($id);
            if (!empty($user) && $user['User']['pass'] === $this->Auth->password($this->request->data['User']['pass'])) {
                $this->request->data['User']['pass'] = $this->Auth->password($this->request->data['User']['newpassword']);
                $this->request->data['User']['id'] = $id;
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__d('users', 'Hasło zostało zmienione. Możesz się teraz zalogować nowym hasłem'));
                    $this->logout();
                } else {
                    $this->Session->setFlash(__d('users', 'Sprawdź formularz i spróbuj ponownie'));
                }
            } else {
                //stare haslo nie zgadza sie
                $this->Session->setFlash(__d('users', 'Sprawdź formularz i spróbuj ponownie'));
                $this->User->validationErrors = array('pass' => 'błędne hasło');
                unSet($this->request->data);
            }
        }
    }

    /**
     * Sekcja Facebook
     */
    function register_by_facebook($check = 0) {
        //Nie przejmowac się ponownym uzyciem, bo i tak dane usera pobrane zostaną z sesji
        $facebookUser = $this->Connect->user();

        $params = array(
            'req_perms' => Configure::read('Facebook.permissions'),
            'next' => Router::url(array('controller' => 'Users', 'action' => 'register_by_facebook', 1), true),
//            'cancel_url' => Router::url(array('controller' => 'Users', 'action' => 'register_by_facebook_non_auth'), true)
        );

        if (empty($facebookUser['email'])) {
            $this->redirect($this->Connect->FB->getLoginUrl($params));
        } elseif ($check == 1) {
            //Wystapi gdy po niby poprawnym zaakceptowaniu uprawnień dalej nie ma danych o uzykowniku
            throw new BadRequestException('Brak danych użytkownika Facebook');
        }

        if (!empty($this->request->data)) {
            //Dopisuje facebook_id
            $this->request->data['User']['email'] = $facebookUser['email'];
            $this->request->data['User']['facebook_id'] = $facebookUser['id'];
            $this->request->data['User']['active'] = 1;
            $this->register();
        } else {
            $this->request->data['User']['name'] = $facebookUser['name'];
        }
        $this->request->data['User']['email'] = $facebookUser['email'];
    }

    function login_facebook() {

        $facebookUser = $this->Connect->user();
        //Zalogowany
        if (!empty($facebookUser['email'])) {
            //Szukam czy istnieje taki email
            $user = $this->User->find('first', array('conditions' => array('User.email' => $facebookUser['email'])));
            if (empty($user)) {
                //Rejestracja Przez Facebooka
                $this->redirect(array('action' => 'register_by_facebook'));
            } else {
                //Istnieje, loguje go
                if (empty($user['User']['facebook_id'])) {
                    $this->User->id = $user['User']['id'];
                    $this->User->saveField('facebook_id', $facebookUser['id']);
                    $this->User->saveField('active', 1);
                    $user['User']['active'] = 1;
                    $user['User']['facebook_id'] = $facebookUser['id'];
                }

                $this->Auth->login($user['User']);
                //Przekierowuje na strone glowna ?
                //$this->Auth->redirect()
                $this->redirect('/');
            }
        } else {
            //Nie zalogowany, przekierowuje do logowania i uprawnienia
            //$this->redirect($this->FacebookApi->getLoginUrl(array('cancel_url' => Router::url('/', true), 'req_perms' => 'email, publish_stream')));
            $this->redirect($this->Connect->FB->getLoginUrl(
                            array(
                                'req_perms' => Configure::read('Facebook.permissions'),
                                'next' => Router::url(array('controller' => 'users', 'action' => 'login_facebook'), true),
//                        'cancel_url' => Router::url(array('controller' => 'users', 'action' => 'register_by_facebook_non_auth'))
                            )
                    )
            );
        }
    }

    function register_by_facebook_non_auth() {
        
    }

    function register_ok() {
        
    }

    /**
     * Portal
     */
    function view($name = null) {

        $user = $this->User->findByName($name);
        if (empty($user)) {
            throw new NotFoundException(__d('users', 'Nie odnaleziono użytkownika'));
        }
        $this->set(compact($user));
    }

    function edit() {
        $this->helpers[] = 'FebTinyMce';
        $this->helpers[] = 'Fancybox.Fancybox';
        $id = $this->Session->read('Auth.User.id');
        $this->User->id = $id;

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['User']['id'] = $id;

            if ($this->User->save($this->request->data, true, array('avatar'))) {
                $this->Session->setFlash(__d('users', 'Avatar zostal zapisany'));
            } else {
                $this->Session->setFlash(__d('users', 'Zapisywanie avatara nie powidło się. Sprawdź formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
        $this->User->recursive = -1;
        $user = $this->User->read(null);

        $this->set(compact('user'));
    }

    /**
     * Admin
     */
    function admin_index() {
        $this->helpers[] = 'Filter';
        $this->layout = 'admin';

        $this->User->recursive = 1;
        $groups = $this->User->Group->find('list');

        if (!empty($groups['4f59cfd8-139c-4614-bcc7-057077ecc6b3'])) {
            unset($groups['4f59cfd8-139c-4614-bcc7-057077ecc6b3']);
        }
        
        $params = array('conditions' => array());
        $this->filters = array(
            //Nazwa
            'User.name' => array('param_name' => 'nazwa_uzytkownika', 'default' => '', 'form' =>
                array('type' => 'hidden')),
//             'User.id' => array('param_name' => 'uzytkownik', 'default' => '', 'form' =>
//                 array('displayField' => 'name', 'type' => 'autocomplete', 'label' => __d('cms', 'Użytkownik'), 'class' => 'usersName', 'remoteSource' =>
//                     array('controller' => 'users', 'action' => 'autocomplete'))),
            'User.email' => array('param_name' => 'program', 'default' => '', 'form' =>
                array('label' => __d('cms', 'Email użytkownika'))),
            'Group.id' => array('param_name' => 'grupa', 'default' => '', 'form' =>
                array('label' => __d('cms', 'Grupa'), 'options' => $groups, 'empty' => __d('cms', 'wybierz ...'))),
        );

        $filtersParams = $this->Filtering->getParams();
        $params = $this->User->filterParams($this->request->data);

        $params['joins'][] = array(
            'table' => 'users_logs',
            'alias' => 'UsersLog',
            'type' => 'LEFT',
            'conditions' => array(
                'UsersLog.user_id = User.id',
                "UsersLog.action = 'Вы вошли в свой аккаунт.'"
            ),
        );
        $this->User->virtualFields['last_login'] = "MAX(`UsersLog`.`created`)";
        $params['fields'] = array('User.*');
        $params['order'] = 'UsersLog.created DESC';

        $params['limit'] = 50;
        $params['group'] = "User.id";
        $this->paginate = $params;

        $this->set(compact('filtersParams'));
        $this->set('filtersSettings', $this->filters);


        $this->set('users', $this->paginate());
    }

    function admin_view($id = null) {
        $this->layout = 'admin';
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__d('users', 'Nie odnaleziono użytkownika'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    function admin_add() {
        $this->layout = 'admin';
        if ($this->request->is('post')) {
            $this->User->create();
            if (!empty($this->request->data['User']['pass'])) {
                $this->request->data['User']['pass'] = $this->Auth->password($this->request->data['User']['pass']);
            }
            if ($this->User->save($this->request->data)) {
                // Przeładowanie tabeli uprawnień
                $this->requestAction(array('admin' => true, 'plugin' => 'user', 'controller' => 'permission_groups', 'action' => 'fix'));
                $this->Session->setFlash(__d('users', 'Użytkownik został zapisany'));
                $this->redirect(array('action' => 'edit', $this->User->getLastInsertId()));
            } else {
                $this->Session->setFlash(__d('users', 'Zapisywanie użytkownika nie powidło się. Sprawdź formularz i spróbuj ponownie.'));
            }
        }
        $groups = $this->User->Group->find('list');
        if (!empty($groups['4f59cfd8-139c-4614-bcc7-057077ecc6b3'])) {
            unset($groups['4f59cfd8-139c-4614-bcc7-057077ecc6b3']);
        }
        $this->set(compact('groups'));
    }

    function admin_edit($id = null) {
        $this->layout = 'admin';
        $this->helpers[] = 'Jcrop.Jcrop';
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__d('users', 'Błedy Użytkownik'));
        }
        $cantEditGroup = false;
//        if (!$this->Permissions->isAuthorized(array('admin' => true, 'controller' => 'permissions', 'action' => 'groups'))) {
//            unSet($this->request->data['Group']);
//            unSet($this->request->data['PermissionGroup']);
//            $cantEditGroup = true;
//        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!empty($this->request->data['User']['pass'])) {
                $this->request->data['User']['pass'] = $this->Auth->password($this->request->data['User']['pass']);
            }
            if ($this->User->save($this->request->data)) {
                // Przeładowanie tabeli uprawnień
                $this->requestAction(array('admin' => true, 'plugin' => 'user', 'controller' => 'permission_groups', 'action' => 'fix'));
                $this->Session->setFlash(__d('users', 'Użytkownik został zapisany'), 'flash/confirm');
//                if ($cantEditGroup) {
//                    $this->redirect($this->here);
//                }
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__d('users', 'Zapisywanie użytkownika nie powidło się. Sprawdź formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
        $user = $this->User->read(null, $id);

        if (empty($this->request->data) OR !empty($this->request->data['User']['pass'])) {
            $this->request->data = $user;
        }
        $groups = $this->User->Group->find('list');
        if (!empty($groups['4f59cfd8-139c-4614-bcc7-057077ecc6b3'])) {
            unset($groups['4f59cfd8-139c-4614-bcc7-057077ecc6b3']);
        }
        
        $this->loadModel('User.PermissionGroup');
        $params['fields'] = array('PermissionGroup.id', 'PermissionGroup.name', 'PermissionCategory.name');
        $params['recursive'] = 0;
        $permissionGroups = $this->PermissionGroup->find('list', $params);
        $this->set(compact('groups', 'user', 'cantEditGroup', 'permissionGroups'));
    }

    function admin_delete($id = null) {
        if (!$this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__d('users', 'Invalid user'));
        }
        if ($this->User->delete($id)) {
            // Przeładowanie tabeli uprawnień
            $this->requestAction(array('admin' => true, 'plugin' => 'user', 'controller' => 'permission_groups', 'action' => 'fix'));
            $this->Session->setFlash(__d('users', 'Użytkownik został usunięty'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('users', 'Usuwanie użytkownika nie powiodło się, spróbuj ponownie, lub skontaktuj się z administratorem.'));
        $this->redirect(array('action' => 'index'));
    }

    function admin_reset() {
        $admin = $this->User->find('first', array('conditions' => array('User.login' => 'admin', 'User.pass' => '')));
        if (empty($admin)) {
            $this->set('empty', true);
            return true;
        } else {
            if (!empty($this->request->data)) {
                $this->User->id = $admin['User']['id'];
                $pass = $this->Auth->password($this->request->data['User']['pass']);
                $this->User->saveField('pass', $pass);
                $this->Session->setFlash(__d('users', 'Hasło zostało ustawione'));
                $this->redirect($this->here);
            }
        }
    }

    function admin_menu($status = null) {
        $this->layout = false;
        $this->render(false);
        return $this->Cookie->write('clip', $status, 0);
    }

    /**
     * Akcja na podstawie requesta z danymi użytkownika 
     * zwraca uprawnienia uprawnienia
     * 
     */
    public function admin_permission_checkboxes() {

        $selectedPermissionGroup = array();
        if (!empty($this->request->data['Group']['Group'])) {
            //Wyciągam unikalne id zaznaczonych grup uprawnień
            $params['conditions']['Group.id'] = $this->request->data['Group']['Group'];
            $params['contain'] = array('Group');
            $this->User->Group->recursive = -1;
            $groupPermissionGroups = $this->User->Group->find('all', $params);
            $selectedPermissionGroup = array();
            foreach ($groupPermissionGroups as $group) {
                $selectedPermissionGroup = am($group['PermissionGroup']['PermissionGroup'], $selectedPermissionGroup);
            }
        }

        $this->set(compact('selectedPermissionGroup'));
    }

}

?>