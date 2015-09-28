<?php
class Invoice extends AppModel {

	var $name = 'Invoice';

    var $jsonEncoded = array('seller', 'buyer', 'items', 'taxes', 'payments');

    var $numberPrefixCompany = 'FV';

    var $numberPrefixPerson = 'FA';

    var $numberSufix = '';

    var $numberPeriod = 'year'; //possible values: month, year

//     //The Associations
//     var $belongsTo = array(
//         'User' => array(
//             'className' => 'User',
//             'foreignKey' => 'users_id',
//             'conditions' => '',
//             'fields' => '',
//             'order' => ''
//         )
//     );

//     //The Associations
//     var $hasMany = array(
//         'InvoiceDuplicate' => array(
//             'className' => 'InvoiceDuplicate',
//             'foreignKey' => 'invoice_id',
//         )
//     );


    function create($data = array(), $filterKey = false){
        if(empty($data)){
            return parent::create($data, $filterKey);
        }
        parent::create();

        $data[$this->alias]['price_type'] = PRICE_TYPE;
        if($data[$this->alias]['buyer_is_company']){
            $data[$this->alias]['number_prefix'] = $this->numberPrefixCompany;
        } else {
            $data[$this->alias]['number_prefix'] = $this->numberPrefixPerson;
        }
        $data[$this->alias]['number_period'] = $this->numberPeriod;
        $data[$this->alias]['number_sufix'] = $this->numberSufix;

        $data[$this->alias]['taxes'] = Commerce::calculateTotalTax($data[$this->alias]['items']);
//        $total = Commerce::getTotalPricesForOrder($data[$this->alias]['taxes']);
        $total = Commerce::getTotalPricesForOrder($data[$this->alias]);

        $data[$this->alias]['total_net'] = $total['final_price_net'];
        $data[$this->alias]['total_tax'] = $total['final_tax_value'];
        $data[$this->alias]['total_gross'] = $total['final_price_gross'];

        $this->request->data = $data;

        $this->id = $this->insertNextNumber();
        
        if($this->id == false){
            return false;
        }
        
        $this->request->data[$this->alias]['id'] = $this->id;
        $this->request->data[$this->alias]['pdf'] = Inflector::slug($this->field('number')).'.pdf';

        $this->save($this->request->data);

        $this->requestAction(array('prefix' => 'admin', 'admin' => 'admin', 'plugin' => 'payments', 'controller' => 'invoices', 'action' => 'pdf'), array('pass' => array($this->id)));
        
        return true;
    }

    private function insertNextNumber(){

        $now = time();
        $created = date('Y-m-d H:i:s', $now);
        $prefix = $this->request->data[$this->alias]['number_prefix']?$this->request->data[$this->alias]['number_prefix'].'/':'';
        $sufix = $this->request->data[$this->alias]['number_sufix']?'/'.$this->request->data[$this->alias]['number_sufix']:'';

        switch($this->request->data[$this->alias]['number_period']){
            case 'month':
                $date_from = date('Y-m-01 00:00:00', $now);
                $date_to = date('Y-m-t 00:00:00', $now);
                $date = date('m/Y', $now);
                break;
            case 'year':
                $date_from = date('Y-01-01 00:00:00', $now);
                $date_to = date('Y-12-31 00:00:00', $now);
                $date = date('Y', $now);
                break;
            default:
                die("Error: Invoice.number_period must be set to 'month' or 'year'");
        }

        $query = "INSERT INTO invoices (number_prefix, number_int, number_period, number_sufix, number, created) SELECT 
            '{$this->request->data[$this->alias]['number_prefix']}',
            IF(MAX(number_int), MAX(number_int)+1, 1),
            '{$this->request->data[$this->alias]['number_period']}',
            '{$this->request->data[$this->alias]['number_sufix']}',
            CONCAT(
                '{$prefix}', 
                IF(MAX(number_int), 
                MAX(number_int)+1, 1), 
                '/', 
                '{$date}', 
                '{$sufix}'
            ) ,
            '{$created}'
            FROM invoices
                WHERE created BETWEEN '{$date_from}' AND '{$date_to}'";

//                debug($query);
        if($this->query($query)){
            $id = $this->query("SELECT LAST_INSERT_ID() AS id;");
            return $id[0][0]['id'];
        }
        
        return false;
    }

    function beforeSave($options = array()) {
        foreach($this->jsonEncoded AS $field){
            if (isset($this->request->data[$this->alias][$field]) AND is_array($this->request->data[$this->alias][$field])) {
                $this->request->data[$this->alias][$field] = json_encode($this->request->data[$this->alias][$field]);
            }
        }
        return true;
    }

    function afterFind($results, $primary = false) {

        //loop over all records that have been found
        foreach ($results as $key => $value) {
            if (is_array($value)) {
                //search for all fields that have been json_encoded
                foreach($this->jsonEncoded AS $field){
                    if (isset($value[$this->alias][$field])) {
                        //if found one, json_decode it
                        $tmp = json_decode($value[$this->alias][$field], true);
                        if (is_array($tmp)) {
                            $results[$key][$this->alias][$field] = $tmp;
                        }
                    }
                }
            }
        }

        return $results;
    }
    
}
?>