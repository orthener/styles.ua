<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     * Tablica komponentów ładowana w kazdym kontrolerze przed wykonaniem akcji
     * 
     * AuthComponent, SessionComponent, FebI18nComponent, PermissionsComponent, MaintenanceComponent, RequestHandlerComponent, Html2PsComponent
     */
    public $components = array(
        'Auth',
        'Session',
        'Cookie',
        'Translate.FebI18n',
        'User.Permissions',
        'Maintenance.Maintenance',
        'RequestHandler',
        'Commerce.Currency',
//        'DebugKit.Toolbar'
    );

    /**
     * Tablica helperów ładowana w każym kontrolerze przed wykonaniem akcji
     * 
     * SessionHelper, HtmlHelper, FormHelper, PermissionsHelper, JsHelper, TextHelper, FebHtmlHelper, ImageHelper
     */
    public $helpers = array(
        'Session',
        'Html',
        'Form',
        'FebForm',
        'User.Permissions',
        'Js' => 'Jquery',
        'Fancybox.Fancybox',
        'Text',
        'FebHtml',
        'Image.Image',
        'FebNumber'
    );
    
    public $disable_shop = false;
    public $disable_banners = false;
    public $disable_blog_banners = false;

    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */
    public function beforeFilter() {
        //Configure AuthComponent
        $this->Auth->authorize = 'Controller';
        $this->Auth->ajaxLogin = 'ajaxlogin';
        $this->Auth->autoRedirect = false;
        $this->Auth->fields = array('username' => 'email', 'password' => 'pass');
        $this->Auth->loginAction = array('plugin' => 'user', 'admin' => false, 'controller' => 'users', 'action' => 'login');
        $this->Auth->loginError = __("Nieprawidłowy email lub hasło");


        if (Configure::read('Shop.disable') && Configure::read('Shop.disable_url')) { 
            if (!empty($this->request->params['plugin']) && in_array($this->request->params['plugin'], array('user', 'commerce'))) {
                $this->request->params['type'] = 'blog';
                if (!empty($this->request->params['action']) && in_array($this->request->params['action'], array('my_settings'))) {
                    $this->layout = 'blog';
                }
            }
            elseif (!empty($this->request->params['controller']) && in_array($this->request->params['controller'], array('calculators'))) {
                $this->request->params['type'] = 'blog';
                $this->layout = 'blog';
            }
            if (empty($this->request->params['prefix']) && !empty($this->request->params['plugin']) && 
                    in_array($this->request->params['plugin'], array('commerce', 'static_product')) && 
                    !in_array($this->request->params['action'], array('my_settings'))) {
                if (!(Configure::read('Shop.enable_admin') && $this->Permissions->isAuthorized(array('admin' => true, 'plugin' => 'user', 'controller' => 'users', 'action' => 'index')))) {
                    if (in_array($this->request->params['action'], array('my_orders_active'))) {
                        $this->redirect(array('action' => 'my_settings', 'login'));
                    }
                    if (!in_array($this->request->params['controller'], array('calculators'))) {
                        $this->redirect(Configure::read('Shop.disable_url'));
                    }
                    $this->disable_shop = true;
                }
            }
            elseif (!empty($this->request->params['action']) && in_array($this->request->params['action'], array('populars_promoted'))) {
                if (!(Configure::read('Shop.enable_admin') && $this->Permissions->isAuthorized(array('admin' => true, 'plugin' => 'user', 'controller' => 'users', 'action' => 'index')))) {
                    $this->disable_shop = true;
                }
            }
        }
        if (Configure::read('Studio.disable') && Configure::read('Studio.disable_url')) {
            if (empty($this->request->params['prefix']) && !empty($this->request->params['type']) && $this->request->params['type'] == 'studio') {
                if (!(Configure::read('Studio.enable_admin') && $this->Permissions->isAuthorized(array('admin' => true, 'plugin' => 'user', 'controller' => 'users', 'action' => 'index')))) {
                    $this->redirect(Configure::read('Studio.disable_url'));
                }
            }
        }
             
        
        
        $this->disable_banners = Configure::read('Shop.disable_banners');
        $this->set('disable_banners', $this->disable_banners);
        
        $this->disable_blog_banners = Configure::read('Ad.disable_banners');
        
        $this->set('disable_blog_banners', $this->disable_blog_banners);
    
        
        
        if ($this->Auth->user('id')) {
            $this->Auth->authError = __("Nie masz dostępu do tego zasobu");
        } else {
            $this->Auth->authError = __("Zaloguj się, aby uzyskać dostęp");
        }

        $this->Auth->logoutRedirect = array('plugin' => 'user', 'controller' => 'users', 'action' => 'login', 'admin' => null);
        $this->Auth->loginRedirect = array('plugin' => 'user', 'admin' => 'admin', 'controller' => 'users', 'action' => 'index');
        $this->Auth->userScope = array('User.active' => 1);
        $this->Auth->allow('display', 'logout');
        
        $this->loadModel('Menu.Menu');
        
        if (!empty($this->params['requested'])) {
            $this->Auth->allow(array($this->action));
        }
        if ($this->Auth->loggedIn()) {
            $this->set('logged_in', true);
        }
        else {
            $this->set('logged_in', false);
        }
    }

    /**
     * Metoda sprawdzająca uprawnienia zalogowanego użytkownika do zasobu
     * 
     * @return true if authorised/false if not authorized
     * @access public
     */
    public function isAuthorized() {
        $return = $this->Permissions->isAuthorized('/' . $this->params->url);
        return $return;
    }

    /**
     * Callback wykonywany przed generowaniem widoku
     * 
     * @access public
     */
    public function beforeRender() {
        $this->set('clip', $this->Cookie->read('clip'));
        if ((!$this->params['requested']) AND (!$this->params['isAjax'])) {
            if (!$this->params['admin']) {
//                debug($this->params['type']);
                if (isset($this->params['type'])) {
                    $this->set('siteType', $this->params['type']);
                } elseif  ($this->action == 'search_blog') {
                    $this->set('siteType', 'blog');
                }
                else {
                    $this->set('siteType', 'default');
                }
                if (isset($this->params['type']) and ($this->params['type'] != 'shop')) {
                    if ($this->layout == 'default') {
                        $this->layout = $this->params['type'];
                    }
                } else {
                    if ($this->layout == 'default') {
                        $this->layout = 'default';
                    }
                    else{
                    $this->layout = $this->layout;
                    }
//                    $this->layout = false;
                }
                
//            debug($this->params);
            }
        }
        setlocale(LC_ALL, 'ru_RU.utf8');
    }

    /**
     * display
     * 
     * Display flash message on empty page from any controller.
     *      
     * Method Displays a flashMessage, and Pages.message if defined in session
     * Use title defined in Pages.title session key * 
     * @access public
     */
    public function display() {

        if (!$this->Session->check('Pages.title') AND !$this->Session->check('Pages.message') AND !$this->Session->check('Message.flash.message')) {
            $this->redirect('/');
        }
        if ($this->Session->check('Pages.message')) {
            $this->set('message', $this->Session->read('Pages.message'));
            $this->Session->delete('Pages.message');
        } else {
            $this->set('message', '');
        }
        if ($this->Session->check('Pages.title')) {
            $this->set('title_for_layout', $this->Session->read('Pages.title'));
            $this->Session->delete('Pages.title');
        } else {
            $this->set('title_for_layout', "");
        }

        $this->render('/display');
    }

}
