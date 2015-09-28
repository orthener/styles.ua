<?php

class InvoicesController extends AppController {

    var $name = 'Invoices';
    var $helpers = array('FebNumber', 'Payments.Invoice');
    var $components = array('FebEmail');
    var $layout = 'admin';

    function admin_month($year = null, $month = null){

        if($year == null){ $year = date('Y'); }
        if($month == null){ $month = date('m'); }
        
        $this->year = $year;

        $month_begin_time = date("Y-m-01", strtotime($year.'-'.$month.'-01 00:00:00'));
        $month_end_time = date("Y-m-t", strtotime($year.'-'.$month.'-01 00:00:00'));

        $this->set('month_begin_time', $month_begin_time);
        $this->set('month_end_time', $month_end_time);

        $this_month_begin_time = strtotime($month_begin_time);
        $this->set('month_begin_timestamp', $this_month_begin_time);
        
        $max_time = date("Y-m-01", strtotime('-1 month'));
        
        if($month_begin_time > $max_time){
            $this->set('max_time_excedded', true);
        }

        $params = array('conditions' => array(
            'Invoice.invoice_date >=' => $month_begin_time,
            'Invoice.invoice_date <=' => $month_end_time,
        ), 'order' => 'Invoice.id ASC');

        $set_params = $params;
        
        $set_params['group'] = array('Invoice.number_prefix', 'Invoice.number_sufix');
        $set_params['fields'] = array('Invoice.number_prefix', 'Invoice.number_sufix');
        
        $invoicesSets = $this->Invoice->find('all', $set_params);

        $invoicesGroups = array();
        foreach($invoicesSets AS $set){
            $params['conditions']['Invoice.number_prefix'] = $set['Invoice']['number_prefix'];
            $params['conditions']['Invoice.number_sufix'] = $set['Invoice']['number_sufix'];
            $key = $set['Invoice']['number_prefix'].'/'.date("Y/m", $this_month_begin_time);
            $key .= $set['Invoice']['number_sufix']?'/'.$set['Invoice']['number_sufix']:'';
            $invoicesGroups[$key] = $this->Invoice->find('all', $params);
        }
        
        $this->set('invoicesGroups', $invoicesGroups);
    }

    function admin_getpdf($id = null){

        $destDir = WWW_ROOT . 'files' . DS . 'invoice' . DS;

        $invoice = $this->Invoice->read(null, $id);

        $file = $destDir . $invoice['Invoice']['pdf'];

        if (empty($invoice['Invoice']['pdf']) OR !file_exists($file)) {
            $this->requestAction(array('prefix' => 'admin', 'admin' => 'admin', 'plugin' => 'payments', 'controller' => 'invoices', 'action' => 'pdf'), array('pass' => array($id)));
        }


        if (file_exists($file)) {
            $this->set('file', $file);
            $this->render('pdffromfile');
        } else {
            $this->cakeError('error404');
        }
    }

    function admin_pdf($id = null, $return = null) {

        $this->layout = 'pdf';
        
        $invoice = $this->Invoice->read(null, $id);
        

        $this->set('invoice', $invoice);

        return $this->render();
        
        //exit(1);
    }

    function odmiana($odmiany, $int) { // $odmiany = Array('jeden','dwa','pięć')
        $txt = $odmiany[2];
        if ($int == 1)
            $txt = $odmiany[0];
        $jednosci = (int) substr($int, -1);
        $reszta = $int % 100;
        if (($jednosci > 1 && $jednosci < 5) & !($reszta > 10 && $reszta < 20))
            $txt = $odmiany[1];
        return $txt;
    }

    function liczba($int) { // odmiana dla liczb < 1000
        global $slowa;
        $wynik = '';
        $j = abs((int) $int);

        if ($j == 0)
            return $slowa[1][0];
        $jednosci = $j % 10;
        $dziesiatki = ($j % 100 - $jednosci) / 10;
        $setki = ($j - $dziesiatki * 10 - $jednosci) / 100;

        if ($setki > 0)
            $wynik .= $this->slowa[4][$setki - 1] . ' ';

        if ($dziesiatki > 0)
            if ($dziesiatki == 1)
                $wynik .= $this->slowa[2][$jednosci] . ' ';
            else
                $wynik .= $this->slowa[3][$dziesiatki - 1] . ' ';

        if ($jednosci > 0 && $dziesiatki != 1)
            $wynik .= $this->slowa[1][$jednosci] . ' ';
        return $wynik;
    }

    function slownie($int) {

        global $slowa;

        $in = preg_replace('/[^-\d]+/', '', $int);
        $out = '';

        if ($in{0} == '-') {
            $in = substr($in, 1);
            $out = $this->slowa[0] . ' ';
        }

        $txt = str_split(strrev($in), 3);

        if ($in == 0)
            $out = $this->slowa[1][0] . ' ';

        for ($i = count($txt) - 1; $i >= 0; $i--) {
            $liczba = (int) strrev($txt[$i]);
            if ($liczba > 0)
                if ($i == 0)
                    $out .= $this->liczba($liczba) . ' ';
                else
                    $out .= ( $liczba > 1 ? $this->liczba($liczba) . ' ' : '')
                            . $this->odmiana($this->slowa[4 + $i], $liczba) . ' ';
        }
        return trim($out);
    }

}

?>