<?php

App::uses('AppModel', 'Model');
App::uses('Commerce', 'Commerce.Vendor');

/**
 * Order Model
 *
 * @property OrderStatus $OrderStatus
 * @property Customer $Customer
 * @property ShipmentMethod $ShipmentMethod
 * @property OrderItem $OrderItem
 */
class Order extends AppModel {

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array();
    var $tablePrefix = 'commerce_';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'hash';

    /**
     * Domyślne sortowanie
     *
     * @var string
     */
    public $order = 'Order.created DESC';

    /**
     * @desc Ilość dni przechowywania koszyka w coockie klienta
     * @var type int
     */
    var $cookieLifeTime = 2;
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    //var $actsAs = array('Modification');
    //var $components = array('Cookie');
    //var $actAs = array();

    public $paymentTypes = array(
        '0' => 'Płatność przelewem',
        // disable PayU
//        '1' => 'Płatność elektroniczna PayU',
        '2' => 'Płatność za pobraniem/przy odbiorze'
//        '3' => 'PayPal/k.k.'
    );
    public static $taxRates = array(
        '0.0' => '0%',
        '0.05' => '5%',
        '0.08' => '8%',
        '0.23' => '23%',
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'OrderStatus' => array(
            'className' => 'Commerce.OrderStatus',
            'foreignKey' => 'order_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'PromotionCode' => array(
            'className' => 'Commerce.PromotionCode',
            'foreignKey' => 'promotion_code_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Customer' => array(
            'className' => 'Commerce.Customer',
            'foreignKey' => 'customer_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ShipmentMethod' => array(
            'className' => 'Commerce.ShipmentMethod',
            'foreignKey' => 'shipment_method_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasOne = array(
        'Invoice' => array(
            'className' => 'Payments.Invoice',
            'foreignKey' => 'related_row_id',
            'dependent' => false,
            'conditions' => array('Invoice.related_model' => 'Order', 'Invoice.related_plugin' => 'Commerce'),
            'fields' => '',
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'OrderItem' => array(
            'className' => 'Commerce.OrderItem',
            'foreignKey' => 'order_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Note' => array(
            'className' => 'Commerce.Note',
            'foreignKey' => 'row_id',
            'dependent' => false,
            'conditions' => array('Note.model' => 'order'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Payment' => array(
            'className' => 'Payments.Payment',
            'foreignKey' => 'related_row_id',
            'dependent' => false,
            'conditions' => array('Payment.related_model' => 'Order', 'Payment.related_plugin' => 'Commerce'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * Callback wykonywany przed walidajcją
     * 
     * @param type $options 
     */
    public function beforeValidate($options = array()) {
        $this->validate = array(
//			'hash' => array(
//				'uuid' => array(
//					'rule' => array('uuid'),
//					'message' => __d('cms', 'Pole formularza nie może być puste'),
//					//'allowEmpty' => false,
//					//'required' => false,
//					//'last' => false, // Stop validation after this rule
//					//'on' => 'create', // Limit validation to 'create' or 'update' operations
//				),
//			),
            'order_status_id' => array(
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => __d('cms', 'Pole formularza nie może być puste'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'shipment_discount' => array(
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => __d('cms', 'Pole formularza nie może być puste'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'vat' => array(
                'boolean' => array(
                    'rule' => array('boolean'),
                    'message' => __d('cms', 'Pole formularza nie może być puste'),
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
        );
    }

    /**
     * Konstruktor klasy modelu
     * 
     * @param int $id
     * @param array $table
     * @param bool $ds 
     */
    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields = array(
            'shipment_price_net' => 'IF(' . PRICE_TYPE . ", `{$this->alias}.shipment_price` - `{$this->alias}.shipment_tax_value`, `{$this->alias}.shipment_price`)",
            'shipment_price_gross' => 'IF(' . PRICE_TYPE . ", `{$this->alias}.shipment_price`, `{$this->alias}.shipment_price` + `{$this->alias}.shipment_tax_value`)",
//            'shipment_price_net' => 'IF(' . 1 . ", `{$this->alias}.shipment_price` - `{$this->alias}.shipment_tax_value`, `{$this->alias}.shipment_price`)",
//            'shipment_price_gross' => 'IF(' . 1 . ", `{$this->alias}.shipment_price`, `{$this->alias}.shipment_price` + `{$this->alias}.shipment_tax_value`)",
        );
            
        $this->paymentTypes = array(
        '0' => __d('cms', 'Płatność przelewem'),
        // disable payu
//        '1' => __d('cms', 'Płatność elektroniczna PayU'),
        '2' => __d('cms', 'Płatność za pobraniem/przy odbiorze'));
    }

    function beforeSave($options = array()) {
        if (isSet($this->data['Order']['address'])) {
            if (is_array($this->data['Order']['address'])) {
                $this->data['Order']['address'] = json_encode(array('AddressDefault' => $this->data['Order']['address']));
            }
        }
        if (isSet($this->data['Order']['invoice_identity'])) {
            if (is_array($this->data['Order']['invoice_identity'])) {
                $this->data['Order']['invoice_identity'] = json_encode(array('InvoiceIdentityDefault' => $this->data['Order']['invoice_identity']));
            }
        }
//        $order = $this->read(null, $this->data['Order']['id']);
//        debug($order);
//        debug($this->data['Order']); exit;
        return true;
    }

    function afterFind($results, $primary = false) {
        foreach ($results as $key => $value) {
            if (is_array($results[$key])) {
                if (isSet($results[$key]['Order']['address'])) {
                    $tmp = json_decode($results[$key]['Order']['address'], true);
                    if (is_array($tmp)) {
                        $results[$key]['Order']['address'] = $tmp['AddressDefault'];
                    }
                }
                if (isSet($results[$key]['Order']['invoice_identity'])) {
                    $tmp = json_decode($results[$key]['Order']['invoice_identity'], true);
                    if (is_array($tmp)) {
                        $results[$key]['Order']['invoice_identity'] = $tmp['InvoiceIdentityDefault'];
                    }
                }
            }
        }
        return $results;
    }

    function afterSave($created) {
        if (isset($this->data['Order']['shipment_price']) || isset($this->data['Order']['discount'])) {
            $this->recalculateTotal();
        }
        return;
    }

    function recalculateTotal($id = null) {
        if (!empty($id)) {
            $this->id = $id;
        }
        $this->recursive = 1;
        $order = $this->findById($this->id);
//        debug($order); exit;
        $temp = Commerce::getTotalPricesForOrder($order, true);
//        debug($temp);
//        debug($order); 
//        exit;
        
        $this->data['Order']['total_tax_value'] = $temp['final_tax_value'];
        $this->data['Order']['total'] = $temp['final_price_gross'];
        if ($order['Order']['provision']) {
            $this->data['Order']['provision_total'] = $temp['provision_total'];
        }
//        debug($this->data);
        $this->save(null, array('callbacks' => false));
    }

    function filterParams($data) {
        $params = array();
        if (isSet($data['OrderStatus']['id']) && $data['OrderStatus']['id'] !== '') {
            $params['conditions']['OrderStatus.id'] = $data['OrderStatus']['id'];
        }
        if (!empty($data['Order']['hash'])) {
            $params['conditions']['Order.hash LIKE'] = '%' . $data['Order']['hash'] . '%';
        }
        if (!empty($data['Customer']['name'])) {
            $params['conditions']['OR']['Customer.contact_person LIKE'] = '%' . $data['Customer']['name'] . '%';
            //$params['conditions']['OR']['Customer.email LIKE'] = '%' . $data['Customer']['name'] . '%';
            $params['conditions']['OR']['Order.invoice_identity LIKE'] = '%' . str_replace(array("\\", '"'), '%', json_encode($data['Customer']['name'])) . '%';
        }
        return $params;
    }

    function filterParams_cancel($data) {
        $params = array();
        /* if (isSet($data['OrderStatus']['id']) && $data['OrderStatus']['id'] !== '') {
          $params['conditions']['OrderStatus.id'] = $data['OrderStatus']['id'];
          } */
        if (!empty($data['Order']['hash'])) {
            $params['conditions']['Order.hash LIKE'] = '%' . $data['Order']['hash'] . '%';
        }
        if (!empty($data['Customer']['name'])) {
            $params['conditions']['OR']['Customer.contact_person LIKE'] = '%' . $data['Customer']['name'] . '%';
            //$params['conditions']['OR']['Customer.email LIKE'] = '%' . $data['Customer']['name'] . '%';
            $params['conditions']['OR']['Order.invoice_identity LIKE'] = '%' . str_replace(array("\\", '"'), '%', json_encode($data['Customer']['name'])) . '%';
        }
        return $params;
    }

    function getModyfications($id) {

        App::uses('Modification', 'Modification.Model');
        $this->Modification = ClassRegistry::init('Modification.Modification');

        $params = array();

        $params['conditions']['Group.alias'] = 'admins';
        $params['group'] = 'User.id';
        $params['joins'][] = array(
            'table' => 'groups_users',
            'alias' => 'GroupsUser',
            'type' => 'LEFT',
            'conditions' => array(
                'GroupsUser.user_id = User.id',
            )
        );
        $params['joins'][] = array(
            'table' => 'groups',
            'alias' => 'Group',
            'type' => 'LEFT',
            'conditions' => array(
                'GroupsUser.group_id = Group.id',
            )
        );

        $user_ids = array_keys($this->Customer->User->find('list', $params));

        $modifications = $this->Modification->find('all', array('conditions' => array(
                'or' => array(
                    'and' => array('model' => 'Order', 'foreign_key' => $id),
                    //'model' => 'Note',
                    'model' => 'OrderItem'
                ),
                'user_id' => $user_ids
            )
                )
        );

        $diffs = array();

        foreach ($modifications as $key => $value) {

            $after = json_decode($value['Modification']['content_after'], true);
            $before = json_decode($value['Modification']['content_before'], true);

            if ($value['Modification']['model'] == 'Note') {
                if ($after['row_id'] != $id) {
                    continue;
                }
            } else if ($value['Modification']['model'] == 'OrderItem') {

                if ($value['Modification']['action'] == 'add') {
                    continue;
                }
                if (isset($after['order_id'])) {
                    if ($after['order_id'] != $id) {
                        continue;
                    }
                }
            }

            $diff = array_diff_assoc($after, $before);

            //Fix, usuwam nieustawione i nie potrzebne do zapisywania
            foreach ($diff as $ki => $vi) {
                if (is_array($diff[$ki])) {
                    foreach ($diff[$ki] as $kim => $vim) {
                        if (empty($diff[$ki][$kim])) {
                            unset($diff[$ki][$kim]);
                        }
                    }
                }
                if (empty($diff[$ki]) || in_array($ki, $this->Modification->ignoreList)) {
                    unset($diff[$ki]);
                }
            }

            if (isset($diff['modified'])) {
                unset($diff['modified']);
            }

            if (isset($after['address']) && isset($before['address']))
                if (is_array($before['invoice_identity']))
                    $diff['address'] = array_diff_assoc($after['address'], $before['address']);
            if (isset($after['invoice_identity']) && isset($before['invoice_identity']))
                if (is_array($before['invoice_identity']))
                    $diff['invoice_identity'] = array_diff_assoc($after['invoice_identity'], $before['invoice_identity']);

            if (empty($diff['address']))
                unset($diff['address']);
            if (empty($diff['invoice_identity']))
                unset($diff['invoice_identity']);

            if (!empty($diff)) {
                $diffs[] = array('date' => $after['modified'], 'User' => $value['User'], 'diff' => $diff, 'before' => $before, 'Modification' => $value['Modification']);
            }
        }
        return $diffs;
    }

    function paymentStatus($payment_id, $order_id) {
        $this->id = $order_id;
        $this->read();
        if ($this->data['Order']['order_status_id'] > 1) {
            //zamówienie już jest w trakcie realizacji
            return false;
        }

        if ($this->data['Order']['total'] <= $this->Payment->total($this->id, 'Order', 'Commerce')) {
            //zapłacono, więc ustaw status na "Przyjęto do realizacji"
            $this->data['Order']['order_status_id'] = 20;
            $this->save();
            return true;
        }
        return false;
    }

    function recalculateShipmentPrice($id = null) {
        if (!empty($id)) {
            $this->id = $id;
        }
        $this->recursive = 1;
        $shipmentMethodId = $this->field('shipment_method_id');
        $order = $this->read(null);
        $shipmentMethod = $this->getShipmentMethod($order);
//        $myShipment = $this->getShipmentMethod($order);

        foreach ($shipmentMethod as $k => $shipment) {
            if ($shipment['ShipmentMethod']['id'] == $shipmentMethodId) {
                $myShipment = $shipment;
                break;
            }
        }
        //pr($myShipment);
        $this->data['Order']['payment_type'] = $this->field('payment_type');
        $this->data['Order']['shipment_method_id'] = $shipmentMethodId;
        $this->data['Order']['shipment_price'] = $myShipment['ShipmentMethod']['final_price_gross'];
        if ($this->data['Order']['payment_type'] == 2) {
            $this->data['Order']['shipment_price'] += $myShipment['ShipmentMethod']['cash_on_delivery_price'];
        }

        $this->data['Order']['shipment_tax_value'] = $myShipment['ShipmentMethod']['final_tax_value'];
        $this->data['Order']['shipment_tax_rate'] = $myShipment['ShipmentMethod']['tax_rate'];
        
//        debug($this->data);exit;
        $this->save();
    }

    function reorganizeShipment($shipment_method_id, $weight) {
        $params['conditions']['ShipmentMethodConfig.shipment_method_id'] = $shipment_method_id;
        $params['conditions']['ShipmentMethodConfig.weight >='] = $weight;
        $params['order'] = 'ShipmentMethodConfig.weight ASC';
        $params['limit'] = 1;

        $shipmentMethod = $this->ShipmentMethod->ShipmentMethodConfig->find('first', $params);

        if (empty($shipmentMethod)) {
            //nie ma w skali kosztów wysyłki - trzeba podzielić na kilka paczek
            unSet($params['conditions']['ShipmentMethodConfig.weight >=']);
            $params['order'] = 'ShipmentMethodConfig.weight DESC';
            $shipmentMethod = $this->ShipmentMethod->ShipmentMethodConfig->find('first', $params);
//                debug($shipmentMethod['ShipmentMethodConfig']['weight']);
            if (!empty($shipmentMethod)) {
                $largePackages = floor($weight / $shipmentMethod['ShipmentMethodConfig']['weight']);

                $largePackagesPrice = $largePackages * $shipmentMethod['ShipmentMethodConfig']['price'];
                if(!empty($shipmentMethod['ShipmentMethodConfig']['weight']) && $shipmentMethod['ShipmentMethodConfig']['weight'] != 0) {
                    $lastPackageWeight = ceil($weight) % $shipmentMethod['ShipmentMethodConfig']['weight'];
                } else {
                    $lastPackageWeight = 0;
                }

                $params['conditions']['ShipmentMethodConfig.weight >='] = $lastPackageWeight;
                $params['order'] = 'ShipmentMethodConfig.weight ASC';
                $shipmentMethod = $this->ShipmentMethod->ShipmentMethodConfig->find('first', $params);
                $shipmentMethod['ShipmentMethodConfig']['price'] += $largePackagesPrice;
            }
        }

        if (isset($shipmentMethod['ShipmentMethodConfig']['price'])) {
            $tmp = Commerce::calculateByPriceType($shipmentMethod['ShipmentMethodConfig']['price'], $shipmentMethod['ShipmentMethod']['tax_rate'], 1);
            $shipmentMethod['ShipmentMethod']['price_net'] = $tmp['price_net'];
            $shipmentMethod['ShipmentMethod']['tax_rate'] = $shipmentMethod['ShipmentMethod']['tax_rate'];
            $shipmentMethod['ShipmentMethod']['price_gross'] = $tmp['price_gross'];
            $shipmentMethod['ShipmentMethod']['final_price_net'] = $tmp['final_price_net'];
            $shipmentMethod['ShipmentMethod']['final_tax_value'] = $tmp['final_tax_value'];
            $shipmentMethod['ShipmentMethod']['final_price_gross'] = $tmp['final_price_gross'];
        }
        return $shipmentMethod['ShipmentMethod'];
    }

    /**
     * Funkcja wyznacza sposoby dostawy oraz ceny dostaw
     * @param type $order
     * @return type
     */
    function getShipmentMethod($order) {

        $this->ShipmentMethod->recursive = -1;
        $this->shipmentMethods = $this->ShipmentMethod->find('all');
//        debug($this->shipmentMethods);
        $shipmentConfig = $this->ShipmentMethod->ShipmentMethodConfig->find('all', array('conditions' => array('ShipmentMethod.name' => 'Poczta Polska')));
//        debug($shipmentConfig);

        $getSummaryWeight = Commerce::getWeightByOrder($order['OrderItem']);

        if (!empty($shipmentConfig)) {
            $poczta_weight_max = $shipmentConfig[0]['ShipmentMethodConfig']['weight'] * 1000;   // przeliczam kg na g
            //debug($poczta_weight_max);
            //debug($getSummaryWeight);
            $poczta_id = $shipmentConfig[0]['ShipmentMethodConfig']['shipment_method_id'];
            if ($getSummaryWeight > $poczta_weight_max) {
                foreach ($this->shipmentMethods as $key => $value) {
                    if ($value['ShipmentMethod']['id'] == $poczta_id) {
//                        debug($item);
                        unset($this->shipmentMethods[$key]);
                    }
                }
            }
        }
        foreach ($this->shipmentMethods as $key => $value) {
            $tmp = $this->reorganizeShipment($value['ShipmentMethod']['id'], ($getSummaryWeight / 1000));
            if (!empty($tmp)) {
                $shipmentMethods[] = array('ShipmentMethod' => $tmp);
            } else {
                $tmp = Commerce::calculateByPriceType($value['ShipmentMethod']['shipment_price'], $value['ShipmentMethod']['tax_rate'], 1);
                $shopmentMethodTmp = $value;
                $shopmentMethodTmp['ShipmentMethod']['price_net'] = $tmp['price_net'];
                $shopmentMethodTmp['ShipmentMethod']['price_gross'] = $tmp['price_gross'];
                $shopmentMethodTmp['ShipmentMethod']['final_price_net'] = $tmp['final_price_net'];
                $shopmentMethodTmp['ShipmentMethod']['final_tax_value'] = $tmp['final_tax_value'];
                $shopmentMethodTmp['ShipmentMethod']['final_price_gross'] = $tmp['final_price_gross'];
                $shipmentMethods[] = $shopmentMethodTmp;
            }
        }
        //debug($shipmentMethods);
        return $shipmentMethods;
    }
    
    public function updateCookieLifeTime($order_id) {
        setcookie("CakeCookie[Order][hash]", "Q2FrZQ==." . base64_encode(Security::cipher($order_id, Configure::read('Security.salt'))), time()+7200, '/'); 
    }

    /**
     * Logika dla globalnej wyszukiwarki w cms
     * nadpisuje metodę z AppModel
     * 
     * @param array $options
     * @param array $params
     * @return type array
     */
//    public function search($options, $params = array()) {
//        $fraz = $options['Searcher']['fraz'];
//        $params['conditions']['OR']["Order.hash LIKE"] = "%{$fraz}%";
//        $params['limit'] = 5;
//        $this->recursive = 1;        
//        return $this->find('all', $params);
//    }
}

