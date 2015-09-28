<?php
class NewslettersController extends AppController {

	var $name = 'Newsletters';
	var $layout = 'admin';
    var $components = array('FebEmail');
	
	function beforeFilter(){
	   parent::beforeFilter();
        $this->Auth->allow('add','ok','activate','delete','remove');
	}

	function add() {
            if (!empty($this->data['email'])) {
                $data['Newsletter']['email'] = $this->data['email'];
                $this->Newsletter->create();
                if(!empty($data['Newsletter']['email'])){
                    $member = $this->Newsletter->findByEmail($data['Newsletter']['email']);
                    if(!empty($member['Newsletter'])){
                        if($member['Newsletter']['confirmed']){
                            $this->email_register($data['Newsletter']['email'], 'NewsLetter.newsletter_unregister');
    //        				$this->redirect(array('action' => 'remove'));
                        } else {
                            $this->email_register($data['Newsletter']['email']);
    //        				$this->redirect(array('action' => 'ok'));
                            echo 1;
                        }
                    }
                }
                if (!empty($data['Newsletter']['email']) && $this->Newsletter->save($data)) {
                    $this->email_register($data['Newsletter']['email']);
				//$this->Session->setFlash(__d('cms', 'The newsletter has been saved'));
//				$this->redirect(array('action' => 'ok'));
                    echo 1;
                }
            }
                
//            if (!empty($this->data)) {
//                $this->Newsletter->create();
//                if ($this->Newsletter->save($this->data)) {
//                        $this->Session->setFlash(__d('cms', 'The newsletter has been saved'));
////                        $this->redirect(array('action' => 'index'));
//                        echo 1;
//                } else {
//                        $this->Session->setFlash(__d('cms', 'The newsletter could not be saved. Please, try again.'));
//                }
//            }
            exit;
	}

	function remove(){
	   
	}

	function ok(){
	   
	}

    function email_register($to_email, $template = 'NewsLetter.newsletter_register'){
            $this->layout = false;
            if($template == 'NewsLetter.newsletter_register'){
                $subject = __d('cms', 'Witamy wśród odbiorców newslettera ');
            } else {
                $subject = __d('cms', 'Czy chcesz zrezygnować z newslettera ?');
            }
        
            App::uses('FebEmail', 'Lib');
            $email = new FebEmail('public');

            $email->config('public');
            $email->viewVars(array('email' => $to_email));
            $email->template('newsletter/newsletter_register')
                    ->emailFormat('both')
                        ->to(array($to_email))
                    ->from(array(Configure::read('App.WebSenderEmail') => Configure::read('App.WebSenderName')))
                    ->subject($subject);
            $email_sent = $email->send();
            
            return $email_sent;
    }

    function activate( $md5 = null) {

    	$this->layout = 'default';

        $newsletter = $this->Newsletter->find('first', array('conditions' => array('MD5(Newsletter.email) = "'.$md5.'"')));

        if($newsletter['Newsletter']['confirmed'] == 1){
            $this->Session->setFlash(__d('cms', 'Email jest już aktywny'));
        } elseif(isset($newsletter['Newsletter']['id'])){
            $this->Newsletter->id = $newsletter['Newsletter']['id'];
            $this->Newsletter->saveField('confirmed',1);
            $this->Session->setFlash(__d('cms', 'Aktywacja newslettera przebiegła pomyślnie'));
        }else{
        	$this->Session->setFlash(__d('cms', 'Email nie został aktywowany. Skontaktuj się z administratorem strony.'));
        }
        $this->redirect('/');
    }

	function delete($md5 = null) {
    
    	$this->layout = 'default';

        $newsletter = $this->Newsletter->find('first', array('conditions' => array('MD5(Newsletter.email) = "'.$md5.'"')));
        
        if(empty($newsletter)){
            $this->Session->setFlash(__d('cms', 'Nie znaleziono adresu w bazie'));
            $this->redirect('/');
        }
        
        if(!empty($this->data)){
            if ($this->Newsletter->delete($newsletter['Newsletter']['id'])) {
    			$this->Session->setFlash(__d('cms', 'Adres email został usunięty z bazy'));
                $this->redirect('/');
    		}else{
                $this->Session->setFlash(__d('cms', 'Nie udalo się usunąć adresu email'));
            }
        }
        $this->set(compact('newsletter'));	
		
	}

    function admin_index() {
		$this->Newsletter->recursive = 0;
		$this->set('newsletters', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__d('cms', 'Invalid newsletter'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('newsletter', $this->Newsletter->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Newsletter->create();
			if ($this->Newsletter->save($this->data)) {
				$this->Session->setFlash(__d('cms', 'The newsletter has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('cms', 'The newsletter could not be saved. Please, try again.'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('cms', 'Invalid newsletter'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Newsletter->save($this->data)) {
				$this->Session->setFlash(__d('cms', 'The newsletter has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('cms', 'The newsletter could not be saved. Please, try again.'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Newsletter->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__d('cms', 'Nieprawidłowy id odbiorcy'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Newsletter->delete($id)) {
			$this->Session->setFlash(__d('cms', 'Odbiorca newslettera został usunięty.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__d('cms', 'Usuwanie odbiorcy newslettera nie powiodło się.'));
		$this->redirect(array('action' => 'index'));
	}
}
?>