<?php
class PaymentsController extends AppController {

	var $name = 'Payments';
	var $helpers = array('Html', 'Form', 'Ajax');

	var $uses = array('Payments.Payment');
	var $components = array('FebEmail');

    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow(array('start', 'confirm', 'status'));
    }
    
// 	function index() {
// 		$this->Payment->recursive = 0;
// 		$this->set('payments', $this->paginate());
// 	}
// 
// 	function view($id = null) {
// 		if (!$id) {
// 			$this->Session->setFlash(__('Invalid Payment.', true));
// 			$this->redirect(array('action'=>'index'));
// 		}
// 		$this->set('payment', $this->Payment->read(null, $id));
// 	}

    //przygotwanie danych i przekierowanie na stronę płatności
    function start($payment_gate = 'platnosci.pl', $id = null){

        $payment = $this->Payment->find('first', array('conditions' => array(
            'id' => $id,
            'payment_gate' => $payment_gate,
            'status IS NULL',
        )));

        if(empty($payment)){
            //błąd - nie odnaleziono płatności
            $payment = $this->Payment->findById($id);
            if(empty($payment)){
                $this->Session->setFlash(__('Próba wykonania płatności nie powiodła się.'), 'flash/error');
            } else {
                $this->Session->setFlash(__('Płatność została już rozpoczęta. Aby powtórzyć płatność przejdź do swojego konta, lub skontatuj się z biurem obsługi klienta.'), 'flash/error');
            }
			$this->redirect($this->referer('/'));
			return;
        }

        $this->Payment->id = $id;
        $payment_params = $this->Payment->start();
        $this->set(compact('payment_params'));
        
    }


    function confirm($status = null, $sessionId = null){
        //%transId% - identyfikator transakcji nadany przez płatności.pl
        //%posId% - identyfikator puntu sprzedaży
        //%payType% - wykorzystany typ płatności
        //%sessionId% - identyfikator płatnosci - unikalny dla klienta
        //%amountPS% - wartosci amount - jako separator kropka
        //%amountCS% - wartosci amount - jako separator przecinek
        //%orderId% - numer zamówienia
        //%error% - numer błedu zgodnie z tabelka 2.1 (s. 3), jest wykorzystywany tylko przy UrlNegatywny
        
        //platnosci.pl linki confirm:
        // http://slubowisko.pl/payments/confirm/ok/%sessionId%/
        // http://slubowisko.pl/payments/confirm/nok/%sessionId%/error:%error%

        //$this->pageTitle = 'Status płatności';

        $error = null;
        if(!empty($this->params['named']['error'])){
            $error = $this->params['named']['error'];
        }
        
        if(!empty($sessionId)){
            $payment = $this->Payment->find('first', array('conditions'=>array('Payment.id'=>$sessionId)));
            
        } else {
            if($status == 'ok'){
    			$this->Session->setFlash(__('Nieprawidłowe wywołanie', true));
    			$this->redirect('/');
            }
        }
        
        $this->set('errorCodes', $this->Payment->errorCodes);

        switch($status){
            case 'ok':
                $this->set('status', $status);

                if($payment['Payment']['status'] == 10){
                    $this->set('payment', $payment);
                } else {
                    if($payment['Payment']['email_confirm'] == 0){
                        //usunięto wysyłkę email z tego miejsca
                    }
                }

                break;
            case 'nok':
                $this->set('status', $status);
                $this->set('error', $error);
                break;
            default:
                echo 'błąd';
                exit;
                //error404
        }
    }

    function status(){
        //$this->log('TEMP payment status: '.serialize($_POST), 'temp_payment');

        if(isSet($_POST['pos_id']) AND isSet($_POST['session_id']) AND isSet($_POST['ts']) AND isSet($_POST['sig'])){

            //@file_put_contents(APP.'/platstatus.txt', serialize($_POST));

            $pos = Configure::read('Payments.platnoscipl.pos_'.$_POST['pos_id']);
            $sig = md5($_POST['pos_id'].$_POST['session_id'].$_POST['ts'].$pos['2keyMD5']);
            if($sig == $_POST['sig']){
                //@file_put_contents(APP.'/plat_status_OK.txt', serialize($_POST));

                $action = $this->Payment->read_status($_POST['session_id'], $_POST['pos_id']);
                
                if($action == 'payment_done'){
                    //wyślij email potwierdzający płatność
                    $payment = $this->Payment->getUserPaymentData($_POST['session_id']);

//                     $invoice_id = $this->Payment->Invoice->getInsertID();
//                     $this->requestAction('/admin/invoices/emailsend/'.$invoice_id);

                    $this->set('user', $payment);
                    
    	            /*****************************************
    	            * KONFIGURACJA KOMPONENTU EMAIL
    	            *****************************************/
    	            
    	            // Ustawienie adresu odbiorcy
    	            $this->FebEmail->to = $payment['User']['email'];
    	            
    	            // Ustawienie tytułu wiadomości
    	            $this->FebEmail->subject = '[www] Płatność zakończona';
    	            
    	            // Ustawienie adresu zwrotnego
    	            $this->FebEmail->replyTo = Configure::read('App.WebSenderEmail');
    	            
    	            // Ustawnienie adresu i nazwy nadawcy
                    $this->FebEmail->from = Configure::read('Email.defaultname') . ' <' . Configure::read('Email.default') . '>';
    	            // Ustawnienie szablonu
    	            $this->FebEmail->template = 'user.payment.done';
    	            
    	            // Wyslanie wiadomosci w formie czystego tekstu
    	            $this->FebEmail->sendAs = 'both';
    	            
			        //Zapisanie mail-a w bazie
					$this->FebEmail->saveMail = 1;
					$this->FebEmail->senderName = 'system';
    	            
    	            //Wyslanie wiadomosci do uzytkownika
    	            $email_sent = $this->FebEmail->send();

    	            if($email_sent){
                        $this->Payment->id = $payment['Payment']['id'];
                        $this->Payment->saveField('email_confirm', $payment['Payment']['email_confirm']+1);
                    }
                    
                    
                } elseif($action == 'middle_nok_step') {

                    //wyślij email potwierdzający płatność
                    $payment = $this->Payment->getUserPaymentData($_POST['session_id']);

                    $error = @$this->Payment->platnosci_statuses[$payment['Payment']['platnosci_status']];
                    $payment['Payment']['error'] = $error;

                    $this->set('user', $payment);

    	            /*****************************************
    	            * KONFIGURACJA KOMPONENTU EMAIL
    	            *****************************************/
    	            
    	            // Ustawienie adresu odbiorcy
    	            $this->FebEmail->to = $payment['User']['email'];
    	            
    	            // Ustawienie tytułu wiadomości
    	            $this->FebEmail->subject = '[www] Transakcja zakończona niepowodzeniem';
    	            
    	            // Ustawienie adresu zwrotnego
    	            $this->FebEmail->replyTo = Configure::read('App.WebSenderName');
    	            
    	            // Ustawnienie adresu i nazwy nadawcy
                    $this->FebEmail->from = Configure::read('Email.defaultname') . ' <' . Configure::read('Email.default') . '>';
    	            // Ustawnienie szablonu
    	            $this->FebEmail->template = 'user.payment.nok';
    	            
    	            // Wyslanie wiadomosci w formie czystego tekstu
    	            $this->FebEmail->sendAs = 'both';
    	            
			        //Zapisanie mail-a w bazie
					$this->FebEmail->saveMail = 1;
					$this->FebEmail->senderName = 'system';
    	            
    	            //Wyslanie wiadomosci do uzytkownika
    	            $email_sent = $this->FebEmail->send();

    	            if($email_sent){
                        $this->Payment->id = $payment['Payment']['id'];
                        $this->Payment->saveField('email_confirm', $payment['Payment']['email_confirm']+1);
                    }

                
                }

                echo 'OK'; exit;
            }
        }
        //@file_put_contents(APP.'/plat_status_NOK.txt', serialize($_POST));
        echo 'error'; exit;
    }

    function selfstatus(){
        $this->layout = 'admin';
        $test = unserialize('a:4:{s:10:"session_id";s:1:"1";s:2:"ts";s:13:"1308635914770";s:6:"pos_id";s:5:"88786";s:3:"sig";s:32:"9a36124ad185929e920bcbf9cff33b86";}');
        $this->set('params', $test);
    }

