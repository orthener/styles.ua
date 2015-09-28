<?php

class InvoiceHelper extends AppHelper {

    var $helpers = array('FebNumber');

    function bindPdfObject(&$pdf) {
        $this->pdf = &$pdf;
    }

    function printSeller($seller, $w = 90, $h = 33) {
        $txt = "{$seller['name']}

{$seller['address']}
{$seller['post_code']} {$seller['city']}
" . __d('commerce', 'NIP', true) . ": {$seller['nip']}
";

        if ($seller['phone']) {
            $txt .= __d('commerce', 'tel.', true) . ": {$seller['phone']}\n";
        }

        $x = $this->pdf->getX();
        $y = $this->pdf->getY();

//         $this->pdf->MultiCell($w, $h, '',
//             array('LTRB' => array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0))) 
//         ); //, 1, 'J', 1, 1, '' ,'', true

        $this->pdf->Rect($x + 2, $y + 2, $w, $h, 'DF', array('LTRB' => array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0)))
                , array(0, 0, 0));
        $this->pdf->Rect($x - 0.5, $y - 0.5, $w, $h, 'DF', array('LTRB' => array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0)))
                , array(255, 255, 255));
        $this->pdf->Rect($x + 2, $y + $h - 5, $w - 5, 0, 'DF', array('LTRB' => array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0)))
                , array(255, 255, 255));

        $this->pdf->SetFont('freesans', 'N', 10);

        $this->pdf->MultiCell($w - 1, $h - 1, $txt); //, 1, 'J', 1, 1, '' ,'', true

        $txt = "{$seller['name']} " . __d('commerce', 'NIP', true) . ": {$seller['nip']}";
        $txt .= __d('commerce', 'tel.', true) . ": {$seller['phone']}";

        $this->pdf->write2DBarcode($txt, 'QRCODE,H', $x + $w - 27, $y + 1, 25, 25);
    }

    function printInvoiceHeader($invoice, $copy = null, $x = 110, $y = 9.5, $w = 90, $h = 33) {

        if (!is_string($copy)) {
            $copy = __d('commerce', 'ORYGINAŁ/KOPIA', true);
        }

        $s_x = $this->pdf->getX();
        $s_y = $this->pdf->getY();

        $this->pdf->setXY($x, $y);

        $this->pdf->setFillColor(220);
        $this->pdf->SetFont('freesans', 'B', 13);
        $this->pdf->Cell($w, 8, __d('commerce', 'Faktura VAT', true), 0, 0, 'C', true);
        $this->pdf->setXY($x, $y + 8);
        $this->pdf->Cell($w, 8, sprintf(__d('commerce', 'nr %s', true), $invoice['number']), 0, 0, 'C');
        $this->pdf->setXY($x, $y + $h);
        $this->pdf->Cell($w, 8, $copy, 0, 0, 'L', true, '', 0, false, 'B');

        $this->pdf->SetFont('freesans', 'N', 8);

        $this->pdf->writeHTMLCell($w, 8, $x, $y + $h - 12, sprintf(
                        __d('commerce', 'data wystawienia: <b>%s</b>', true), date('j.m.Y \r', strtotime($invoice['created']))
                ), 0, 0, false, true, 'L');

        $this->pdf->writeHTMLCell($w, 8, $x, $y + $h - 12, sprintf(
                        __d('commerce', 'data sprzedaży: <b>%s</b>', true), date('j.m.Y \r', strtotime($invoice['created']))
                ), 0, 0, false, true, 'R');

        $this->pdf->setXY($s_x, $s_y);
    }

    function printBuyer($buyer, $buyer_is_company, $w = 90, $h = 33) {

        $labels = array(
            10 => __d('commerce', 'Nabywca', true),
            110 => __d('commerce', 'Odbiorca', true),
        );

        $x = $this->pdf->getX();
        $y = $this->pdf->getY();

        foreach ($labels AS $key => $value) {
            $this->pdf->setXY($key, $y);

            $txt = "<br /><br /><b>{$value}:</b><br />
                    {$buyer['name']}<br />
                    <br />
                    {$buyer['address']}<br />
                    {$buyer['post_code']} {$buyer['city']}";

            if ($buyer_is_company) {
                $txt .= "<br />" . __d('commerce', 'NIP', true) . ": {$buyer['nip']}";
            }

            $this->pdf->SetFont('freesans', 'N', 10);

            $this->pdf->MultiCell($w, $h, $txt, 0, 'L', false, 1, '', '', true, 0, true);
        }
    }

}

?>