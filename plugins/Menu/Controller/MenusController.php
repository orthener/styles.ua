<?php

App::uses('AppController', 'Controller');

/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class MenusController extends AppController {

    public $uses = array('Menu.Menu');
    public $helpers = array('Js', 'Paginator');
    public $layout = 'admin';

    function menu($treeMode = 1) {
//        $this->Menu->setScope("Menu.selection_id = {$this->selection_id}");
//        $data = $this->Menu->findTree();
        if (!empty($treeMode)) {
            $data = $this->Menu->findTree(array('Menu.mode' => $treeMode));
        } else {
            $data = $this->Menu->findTree();
        }
        $data = $this->links($data);
        $this->set(compact('data'));
        $this->render('Menu./Elements/menu');
    }

    function admin_index($treeMode = '') {
        if (empty($treeMode)) {
            $this->redirect(array('action' => 'index', 1));
        }
        //$this->Menu->setScope("Menu.selection_id = {$this->selection_id}");

        if ($this->Menu->Behaviors->attached('Translate') && Configure::read('Config.languages')) {
            $this->Menu->locale = Configure::read('Config.languages');
        }

//        $this->Menu->recover();
        //$this->Menu->Translate translateDisplay 
        $this->Menu->bindTranslation(array('name' => 'translateDisplay'));
        if (!empty($treeMode)) {
            $tree = $this->Menu->findTree(array('Menu.mode' => $treeMode));
        } else {
            $tree = $this->Menu->findTree();
        }
        $tree = $this->links($tree);
        $this->set('tree', $tree);

        $this->set('is_ajax', $this->request->is('ajax'));
        $this->set('modes', Menu::$modes);
        $this->set('treeMode', $treeMode);
        $urlOptions = $this->Menu->urlOptions();
        $this->set(compact('urlOptions'));

        return $tree;
    }

    function links(&$data = array()) {

        foreach ($data as &$link) {
            $link = $this->link($link);
            if (!empty($link['children'])) {
                $this->links($link['children']);
            }
        }
        return $data;
    }

    function link($link = array()) {
        $link['Link']['title'] = isset($link['Menu']['name']) ? $link['Menu']['name'] : '';
        $link['Link']['url'] = '#';
        $link['Link']['options'] = array();

        if (!empty($link['Menu']['model'])) {
            $link['Menu']['controller'] = Inflector::pluralize(strtolower($link['Menu']['model']));
        }
        $link['Menu']['plugin'] = (isset($link['Menu']['model']) and $link['Menu']['model'] == 'Page') ? 'page' : '';
        switch ($link['Menu']['option']) {
            case 0:
                $link['Link']['options']['default'] = false;
                break;
            case 1:
                $link['Link']['url'] = $link['Menu']['url'];
                break;
            case 2:
                $link['Link']['title'] = $link['Menu']['name'];
                $link['Link']['url'] = array();
                $link['Link']['url']['admin'] = false;
                $link['Link']['url']['plugin'] = $link['Menu']['plugin'];
                $link['Link']['url']['controller'] = $link['Menu']['controller'];
                $link['Link']['url']['action'] = 'view';
                $link['Link']['url'][] = $link[$link['Menu']['model']]['slug'];
                break;
            default:
                $link['Link']['options'] = array('onclick' => 'return false;');
        }
        return $link;
    }

    function admin_relatedindex($alias = 'Page.Page', $params = null) {

        if (empty($alias)) {
            throw new NotFoundException(__d('cms', 'Model nie istnieje.'));
        }

        $this->loadModel($alias);
        $this->loadModel("Menu.Menu");

        list($plugin, $model) = pluginSplit($alias);

        if ($this->Menu->Behaviors->attached('Translate') && Configure::read('Config.languages')) {
            $language = Configure::read('Config.languages');
            $this->Page->locale = $language;
            $this->Menu->locale = $language;
            $this->Page->bindTranslation(array('name' => 'translateDisplay'));
            $this->Menu->bindTranslation(array('name' => 'translateDisplay'));
        }
            $this->Page->recursive = 1;

//        $pages = $this->Page->find('all');
//        debug($pages);
//        exit;
        
        if ($params) {
            if ($params == 'podstrony') {
                $paginateParams['conditions'][$model . '.gallery'] = 0;
            }
            if ($params == 'galerie') {
                $paginateParams['conditions'][$model . '.gallery'] = 1;
            }
            if ($params == 'shop') {
                $paginateParams['conditions'][$model . '.category'] = 0;
            }
            if ($params == 'blog') {
                $paginateParams['conditions'][$model . '.category'] = 2;
            }
            if ($params == 'studio') {
                $paginateParams['conditions'][$model . '.category'] = 1;
            }
        }
        $paginateParams['limit'] = 10;
        $this->paginate = $paginateParams;

        $relatedData = $this->paginate($model);
        $displayField = $this->Menu->displayField;

        $this->set(compact('relatedData', 'model', 'plugin', 'displayField'));
    }

    function admin_reset() {
        $this->Menu->recover('parent');
        $this->Menu->recover('tree');
        $this->Session->setFlash('Zresetowano');
        $this->redirect(array('action' => 'index'), null, true);
    }

    function admin_update() {
        if (empty($this->request->data['dest_id']) or empty($this->request->data['id'])) {
            throw new MethodNotAllowedException('empty dest_id');
        }

        if (empty($this->request->data['mode'])) {
            $this->request->data['mode'] = null;
        }

        $valid = $this->Menu->validateDepth($this->request->data['id'], $this->request->data['dest_id'], $this->request->data['mode']);
        if ($valid === false) {
            $this->Session->setFlash($this->Menu->validate['depth']['message']);
        }

        if ($valid === true && $this->Menu->moveNode($this->request->data['id'], $this->request->data['dest_id'], $this->request->data['mode'])) {
            //success
            $this->Session->setFlash(__d('cms', 'Zmieniono pozycję'));
        }
        //debug($this->referer());
        $this->render(false);
        //$this->redirect($this->referer());
        return false;
    }

    function admin_add($requested = false) {
        //$this->_checkAccess($model);
        if (empty($this->request->data)) {
            if (!$requested) {
                $this->render(false);
            }
            return false;
        }
        $myData = $this->request->data['Menu']['mode'];

        if (empty($this->request->data['Menu']['name'])) {
            $this->Session->setFlash(__d('cms', 'Wprowadź nazwę, aby dodać pozycję.'));
            $this->redirect(array('action' => 'index', $myData));
        }

        $this->Menu->create();

        //$this->request->data['Menu']['selection_id'] = $this->selection_id;

        if ($this->Menu->save($this->request->data)) {
            if (empty($this->request->data['dest_id'])) {
                $this->Session->setFlash(__d('cms', 'Dodano pozycję na koniec drzewa.'));
            } else {
                $id = $this->Menu->getInsertID();
                if (empty($this->request->data['mode'])) {
                    $this->request->data['mode'] = null;
                }
                if ($this->Menu->moveNode($id, $this->request->data['dest_id'], $this->request->data['mode'])) {
                    $this->Session->setFlash(__d('cms', 'Dodano pozycję do drzewa.'));
                } else {
                    $this->Session->setFlash(__d('cms', 'Dodano pozycję na koniec drzewa.'));
                }
            }
            $this->request->data = array();
        } else {
            $this->Session->setFlash(__d('cms', 'Dodanie pozycji nie powiodło się, sprawdź formularz i spróbuj ponownie'));
        }
        $this->redirect(array('action' => 'index', $myData));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__d('cms', 'Nie znaleziono pozycji o podanym ID'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Zapisano pozycję w menu'));
                $this->redirect(array('admin' => true, 'plugin' => 'menu', 'controller' => 'menus', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Zapisywanie pozycji w menu nie powiodło się. Sprawdź formularz i spróbuj ponownie.'));
            }
        }
        $urlOptions = $this->Menu->urlOptions();

        if (empty($this->request->data)) {
            $this->Menu->locale = Configure::read('Config.languages');
            $this->request->data = $this->Menu->read(null, $id);
            if ($this->request->data['Menu']['option'] == 2) {
                $alias = $this->request->data['Menu']['model'];
                $this->request->data['Menu']['model_title'] = $this->request->data['Page']['slug'];
            }
        }

        $this->set(compact('urlOptions'));
        /*
          if (empty($this->request->data)) {
          $this->Menu->Page->set_translate();
          $this->Menu->locale = Configure::read('Config.languages');
          $this->request->data = $this->Menu->read(null, $id);
          if(!empty($this->request->data['Page']['id'])){
          $this->Menu->Page->recursive = 0;
          $page = $this->Menu->Page->findById($this->request->data['Page']['id']);
          $this->request->data['Category']['model_title'] = $page['Page']['name'];
          }
          } */
    }

    function delete($id = null, $all = null, $treeMode = '') {
        //$this->loadModel($model);
        $model = 'Menu';
        $lang = 'pl'; //$this->I18n->l10n->locale;
        if (empty($id)) {
            $this->cakeError('error404');
        }
        if ($all != 0) {
            $this->Menu->delete($id);
        } else {
            $ile1 = $this->Menu->query("SELECT COUNT(*) as `ile` FROM `i18n` WHERE `model` = '{$model}' AND locale = '{$lang}' AND foreign_key = {$id}");
            $ile2 = $this->Menu->query("SELECT COUNT(*) as `ile` FROM `i18n` WHERE `model` = '{$model}' AND foreign_key = {$id}");
            if ($ile1[0][0]['ile'] == $ile2[0][0]['ile']) {
                $this->Menu->delete($id);
            } else {
                $this->Menu->query("DELETE FROM `i18n` WHERE `model` = '{$model}' AND locale = '{$lang}' AND foreign_key = {$id}");
            }
        }
        $this->redirect(array('admin' => 'admin', 'action' => 'index', $treeMode), null, true);
    }

}
