<?php
class Payment extends PaymentsAppModel {

	var $name = 'Payment';
	
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Podaj tytuł płatności',
				//'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'amount' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Podaj kwote płatności',
				//'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'payment_date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Podaj datę płatności',
				//'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	

    function __construct(){
        parent::__construct();
        
        $this->statuses = array(
            '-2' => __d('cms', 'Zmienione dane transakcji'), //ten status powinien generować komunikat w panelu administracyjnym
            '-1' => __d('cms', 'Płatność anulowana'), //z tego statusu nie można powrócić
            '' => __d('cms', 'Płatność jest w trakcie tworzenia'), //jeszcze nie podjęto próby przekier. do systemu płatności (NULL)
            '0' => __d('cms', 'Płatność utworzona'), //status domyślny (podjęto próbę przekierowania do syst. płatn., nie wiadomo czy próba się powiodła)
            '2' => __d('cms', 'W trakcie realizacji'), //z tego statusu powinna byc możliwość zmiany w panelu admin

            '9' => __d('cms', 'Płatność zakończona bez zaktualizowania stanu konta (stanu powiązanego rekordu)'), 
                // ten status nie powinien pozostać po wykonaniu skryptu (oznacza brak spójności danych)

            '10' => __d('cms', 'Płatność zakończona'),
        );
        
        $this->payment_gates = array(
            'przelew' => __d('cms', 'przelew'), 
            'gotówka' => __d('cms', 'gotówka'), 
            'pobranie' => __d('cms', 'pobranie'), 
            'zwrot' => __d('cms', 'zwrot')
        );
        
//         if(FULL_BASE_URL == 'http://dev.slubowisko.pl'){
//             $this->pos = 'pos_12481'; /**/
//         }
    }

//     function generatePaymentSig(){
//         
//     }

    /**
     * Returns total amount of related payments
     *
     * @param mixed $related_row_id
     * @param string $related_model
     * @param mixed $related_plugin - string or false (when model in app, not in plugin)
     * @return total ampunt
     * @access public
     */
    function total($related_row_id, $related_model, $related_plugin = false){

        if(!empty($this->virtualFields['total'])){
            $total = $this->virtualFields['total'];
        }
        $this->virtualFields['total'] = 'SUM(Payment.amount)';

        $params = array(
            'conditions' => array(
                'Payment.related_model' => $related_model,
                'Payment.related_row_id' => $related_row_id,
                'Payment.status' => $this->completed_status_id
            ),
            'fields' => array('Payment.total'),
            'group' => 'Payment.related_row_id',
            'recursive' => -1
        );

        if($related_plugin == false){
            $params['conditions'][] = 'Payment.related_plugin IS NULL';
        } else {
            $params['conditions']['Payment.related_plugin'] = $related_plugin;
        }

        $payment = $this->find('first', $params);

        if(!empty($total)){
            $this->virtualFields['total'] = $total;
        } else {
            unSet($this->virtualFields['total']);
        }

        return empty($payment['Payment']['total'])?0:$payment['Payment']['total'];
    }

