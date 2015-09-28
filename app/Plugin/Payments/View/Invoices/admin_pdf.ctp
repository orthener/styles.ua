<?php

App::import('Vendor','tcpdf/tcpdf'); 

$tcpdf = new TCPDF();
$this->Invoice->bindPdfObject($tcpdf);

$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans'

$tcpdf->SetAuthor($invoice['Invoice']['seller']['creator_person']);
$tcpdf->SetTitle(__d('payments', 'Faktura VAT nr ', true) . $invoice['Invoice']['number']);
$tcpdf->SetAutoPageBreak(false);

// remove default header/footer
$tcpdf->setPrintHeader(false);
$tcpdf->setPrintFooter(false);

$tcpdf->SetTextColor(0, 0, 0);

$copies = array(__d('commerce', 'ORYGINAŁ', true), __d('commerce', 'KOPIA', true));

foreach($copies AS $label){
    $tcpdf->AddPage();
    
    $this->Invoice->printSeller($invoice['Invoice']['seller']);
    $this->Invoice->printInvoiceHeader($invoice['Invoice'], $label);
    $this->Invoice->printBuyer($invoice['Invoice']['buyer'], $invoice['Invoice']['buyer_is_company']);

    $tcpdf->MultiCell(190, 10, $this->element('invoice_table', array('invoice' => $invoice)), 0, 'L', false, 1, '' ,'', true, 0, true);

    $y = $tcpdf->getY()+6;

    $tcpdf->writeHTMLCell(80, 0, 100, $y, $this->element('invoice_table_taxes', array('invoice' => $invoice)));

    $tcpdf->writeHTMLCell(80, 0, 10, $y, $this->element('invoice_table_payments', array('invoice' => $invoice)));
//     debug($tcpdf->getY());
//     exit;
    $tcpdf->setXY(10, $tcpdf->getY()+40);

    $tcpdf->MultiCell(190, 10, $this->element('invoice_summary', array('invoice' => $invoice)), 0, 'L', false, 1, '' ,'', true, 0, true);
    
}



// ...
// etc.
// see the TCPDF examples 
// D I 
$path = WWW_ROOT.'files'.DS.'invoice'.DS;
echo $tcpdf->Output($path.$invoice['Invoice']['pdf'], 'F');

?>