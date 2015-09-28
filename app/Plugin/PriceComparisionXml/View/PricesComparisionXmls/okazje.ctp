<?php

/**
 * Output XML for okazje.info.pl
 * 
 * @todo add category
 */
/* @var $xml XMLWriter */

$xml = new XMLWriter();
$xml->openMemory();
$xml->setIndent(true);
$xml->setIndentString('    ');
$xml->startDocument('1.0', 'UTF-8');
$xml->startElement('okazje');
$xml->startElement('offers');

$img_path = Router::url('/', true);

foreach ($products as $product) {
    $productLink = array('plugin' => 'static_product', 'controller' => 'products', 'action' => 'view', $product['Product']['slug']);

    $xml->startElement('offer');
    // Nazwa produktu
    $xml->startElement('name');
    $xml->writeCdata($product['Product']['title']);
    $xml->endElement();
    // wymagane
    $xml->writeElement('id', $product['Product']['id']);
    $xml->writeElement('url', $this->Html->url($productLink, true));
    $xml->writeElement('price', $product['Product']['price']);
    $xml->writeElement('producer', $product['Product']['producer']);

    //niewymagane

    $xml->startElement('attribute');
    $xml->writeAttribute('name', 'EAN');
    $xml->writeCdata('');
    $xml->endElement();


    // opis
    if ($product['Product']['content']) {
        // opis produktu (krótki)
        $xml->startElement('description');
        $xml->writeCdata($product['Product']['content']);
        $xml->endElement();
    }

    if ($product['Photo']) {
        $xml->writeElement('image', $img_path . 'files/photo/' . $product['Photo']['img']);
    }

    $xml->endElement(); //offer
}

$xml->endElement(); // offers
$xml->endElement(); // okazje
$xml->endDocument();

//        $this->header('Content-type: text/xml');

$this->set('xml', $xml);


echo $xml->outputMemory();