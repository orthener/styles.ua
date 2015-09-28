<?php

class CategoriesController extends AppController {

    var $name = 'Categories';
    var $layout = 'admin';

    function index() {
        $data = $this->Category->find('threaded', array('order' => 'Category.lft ASC'));

        $data = $this->links($data);
        //debug($data);exit;
        return $data;
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
        $link['Link']['title'] = isset($link['Category']['name']) ? $link['Category']['name'] : '';
        $link['Link']['url'] = '#';
        $link['Link']['options'] = array();

        if (!empty($link['Category']['model'])) {
            $controller = Inflector::pluralize(strtolower($link['Category']['model']));
        }

        switch ($link['Category']['option']) {
            case 0:
                $link['Link']['options'] = array('onclick' => 'return false;');
                break;
            case 1:
                $link['Link']['url'] = $link['Category']['url'];
                $link['Link']['options'] = array('title' => $link['Category']['url']);
                break;
            case 2:
                $link['Link']['title'] = $link['Category']['name'];
                $link['Link']['url'] = array('plugin' => false, 'admin' => false, 'controller' => $controller, 'action' => 'view', $link[$link['Category']['model']]['slug']);
                break;
            default:
                $link['Link']['options'] = array('onclick' => 'return false;');
        }
        return $link;
    }

    function leftmenu() {
        $source = Router::parse($this->params['source']);

        if (!empty($source['pass'][0])) {
            $isSlug = $this->Category->Page->isSlug($source['pass'][0]);
            if (!empty($isSlug['id'])) {
                $category = $this->Category->find('first', array(
                    'conditions' => array('Category.model' => 'Page', 'Category.row_id' => $isSlug['id']),
                    'recursive' => -1,
                ));
            }
        }

        if (empty($category)) {
            $category = $this->Category->find('first', array(
                'conditions' => array('I18n__url.content' => $this->params['source']),
                'recursive' => 0,
            ));
        }

        if (!empty($category['Category']['parent_id'])) {
            $category = $this->Category->find('first', array(
                'conditions' => array('Category.id' => $category['Category']['parent_id']),
                'recursive' => -1,
            ));
        }

        if (empty($category)) {
            return false;
        }

        $categories = $this->Category->find('threaded', array('order' => 'Category.lft ASC', 'conditions' => array(
                'Category.lft >=' => $category['Category']['lft'],
                'Category.rght <=' => $category['Category']['rght'],
                'or' => array(
                    'Category.parent_id' => $category['Category']['id'],
                    'Category.id' => $category['Category']['id']
                )
        )));

        return $categories;
    }


    function admin_index() {
        $this->Category->recursive = 1;
        $this->Category->locale = Configure::read('Config.languages');
        $this->set('categories', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__d('cms', 'Nie znaleziono pozycji o podanym ID'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('category', $this->Category->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Category->create();
            if ($this->Category->save($this->data)) {
                $this->Session->setFlash(__d('cms', 'Zapisano pozycję w menu'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Zapisywanie pozycji w menu nie powiodło się. Sprawdź formularz i spróbuj ponownie.'));
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__d('cms', 'Nie znaleziono pozycji o podanym ID'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Category->save($this->data)) {
                $this->Session->setFlash(__d('cms', 'Zapisano pozycję w menu'));
                $this->redirect(array('admin' => false, 'plugin' => 'tree', 'controller' => 'tree', 'action' => 'index', 'Category'));
            } else {
                $this->Session->setFlash(__d('cms', 'Zapisywanie pozycji w menu nie powiodło się. Sprawdź formularz i spróbuj ponownie.'));
            }
        }

        if (empty($this->data)) {
            $this->Category->Page->set_translate();
            $this->Category->locale = Configure::read('Config.languages');
            $this->data = $this->Category->read(null, $id);
            if (!empty($this->data['Page']['id'])) {
                $this->Category->Page->recursive = 0;
                $page = $this->Category->Page->findById($this->data['Page']['id']);
                $this->data['Category']['model_title'] = $page['Page']['name'];
            }
        }
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__d('cms', 'Nie znaleziono pozycji o podanym ID'));
            $this->redirect(array('action' => 'index'));
        }
        $category = $this->Category->findById($id);
        if (!$category['Category']['lock'] and $this->Category->delete($id)) {
            $this->Session->setFlash(__d('cms', 'Pozycja została usunięta'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('cms', 'Uzuwanie wybranej pozycji nie powiodło się.'));
        $this->redirect(array('action' => 'index'));
    }

}

?>