    function start($data = null){

        if(is_array($data)){
            $this->create();
        } else{ 
            if(!empty($data)){
                $this->id = $data;
            }
            $data = $this->read();
            if(empty($data)){
                return false;
            }
        }

        $params = false;
    
        switch($data['Payment']['payment_gate']){
            case 'platnosci.pl':
                $data['Payment']['client_ip'] = @$_SERVER['REMOTE_ADDR'];
                $data['Payment']['platnosci_amount'] = round($data['Payment']['amount']*100);
                $data['Payment']['platnosci_desc'] = mb_substr($data['Payment']['title'], 0, 50, "UTF-8");
                $data['Payment']['platnosci_desc2'] = (mb_strlen($data['Payment']['title'], "UTF-8") > 50)?$data['Payment']['title']:null;
                break;
        }
    
        if(empty($data['Payment']['id'])){
            $this->create();
        }

        $data['Payment']['modified'] = date('Y-m-d H:i:s');
        unSet($this->validate['payment_date']);

        if(!$this->save($data)){
            return false;
        }

        if(empty($this->id)){
            $this->id = $this->getInsertID();
        }
        
        switch($data['Payment']['payment_gate']){
            case 'platnosci.pl':
                $pos = Configure::read('Payments.platnoscipl.'.Configure::read('Payments.platnoscipl.pos'));
                $ts = time();
                $params = array(
                    'post' => array(
                        'url' => $pos['payGW'],
                        'data' => array(
                            'pos_id' => $pos['pos_id'],
                            'session_id' => $this->id,
                            'pos_auth_key' => $pos['pos_auth_key'],
                            'amount' => $data['Payment']['platnosci_amount'],
                            'desc' => $data['Payment']['platnosci_desc'],
                            'desc2' => $data['Payment']['platnosci_desc2'],
                            'first_name' => '',
                            'last_name' => '',
                            'language' => 'pl',
                            'client_ip' => $data['Payment']['client_ip'],
                            'ts' => $ts,
                        )
                    ),
                    'payment_gate' => 'platnosci.pl'
                );

                //compute post data md5 hash (data appended with keyMD5 value):
                $params['post']['data']['sig'] = md5(implode('', $params['post']['data']).$pos['keyMD5']);

                if(empty($data['Payment']['platnosci_desc2'])){
                    unSet($params['post']['data']['desc2']);
                }
                
                break;
        }
        
        return $params;
                
    }


    var $errorCodes = array(
        100 => 'brak lub błedna wartosc parametru pos id',
        101 => 'brak parametru session id',
        102 => 'brak parametru ts',
        103 => 'brak lub błedna wartosc parametru sig',
        104 => 'brak parametru desc',
        105 => 'brak parametru client ip',
        106 => 'brak parametru first name',
        107 => 'brak parametru last name',
        108 => 'brak parametru street',
        109 => 'brak parametru city',
        110 => 'brak parametru post code',
        111 => 'brak parametru amount',
        112 => 'błedny numer konta bankowego',
        113 => 'brak parametru email',
        114 => 'brak numeru telefonu',
        200 => 'inny chwilowy bład',
        201 => 'inny chwilowy bład bazy danych',
        202 => 'Pos o podanym identyfikatorze jest zablokowany',
        203 => 'Nieprawidłowy typ płatności', //'niedozwolona wartosc pay type dla danego pos id',

        //'podana metoda płatnosci (wartosc pay type) jest chwilowo zablokowana dla danego id, np. przerwa konserwacyjna bramki płatniczej',
        204 => 'podana metoda płatnosci jest chwilowo zablokowana',

        205 => 'kwota transakcji mniejsza od wartosci minimalnej',
        206 => 'kwota transakcji wieksza od wartosci maksymalnej',
        207 => 'przekroczona wartosc wszystkich transakcji dla jednego klienta w ostatnim przedziale czasowym',
        208 => 'Pos działa w wariancie ExpressPayment lecz nie nastapiła aktywacja tego wariantu współpracy (czekamy na zgode działu obsługi klienta)',
        209 => 'błedny numer pos id lub pos auth key',
        500 => 'transakcja nie istnieje',
        501 => 'brak autoryzacji dla danej transakcji',
        502 => 'transakcja rozpoczeta wczesniej',
        503 => 'autoryzacja do transakcji była juz przeprowadzana',
        504 => 'transakcja anulowana wczesniej',
        505 => 'transakcja przekazana do odbioru wczesniej',
        506 => 'transakcja juz odebrana',
        507 => 'bład podczas zwrotu srodków do klienta',
        508 => 'Klient zrezygnował z płatności',
        599 => 'błedny stan transakcji, np. nie mozna uznac transakcji kilka razy lub inny, prosimy o kontakt',
        999 => 'inny bład krytyczny - prosimy o kontakt',
    );

