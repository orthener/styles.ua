<?php

class DynamicElementsController extends AppController {

    var $name = 'DynamicElements';
    var $layout = 'admin';
    var $helpers = array('FebTinyMce');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'view'
        ));
    }

    function view($slug, $truncate = null) {
        $this->layout = 'ajax_steps';
        if (empty($this->params['requested'])) {
            $this->set('dynamic', $this->DynamicElement->findBySlug($slug));
            return;
        }

        if ($truncate)
            $this->set('truncate', $truncate);
        return $this->DynamicElement->findBySlug($slug);
    }

    function admin_index() {
        $this->DynamicElement->recursive = 0;
        $this->set('dynamicElements', $this->paginate());
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->DynamicElement->create();
            if ($this->DynamicElement->save($this->data)) {
                $this->Session->setFlash(__d('cms', 'Wycinek został zapisany'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Zapisywanie wycinka nie powiodło się. Sprawdź formularz i spróbuj ponownie'));
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowy ID wycinka.'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->DynamicElement->save($this->data)) {
                $this->Session->setFlash(__d('cms', 'Wycinek został zapisany'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Zapisywanie wycinka nie powiodło się. Sprawdź formularz i spróbuj ponownie'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->DynamicElement->read(null, $id);
        }
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowy ID wycinka.'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->DynamicElement->delete($id)) {
            $this->Session->setFlash(__d('cms', 'Wycinek został usunięty'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('cms', 'Usuwanie wycinka nie powiodło się'));
        $this->redirect(array('action' => 'index'));
    }

}

?>