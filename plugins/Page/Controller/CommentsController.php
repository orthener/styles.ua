<?php
class CommentsController extends AppController {

	var $name = 'Comments';
    
    var $components = array('RequestHandler');
    var $helpers = array('Js' => array('Jquery'));
    
    var $layout = 'admin';

    
    function admin_akcept($id = null){
        $this->Comment->id = $id;
        $this->Comment->saveField('active',1);
        $this->render(false);
    }

	function admin_index() {
		$this->Comment->recursive = 1;
        $paginate['conditions']['Comment.active'] = 0;
        $this->paginate = $paginate;
        $comments = $this->paginate();
		$this->set(compact('comments'));
		$test = $this->Comment->find('all');
	}
    function admin_active() {
		$this->Comment->recursive = 0;
	
        $paginate['conditions']['Comment.active'] = 1;
        $this->paginate = $paginate;
		$comments = $this->paginate();
		$this->set(compact('comments'));
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__d('cms', 'Invalid comment'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('comment', $this->Comment->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Comment->create();
			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash(__d('cms', 'The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('cms', 'The comment could not be saved. Please, try again.'));
			}
		}
		$pages = $this->Comment->Page->find('list');
		$users = $this->Comment->User->find('list');
		$this->set(compact('pages', 'users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('cms', 'Invalid comment'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash(__d('cms', 'The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('cms', 'The comment could not be saved. Please, try again.'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Comment->read(null, $id);
		}
		$pages = $this->Comment->Page->find('list');
		$users = $this->Comment->User->find('list');
		$this->set(compact('pages', 'users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__d('cms', 'Invalid id for comment'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Comment->delete($id)) {
			//$this->Session->setFlash(__d('cms', 'Comment deleted'));
		//	$this->redirect(array('action'=>'index'));
		}
        $this->render(false);
		//$this->Session->setFlash(__d('cms', 'Comment was not deleted'));
		//$this->redirect(array('action' => 'index'));
	}
}
?>