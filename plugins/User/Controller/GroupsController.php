<?php

class GroupsController extends AppController {

    public $name = 'Groups';
    public $layout = 'admin';

    function admin_index() {
        $this->Group->recursive = 0;
        $params = array();
        $params['conditions']['Group.id !='] = '4f59cfd8-139c-4614-bcc7-057077ecc6b3';
        $this->paginate = $params;
        $this->set('groups', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__d('cms','Nieprawidłowy ID grupy'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('group', $this->Group->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->request->data)) {
            $this->Group->create();
            if ($this->Group->save($this->request->data)) {
                // Przeładowanie tabeli uprawnień
                $this->requestAction(array('admin' => true, 'plugin' => 'user', 'controller' => 'permission_groups', 'action' => 'fix'));
                $this->Session->setFlash(__d('cms', 'Grupa została zapisana'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms','Zapisywanie grupy nie powidło się. Sprawdź formularz i spróbuj ponownie.'));
            }
        }
        $this->loadModel('User.PermissionGroup');
        $params['fields'] = array('PermissionGroup.id', 'PermissionGroup.name', 'PermissionCategory.name');
        $params['recursive'] = 0;
        $permissionGroups = $this->PermissionGroup->find('list', $params);
        $this->set(compact('permissionGroups'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__d('cms','Nieprawidłowy ID grupy'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->Group->save($this->request->data)) {
                // Przeładowanie tabeli uprawnień
                $this->requestAction(array('admin' => true, 'plugin' => 'user', 'controller' => 'permission_groups', 'action' => 'fix'));
                $this->Session->setFlash(__d('cms', 'Grupa została zapisana'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms','Zapisywanie grupy nie powidło się. Sprawdź formularz i spróbuj ponownie.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Group->read(null, $id);
        }

        $this->loadModel('User.PermissionGroup');
        $params['fields'] = array('PermissionGroup.id', 'PermissionGroup.name', 'PermissionCategory.name');
        $params['recursive'] = 0;
        $permissionGroups = $this->PermissionGroup->find('list', $params);
        $this->set(compact('permissionGroups'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__d('cms','Nieprawidłowy ID grupy'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Group->delete($id)) {
            $this->Session->setFlash(__d('cms','Grupa została usunięta'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('cms','Usuwanie grupy nie powiodło się, spróbuj ponownie, lub skontaktuj się z administratorem.'));
        $this->redirect(array('action' => 'index'));
    }

}

?>