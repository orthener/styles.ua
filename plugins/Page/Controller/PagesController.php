<?php

/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class PagesController extends AppController {

    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    var $name = 'Pages';
    var $helpers = array(
        'Recaptcha.CaptchaTool',
        'FebForm',
        'FebTinyMce4',
    );
    var $components = array(
        //'FebEmail',
        'Recaptcha.Captcha' => array(
            'private_key' => '6LcOzr0SAAAAAON0wiMcOEroKy_VaD1i6c-ci9qn',
            'public_key' => '6LcOzr0SAAAAAENp6qLOs5TgvJ6lxvaereP1d-VH'
        ),
        'Filtering'
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display', 'message', 'view', 'view_ajax');
        //$this->Page->set_translate(true);
    }

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @access public
     */
    function display() {
        $path = func_get_args();
//        debug($path);
        $count = count($path);
        if (!$count) {
            $this->redirect('/');
        }
        $page = $subpage = $title = null;

        if (!empty($path[0])) {
  //          debug('1');
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
    //        debug('2');
            $title = Inflector::humanize($path[$count - 1]);
        }
//        debug($siteType);
//        debug($subpage);
        //$this->saveAnkieta();
        $this->set(compact('page', 'subpage', 'title'));
        $this->render(implode('/', $path));
//        debug($path);
        $key = join('/', $path);
//        debug($key);
        $pagecontent = $this->Page->find('first', array('conditions' => array('or' => array('Page.id' => $key, 'I18n__Page_slug.content' => $key))));
        $this->set('pagecontent', $pagecontent);
    }

    function send_email() {
        if (!empty($this->data)) {
            $this->Page->set($this->request->data);

            if ($this->Page->validates()) {

                App::uses('FebEmail', 'Lib');
                $email = new FebEmail('public');

                $email->viewVars(array('data' => $this->data));

                $email->template('kontakt_podziekowanie')
                        ->emailFormat('both')
                        ->to(array($this->data['Page']['email']))
                        ->from(array(Configure::read('App.WebSenderEmail') => Configure::read('App.WebSenderName')))
                        ->subject(__d('email', 'Контакт'));
                $email_sent = $email->send();

                $email->reset();
                
                $email->config('public');
                $email->viewVars(array('data' => $this->data));
                
                $email->template('kontakt')
                        ->emailFormat('both')
                        ->to(array(Configure::read('App.AdminEmail') => Configure::read('App.AdminEmail')))
                        ->from(array(Configure::read('App.WebSenderEmail') => Configure::read('App.WebSenderName')))
                        ->subject(__d('email', 'Контакт'));
                $email_sent = $email->send();

                return true;
            }
        }
        return false;
    }

    /**
     * Displays a flashMessage, and Pages.message if defined in session
     * Use title defined in Pages.title session key
     *
     * @param mixed What page to display
     * @access public
     */
    function message() {
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
    }

    public function ajaxfilemanager() {
        $this->layout = null;
        $this->autoRender = false;
    }

    function admin() {
        $this->layout = 'admin';
    }
    
    function view_ajax($slug = null) {
        $this->helpers[] = 'Fancybox.Fancybox';
        $this->layout = 'ajax';
        $slug = $this->Page->isSlug($slug);

        if (!$slug) {
            throw new NotFoundException(__d('cms', 'Invalid localization'));
        }
        if (!empty($slug['error'])) {
            $this->redirect(array($slug['slug']), $slug['error']);
        }
        
        $strona = $this->Page->read(null, $slug['id']);
        $this->set(compact('strona'));
    }
    
    function view($slug = null) {
        $this->helpers[] = 'Fancybox.Fancybox';
        $tmpSlug = $slug;
        $slug = $this->Page->isSlug($slug);

        if (!$slug) {
            throw new NotFoundException(__d('cms', 'Invalid localization'));
        }
        if (!empty($slug['error'])) {
            $this->redirect(array($slug['slug']), $slug['error']);
        }
        
        $strona = $this->Page->read(null, $slug['id']);
        $layoutType = $strona['Page']['category'];
        if($layoutType != 0 && !isset($this->params['type'])){
            $this->redirect(array('type'=>Page::$categories[$layoutType], $tmpSlug));
        }

        if ($this->send_email()) {
            $this->redirect(array('action' => 'view', 'dziekujemy-za-kontakt'));
        }

        $photoCategoryTree = array();
//        if ($strona['Page']['gallery']) {
//            $this->loadModel('Photo.PhotoCategory');
//            $this->PhotoCategory->setScope("PhotoCategory.page_id = {$slug['id']}");
//            $photoCategoryTree = $this->PhotoCategory->findTree();
//        }
//
//        $this->_add_comment();
        
        $this->set(compact('strona', 'photoCategoryTree', 'layoutType'));
    }

    function _add_comment() {
        if (!empty($this->data)) {
            $this->Page->Comment->set($this->data);
            if ($this->Page->Comment->save($this->data)) {
                $this->Session->setFlash(__d('cms', 'Komentarz został zapisany i oczekuje na weryfikację.'));
                $this->data = null;
            } else {
                $this->Session->setFlash(__d('cms', 'Komentarz nie został zapisany. Proszę sprawdzić formularz i spróbować ponownie.'));
            }
        }
    }

    function admin_index() {
        $this->layout = 'admin';
        $this->Page->recursive = 1;
        $this->helpers[] = 'Filter';

        //$this->paginate['order']='Page.created DESC';
        //$this->paginate['recursive']=1;

        $language = Configure::read('Config.languages');
        $this->Page->locale = $language;
        //$this->Page->locale = Configure::read('Config.locale');
        $this->Page->bindTranslation(array('name' => 'translateDisplay'));
        
        $params = array('conditions' => array());
        $this->filters = array(
            //Nazwa
//            'Page.name' => array('param_name' => 'name', 'default' => '', 'form' => array('label' => __d('cms', 'Tytuł'))),
            'Page.category' => array('param_name' => 'category', 'default' => '', 'form' => array('label' => __d('cms', 'Kategoria'), 'options' => Page::$categories, 'empty' => __d('cms', 'dowolna'))),
        );

        $filtersParams = $this->Filtering->getParams();
        $params = $this->Page->filterParams($this->request->data);
        
        $this->paginate = $params;
      
        $pages = $this->paginate();
        //debug($pages);
        $this->set('pages', $pages);
        $this->set(compact('filtersParams'));
        $this->set('filtersSettings', $this->filters);
  }

    function admin_add($id = null) {
        $this->layout = 'admin';

        if (!empty($this->data)) {
            //debug($this->data);exit;
            $this->Page->create();
            if ($this->Page->save($this->data)) {
//                if ($this->data['Page']['gallery']) {
//                    $this->Session->setFlash(__d('cms', 'Dodaj zdjęcia'));
//                    $this->redirect(array('controller' => 'page_photos', 'action' => 'editindex', $this->Page->getLastInsertID()));
//                } else {
                    $this->Session->setFlash(__d('cms', 'Pozycja została zapisana'));
                    $this->redirect(array('action' => 'index'));
//                }
            } else {
                $this->Session->setFlash(__d('cms', 'Pozycja nie została zapisana. Sprawdz formularz i spróbuj ponnownie'));
            }
        }
        if ($id && empty($this->data)) {
            $this->data = $this->Page->findById($id);
        }
    }

    function admin_edit($id = null) {
        $this->layout = 'admin';
        $this->Page->recursive = 1;
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowa pozycja'));
            $this->redirect(array('action' => 'index'));
        }

        if (!empty($this->data)) {
            if ($this->Page->save($this->data)) {
                $this->Session->setFlash(__d('cms', 'Pozycja została zapisana'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Pozycja nie została zapisana. Sprawdz formularz i spróbuj ponnownie'));
            }
        }

        if (empty($this->data)) {
            $this->Page->locale = Configure::read('Config.languages');
            $this->data = $this->Page->read(null, $id);
        }
    }

    function admin_delete($id = null, $all = null) {
        $this->FebI18n->delete($id, $all);
        $this->redirect(array('action' => 'index', 'pages'), null, true);
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
        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->Page->recursive = -1;
        $params['conditions']["I18n__name.content LIKE"] = "%{$this->request->data['fraz']}%";
//        $params['conditions']["I18n__name__pol.content"] = "{$this->request->data['fraz']}";
        $res = $this->Page->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }
}

?>