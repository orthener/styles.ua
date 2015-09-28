<?php

class NewsletterMessagesController extends AppController {

    var $name = 'NewsletterMessages';
    var $layout = 'admin';
    var $components = array('FebEmail');
    var $helpers = array('FebTinyMce4');
    var $uses = array('NewsletterMessage', 'Newsletter');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('send'));
        $this->pageTitle = 'Newsletter';
        unset($this->helpers['Fancybox.Fancybox']);
        if (!empty($this->params['requested']))
            $this->Auth->allow(array($this->action));
    }

    function admin_index() {
        $this->NewsletterMessage->recursive = 0;
        $this->set('newsletterMessages', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowy ID wiadomości'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('newsletterMessage', $this->NewsletterMessage->read(null, $id));
    }

    function admin_htmlpreview($id = null) {
        $this->layout = 'Emails/html/default';
        if (!$id) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowy ID wiadomości'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('newsletterMessage', $this->NewsletterMessage->read(array('html_content'), $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->NewsletterMessage->create();
            if ($this->NewsletterMessage->save($this->data)) {
                $this->Session->setFlash(__d('cms', 'Wiadomość została zapisana'));
                $id = $this->NewsletterMessage->getInsertID();
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash(__d('cms', 'Zapisywanie wiadomości nie powiodło się, sprawdź formularz i spróbuj ponownie'));
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowy ID wiadomości'));
            $this->redirect(array('action' => 'index'));
        }
        $message = $this->NewsletterMessage->read(null, $id);
        if ($message['NewsletterMessage']['recipients']) {
            $this->Session->setFlash(sprintf(__d('cms', 'Nie można edytować, wiadomość została już wysłana do %s odbiorców'), $message['NewsletterMessage']['recipients']));
            $this->redirect(array('action' => 'view', $id));
        }

        if (!empty($this->data)) {
            if ($this->NewsletterMessage->save($this->data)) {
                $this->Session->setFlash(__d('cms', 'Wiadomość została zapisana'));
                $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash(__d('cms', 'Zapisywanie wiadomości nie powiodło się, sprawdź formularz i spróbuj ponownie'));
            }
        }
        if (empty($this->data)) {
            $this->data = $message;
        }
    }

    function admin_send($id = null) {

        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowy ID wiadomości'));
            $this->redirect(array('action' => 'index'));
        }
        $message = $this->NewsletterMessage->read(null, $id);
        if (empty($message)) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowy ID wiadomości'));
            $this->redirect(array('action' => 'index'));
        }
        if ($message['NewsletterMessage']['progress']) {
            $this->Session->setFlash(sprintf(__d('cms', 'Wiadomość w trakcie wysyłki (odbiorca %s)'), $message['NewsletterMessage']['progress']));
            $this->redirect(array('action' => 'view', $id));
        }
        if ($message['NewsletterMessage']['recipients']) {
            $this->Session->setFlash(sprintf(__d('cms', 'Wiadomość została już wysłana do %s odbiorców'), $message['NewsletterMessage']['recipients']));
            $this->redirect(array('action' => 'view', $id));
        }

        if (!empty($this->data)) {
            exec("wget -q -O /mailinglog.txt http://" . $_SERVER['HTTP_HOST'] . "/newsletter/newsletter_messages/send/" . $id . "/ &");
            $this->Session->setFlash(__d('cms', 'Wiadomość została przekazana do wysyłki'));
            $this->redirect(array('action' => 'view', $id));
        }

        $this->Session->setFlash(__d('cms', 'Użyj przycisku "Wyślij wiadomość newslettera", aby dokonać wysyłki'));
        $this->redirect(array('action' => 'view', $id));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowy ID wiadomości'));
            $this->redirect(array('action' => 'index'));
        }
        $message = $this->NewsletterMessage->read(null, $id);
        if ($message['NewsletterMessage']['recipients']) {
            $this->Session->setFlash(sprintf(__d('cms', 'Nie można usunąć, wiadomość została już wysłana do %s odbiorców'), $message['NewsletterMessage']['recipients']));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->NewsletterMessage->delete($id)) {
            $this->Session->setFlash(__d('cms', 'Wiadomość została usunięta'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('cms', 'Usuwanie wiadomości nie powiodło się'));
        $this->redirect(array('action' => 'index'));
    }

    function send($message_id = null) {
        $limit = 1500;
        $start_date = date('2000-01-01 01:01:01');
        $this->recipients_count = 0;
        $this->recipients_list = '';

        $this->NewsletterMessage->recursive = 1;
        $this->NewsletterMessage->locale = Configure::read('Config.languages');

        $message = $this->NewsletterMessage->read(null, $message_id);

        if (empty($message)) {
            $this->log('NewsletterMessage::send() Nieprawidlowe message_id' . $message_id, 'newsletter');
//            exit;
        }
        if ($message['NewsletterMessage']['progress']) {
            $this->log('NewsletterMessage::send()' . $message_id . '; - wywolanie jest juz w toku.', 'newsletter');
//            exit;
        }

        $this->countNewsletter_i = 0;
        
        $this->countNewsletter = $this->Newsletter->find('count', array('Newsletter.confirmed' => 1));

        $this->NewsletterMessage->id = $message['NewsletterMessage']['id'];
        $this->NewsletterMessage->saveField('progress', $this->countNewsletter_i . '/' . $this->countNewsletter);

        $this->set('message', $message);
        $start_date = date('2000-01-01 01:01:01');
        if (true) {

            while (($recipients = $this->Newsletter->find('all', array(
        'limit' => $limit,
        'order' => 'Newsletter.created ASC',
        'conditions' => array(
            'Newsletter.created >' => $start_date,
//            'Newsletter.locale' => $message['translateTitle'][0]['locale'],
            'Newsletter.confirmed' => 1
        )
            )))) {
                $n = count($recipients);
                $start_date = $recipients[$n - 1]['Newsletter']['created'];

                foreach ($recipients AS &$recipient) {
                    $this->_messageSend($recipient['Newsletter']['email'], $message);
                }
            }
        }

        $this->NewsletterMessage->save(array('NewsletterMessage' => array(
                'id' => $message['NewsletterMessage']['id'],
                'recipients' => $this->recipients_count,
                'recipients_list' => $this->recipients_list,
                )));
        $this->NewsletterMessage->id = $message['NewsletterMessage']['id'];
        $this->NewsletterMessage->saveField('progress', NULL);

        $this->log('NewsletterMessage::send() ' . $message_id . '; wyslano do ' . $this->recipients_count . ' odbiorcow.', 'newsletter');
        exit;
    }

    function _messageSend($recipient_email, &$message) {
        $this->set('email', $recipient_email);
        $this->FebEmail->to = $recipient_email;
        //$usename = explode('@', $recipient_email);
//                $this->FebEmail->to = 'a.dziki+'.$usename[0].'@feb.net.pl';
//                $this->FebEmail->bcc = array('a.dziki+'.$usename[0].'@feb.net.pl');
        
        $emailFormat = 'text';
        if (!empty($message['NewsletterMessage']['html_content'])) {
            $emailFormat = 'both';
        }
        
        App::uses('FebEmail', 'Lib');
        $email = new FebEmail('public');
        $email->viewVars(array('message' => $message, 'email' => $this->data['NewsletterMessage']['email']));
        $email->template('User.newsletter')
                ->emailFormat($emailFormat)
                ->to(array($recipient_email => $recipient_email))
                ->from(array($message['NewsletterMessage']['sender_email'] => $message['NewsletterMessage']['sender_name']))
                ->subject($message['NewsletterMessage']['title']);
        $email_sent = $email->send();
        $email->reset();
        
        
//        $this->FebEmail->subject = $message['NewsletterMessage']['title'];
//        $this->FebEmail->from = $message['NewsletterMessage']['sender_name'] . ' <' . $message['NewsletterMessage']['sender_email'] . '>';
//        $this->FebEmail->template = 'User.newsletter';
//        $this->FebEmail->sendAs = 'text';
//        if (!empty($message['NewsletterMessage']['html_content'])) {
//            $this->FebEmail->sendAs = 'both';
//        }
//        $email_sent = $this->FebEmail->send();
//        $email_sent = true;
//        $this->FebEmail->reset();
        
        $this->NewsletterMessage->saveField('progress', ++$this->countNewsletter_i . '/' . $this->countNewsletter);
        if ($email_sent) {
            $this->recipients_list .= $recipient_email . "\n";
            $this->recipients_count++;
            usleep(100000);
            return true;
        }
        return false;
    }

    function admin_test_send($message_id = null) {
        $message = $this->NewsletterMessage->read(null, $message_id);
        if (empty($message) or empty($this->data['NewsletterMessage']['email'])) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowe wywołanie'));
            $this->redirect($this->referer());
        }
        
        $this->set('message', $message);
        $this->set('email', $this->data['NewsletterMessage']['email']);

        $emailFormat = 'text';
        if (!empty($message['NewsletterMessage']['html_content'])) {
            $emailFormat = 'both';
        }
        $subject = $message['NewsletterMessage']['title'];
        App::uses('FebEmail', 'Lib');
        $email = new FebEmail('public');
        $email->viewVars(array('message' => $message, 'email' => $this->data['NewsletterMessage']['email']));
        $email->template('Newsletter.user_newsletter')
                ->emailFormat('both')
                ->to(array($this->data['NewsletterMessage']['email'] => $this->data['NewsletterMessage']['email']))
                ->from(array($message['NewsletterMessage']['sender_email'] => $message['NewsletterMessage']['sender_name']))
                ->subject($subject);
        $email_sent = $email->send();
        $email->reset();
        
//        $this->FebEmail->to = $this->data['NewsletterMessage']['email'];
//        $this->FebEmail->subject = $message['NewsletterMessage']['title'];
//        $this->FebEmail->from = $message['NewsletterMessage']['sender_name'] . ' <' . $message['NewsletterMessage']['sender_email'] . '>';
//        $this->FebEmail->template = 'Newsletter.user_newsletter';
//        $this->FebEmail->sendAs = 'text';
//        if (!empty($message['NewsletterMessage']['html_content'])) {
//            $this->FebEmail->sendAs = 'both';
//        }
//        $email_sent = $this->FebEmail->send();

        if ($email_sent) {
            $this->Session->setFlash(__d('cms', 'Wiadomość testowa została wysłana na adres') .' '. $this->data['NewsletterMessage']['email']);
            $this->redirect($this->referer());
        }

        $this->Session->setFlash('Wysyłka testowa na adres ' . $this->data['NewsletterMessage']['email'] . ' nie powiodła się');
        $this->redirect($this->referer());
    }

}

?>