//     function status_selftest(){
//         header("content-type: text/xml");
//         debug($_POST);
//         echo '<?xml version="1.0" encoding="UTF-8" ?'.'>
// <response>
// 	<status>OK</status>
// 	<trans>
//   <id>30539099</id><pos_id>12481</pos_id><session_id>20</session_id><order_id></order_id><amount>1000</amount>
//   <status>99</status><pay_type>t</pay_type><pay_gw_name>pt</pay_gw_name><desc>Doładowanie 10 zł</desc><desc2></desc2>
// 
// 	 <create>2009-01-29 15:43:53</create><init>2009-01-29 15:44:55</init><sent>2009-01-29 15:44:55</sent>
//   <recv>2009-01-29 15:44:55</recv><cancel></cancel><auth_fraud>0</auth_fraud>
// 
// 	 <ts>1233303290762</ts><sig>a8b8507530ac718e1a99283fbdcbab50</sig><add_test>1</add_test><add_testid>30539099</add_testid>
// 
// 	</trans>
// </response>
// '; 
//        exit;
//     }

    function user_index(){
        $dane = $this->Payment->find('all', array('limit' =>2));
        //$loged = $this->DarkAuth->current_user;
        $payments = $this->Payment->find('all', array('conditions' => array("Account.user_id" => 17423)));
        $this->set('payments', $payments);
    }

	function admin_index() {

        $this->layout = 'admin';

		$this->Payment->recursive = 0;
		
		$this->Payment->Behaviors->attach('Containable');
		
		$payments = $this->paginate();
		
		$this->set(compact('payments'));
		$this->set('payTypes', $this->Payment->payTypes);
		$this->set('statuses', $this->Payment->statuses);
		$this->set('platnosciStatuses', $this->Payment->platnosci_statuses);
	}

