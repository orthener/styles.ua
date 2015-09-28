<?php

class UsersLogsController extends AppController {

    var $name = 'UsersLogs';
    var $layout = 'admin';

    function admin_index($id = null) {

        $this->UsersLog->recursive = 0;
        if ($id)
            $this->paginate['conditions']['user_id'] = $id;

        $this->paginate['order'] = 'UsersLog.id DESC';
        $this->set('usersLogs', $this->paginate());
    }

    function admin_view($id = null) {

        if (!$id) {
            $this->Session->setFlash(__d('cms', 'Invalid UsersLog.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('usersLog', $this->UsersLog->read(null, $id));
    }

    function last_login() {
        return $this->UsersLog->last_login($this->Session->read('Auth.User.id'));
    }

    function admin_add() {

        if (!empty($this->request->data)) {
            $this->UsersLog->create();
            if ($this->UsersLog->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'The UsersLog has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'The UsersLog could not be saved. Please, try again.'));
            }
        }
        $users = $this->UsersLog->User->find('list');
        $this->set(compact('users'));
    }

    function admin_edit($id = null) {

        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__d('cms', 'Invalid UsersLog'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->UsersLog->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'The UsersLog has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'The UsersLog could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->UsersLog->read(null, $id);
        }
        $users = $this->UsersLog->User->find('list');
        $this->set(compact('users'));
    }

    function admin_delete($id = null) {

        if (!$id) {
            $this->Session->setFlash(__d('cms', 'Invalid id for UsersLog'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->UsersLog->del($id)) {
            $this->Session->setFlash(__d('cms', 'UsersLog deleted'));
            $this->redirect(array('action' => 'index'));
        }
    }

}

?>