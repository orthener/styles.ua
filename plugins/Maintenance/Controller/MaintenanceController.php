<?php

/* * *******************************
 * @desc Obsluga tymczasowego blokowania dostepu do aplikacji
 */

class MaintenanceController extends AppController {

    var $name = 'Maintenance';
    var $helpers = array('Html', 'Form');
    var $components = array('Cookie');
    var $uses = null;

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('index', 'thank_you'));

        //debug($this->here); exit;
    }

    //--------------- index & send action -----------------------
    function index() {
        $this->layout = 'login';
        //variables for the cookies component
        $this->cookieName = 'Maintenance';
        $this->cookieKey = 'asdfjfsdknmwovfkamasdf';
        $this->cookieDomain = $_SERVER['HTTP_HOST'];
        //store the cookie for 1 minute
        $this->cookieTime = 60;
        $this->Cookie->destroy();


        //debug($this->Cookie->read('Maintenanceallow'));

        if (!empty($this->data)) {
            if ($this->data['User']['email'] == 'testowanie') {
                //process from    
                if ($this->request->data['User']['pass'] == $this->Maintenance->accessPassword) {
                    $this->Cookie->write('Maintenance.allow', true);
                    $this->redirect('/', null, true);
                }
            } else {
                $this->loadModel('User');
                $user = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'])));

                //jesli konto nie jest aktywne - inny komunikat
                if (!empty($user) && $user['User']['active'] == 0) {

                    $this->User->logAction('Próba logowania - nieaktywowane konto', $user['User']['id'], $user['User']['name'], $user['User']['email']);

                    $this->register_email($user);

                    $this->Session->setFlash("Logowanie nie jest możliwe, ponieważ konto nie zostało aktywowane. 
                    Na Twój adres email wysłana została wiadomość z linkiem aktywacyjnym, sprawdź pocztę email.
                    W razie problemów z aktywacją konta skontaktuj się z nami pod adresem 
                    <a href=\"mailto:" . Configure::read('App.AdminEmail') . "\">" . Configure::read('App.AdminEmail') . "</a>", 'flash/warning', array(), 'auth');

                    return true;
                }

                if ($this->Auth->password($this->request->data['User']['pass']) == $user['User']['pass']) {
                    $data['id'] = $user['User']['id'];
                    $data['name'] = $user['User']['name'];
                    $data['email'] = $user['User']['email'];

                    $this->Auth->login($data);
                    $this->User->logAction('Zalogowano poprawnie', $user['User']['id']);
                    $this->Cookie->write('Maintenance.allow', true);
                    //  Clear auth message, just in case we use it.
                    $this->Session->delete('Message.auth');
                    $this->redirect('/');
                } else {
                    if (!empty($user)) {
                        $this->User->logAction('Próba zalogowania - błędne hasło', $user['User']['id'], $user['User']['name'], $user['User']['email']);
                        $this->Session->setFlash(__d('cms', 'Błędne hasło'));
                    } else {
                        $this->User->logAction('Próba zalogowania - błędny login', 0, $this->request->data['User']['email'], $this->request->data['User']['email']);
                        $this->Session->setFlash(__d('cms', 'Błędny login'));
                    }
                }
            }
        }
        unset($this->request->data['User']['pass']);
    }

    //-------------- thank you page ---------------------
    function thank_you() {
        
    }

}

?>