    var $statuses = array(
        '-2' => 'Zmienione dane transakcji', //ten status powinien generować komunikat w panelu administracyjnym
        '-1' => 'Płatność anulowana', //z tego statusu nie można powrócić
        '' => 'Płatność jest w trakcie tworzenia', //jeszcze nie podjęto próby przekier. do systemu płatności (NULL)
        '0' => 'Płatność utworzona', //status domyślny (podjęto próbę przekierowania do syst. płatn., nie wiadomo czy próba się powiodła)
        '2' => 'W trakcie realizacji', //z tego statusu powinna byc możliwość zmiany w panelu admin

        '9' => 'Płatność zakończona bez zaktualizowania stanu konta (stanu powiązanego rekordu)', 
            // ten status nie powinien pozostać po wykonaniu skryptu (oznacza brak spójności danych)

        '10' => 'Płatność zakończona',
    );

    var $completed_status_id = 10;

    var $platnosci_statuses = array(
        1 => 'nowa',
        2 => 'anulowana',
        3 => 'odrzucona',
        4 => 'rozpoczeta',
        5 => 'oczekuje na odbiór',
        7 => 'płatnosc odrzucona, otrzymano srodki od klienta po wczesniejszym anulowaniu transakcji, 
        lub nie było mozliwosci zwrotu srodków w sposób automatyczny, sytuacje takie beda monitorowane i wyjasniane przez zespół Płatnosci',
        99 => 'płatnosc odebrana - zakonczona',
        888 => 'błedny status - prosimy o kontakt',
    );
    
    var $payment_gates = array();

    var $payTypes = array(
        'm' => 'mTransfer - mBank',
        'n' => 'MultiTransfer - MultiBank',
        'w' => 'BZWBK - Przelew24',
        'o' => 'Pekao24Przelew - Bank Pekao',
        'i' => 'Płace z Inteligo',
        'd' => 'Płac z Nordea',
        'p' => 'Płac z iPKO',
        'h' => 'Płac z BPH',
        'g' => 'Płac z ING',
        'l' => 'LUKAS e-przelew',
        'wp' => 'Przelew z Polbank',
        'wm' => 'Przelew z Millennium',
        'wk' => 'Przelew z Kredyt Bank',
        'wg' => 'Przelew z BGZ',
        'wd' => 'Przelew z Deutsche Bank',
        'wr' => 'Przelew z Raiffeisen Bank',
        'wc' => 'Przelew z Citibank',
        'c' => 'karta kredytowa',
        'b' => 'Przelew bankowy',
        't' => 'płatnosc testowa',
        'SMS' => 'płatnosc SMS',
        's' => 'płatnosc SMS',
    );

    function getUserPaymentData($payment_id){
        $payment = $this->find('first', array('conditions'=>array('Payment.id'=>$payment_id)));
        
        App::import('Model', $payment['Payment']['user_plugin'].'.'.$payment['Payment']['user_model']);
        $userObject = ClassRegistry::init($payment['Payment']['user_model']);
        
        $userData = $userObject->findById($payment['Payment']['user_row_id']);
        
        $this->request->data['User'] = $userData[$payment['Payment']['user_model']];
        $this->request->data['Payment'] = $payment['Payment'];
        return $this->request->data;
    }