// 	function admin_view($id = null) {
// 		if (!$id) {
// 			$this->Session->setFlash(__('Invalid Payment.', true));
// 			$this->redirect(array('action'=>'index'));
// 		}
// 		$this->set('payment', $this->Payment->read(null, $id));
// 	}
// 
	function admin_add() {
	   $this->layout = 'admin';
		if (!empty($this->request->data)) {			
			if(!empty($this->request->data['Payment']['payment_gate'])){
			    $this->Payment->create();
    			$this->request->data['Payment']['status'] = $this->Payment->completed_status_id;
    			if ($this->Payment->save($this->request->data)) {
    				$this->Session->setFlash(__('Płatność została dodana pomyślnie.', true));
    				$this->redirect($this->request->data['Payment']['redirect']);
    			} else {
    				$this->Session->setFlash(__('Nie dodano płatności. Sprawdź formularz i spróbuj ponnownie.', true), 'flash/error');
    			}
			}else{
                $this->request->data['Payment']['payment_date'] = date('Y-m-d H:i:s');
                
                if(!empty($this->request->data['Payment']['related_row_id'])){
                    $this->request->data['Payment']['title'] = 'zamówienie nr '.$this->request->data['Payment']['related_row_id'];
                }
                
                if(!empty($this->request->data['Payment']['related_model']) AND !empty($this->request->data['Payment']['related_row_id'])){
                    
                    $model = $this->request->data['Payment']['related_model'];
                    $rowId = $this->request->data['Payment']['related_row_id'];
                    
                    $this->loadModel($model);

                    $totalValue =  $this->$model->find('first', array('conditions'=>array($model.'.id'=>$rowId), 'fields'=>$model.'.total'));
                    $totalValue = empty($totalValue[$model]['total'])?0:$totalValue[$model]['total'];
                    
                    $paid = $this->Payment->find('first', array('conditions'=>array('Payment.related_row_id'=>$rowId,'Payment.related_model'=>$model),'group'=>'NULL','fields'=>'SUM(amount) as paid'));
                    $paid = empty($paid['0']['paid'])?0:$paid['0']['paid'];
                    
                    $amount = $totalValue - $paid;
                    
                    $this->request->data['Payment']['amount'] = $amount;  
                }
                
			}
    			
		}else{
		  $this->Session->setFlash(__d('cms','Wystąpił błąd', true), 'flash/error');
		  $this->redirect($this->referer('/admin'));
		}
		//$accounts = $this->Payment->Account->find('list');
		//$this->set(compact('accounts'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Payment', true), 'flash/error');
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Payment->save($this->request->data)) {
				$this->Session->setFlash(__('The Payment has been saved', true), 'flash/error');
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Payment could not be saved. Please, try again.', true), 'flash/error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Payment->read(null, $id);
		}
		$accounts = $this->Payment->Account->find('list');
		$this->set(compact('accounts'));
	}

	function admin_delete($id = null,$return = null,  $related_row_id = null, $action = null, $controller = null, $plugin = null) {
		if (!$id or !$return) {
			$this->Session->setFlash(__('Nieprawidłowy ID płatności', true), 'flash/error');
			$this->redirect(array('action'=>'index'));
		}
		$return = urldecode($return);
		if ($this->Payment->del($id)) {
			$this->Session->setFlash(__('Payment deleted', true));
			$this->redirect($return);
		}
	}

}
?>