    function read_status($payment_id, $pos_id){
        App::import('Core', array('HttpSocket', 'Xml'));
        $this->Http = & new HttpSocket();
        
        $pos = Configure::read('Payments.platnoscipl.pos_'.$pos_id);
        $ts = time();
        
        //$url = 'https://www.platnosci.pl/paygw/UTF/Payment/get';
        $url = 'https://www.platnosci.pl/paygw/UTF/Payment/get2';

//        $url = 'http://slub.dziki.homeip.net/payments/status_selftest';
        $post = array(
            'pos_id'=>$pos['pos_id'],
            'session_id'=>$payment_id,
            'ts'=>$ts,
            'sig'=>md5($pos['pos_id'].$payment_id.$ts.$pos['keyMD5'])
        );

        $response = $this->Http->post($url, $post);

        $xml = @new XML($response);
        $answer = @$this->__xmlToArray($xml);

        $status = @$answer['response']['status'];
        $answer = @$answer['response']['trans'];

        $sig = @md5($answer['pos_id'].$answer['session_id'].$answer['order_id'].$answer['status'].$answer['amount'].$answer['amount_netto'].$answer['desc'].$answer['ts'].$pos['2keyMD5']);
        if($answer['sig'] == $sig){
            if($status == 'OK'){
                $data = $this->read(null, $payment_id);

                if($data['Payment']['platnosci_amount'] != $answer['amount']){
                    //nieprawidłowa kwota transakcji
                    $data['Payment']['status'] = -2;
                    $this->save($data);
                    return false;
                }
                
                
                if($data['Payment']['status'] == 0 || $data['Payment']['status'] == 2){
                    //można zmienić status płatności
                    switch($answer['status']){
                        case '99':
                            //płatnośc zakończona, a status 
                            $data['Payment']['status'] = 10;
                            if($this->saveField('status', $data['Payment']['status'])){
                                $action = 'payment_done';

                                $import = empty($data['Payment']['related_plugin'])?$data['Payment']['related_model']:$data['Payment']['related_plugin'].'.'.$data['Payment']['related_model'];
                                App::import('Model', $import);
                                $relatedModel = &ClassRegistry::init($data['Payment']['related_model']);
                                $relatedModel->paymentStatus($data['Payment']['id'], $data['Payment']['related_row_id']);

                            } else {
                                $action = 'payment_not_updated';
                            }
                            break;
                        case '2':
                            $data['Payment']['status'] = -1;
                            $action = 'nok_step';
                            break;
                        case '1':
                        case '4':
                        case '5':
                            $action = 'middle_ok_step';
                        case '3':
                        case '7':
                        case '888':
                        default:
                            $action = empty($action)?'middle_nok_step':$action;
                            $data['Payment']['status'] = 2;
                    }
                } else {
                    $action = 'payment_not_updated';
                }

                $data['Payment']['pay_type'] = $answer['pay_type'];
                $data['Payment']['platnosci_status'] = $answer['status'];
                $data['Payment']['payment_date'] = $answer['recv'];
                $this->save($data);
                return $action;
                
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

//     function checkStatuses(){
// //         //jeśli są niezakończone płatności, to sprawdzenie ich statusu
// //         //funkcja powinna badać statusy i uaktualniać czas ostatniego sprawdzenia w bazie (np. 20 najdawniej sprawdzanych transakcji niezakończonych)
//     }

    function __xmlToArray($node) {
        if(count($node->children) == 1 && $node->children[0]->name == '#text'){
            return  $node->children[0]->value;
        }
        $array = array();
        foreach ($node->children as $child) {
            if (empty($child->children)) {
                $value = $child->value;
            } else {
                $value = $this->__xmlToArray($child);
            }

            $key = $child->name;
            if (!isset($array[$key])) {
                $array[$key] = $value;
            } else {
                if (!is_array($array[$key]) || !isset($array[$key][0])) {
                    $array[$key] = array($array[$key]);
                }
                $array[$key][] = $value;
            }
        }

        return $array;
    }        

//     function bindInvoice(){
//         $this->bindModel(array('hasOne'=>array(
//                                     'Invoice' => array(
//                                                 'className'    => 'Invoice',
//                                                 'foreignKey'   => 'payments_id',
//                                                 'conditions'   => '',
//                                                 'fields'       => '',
//                                                 'dependent'    => false                                
//                                                 )
//                                      )                
//                         ), false);        
//     }

}
?>