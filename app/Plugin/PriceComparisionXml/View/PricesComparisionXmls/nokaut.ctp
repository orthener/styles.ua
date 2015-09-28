<?php

/**
 * Output XML for nokaut.pl
 */
/* @var $xml XMLWriter */

$xml = new XMLWriter();
$xml->openMemory();
$xml->setIndent(true);
$xml->setIndentString('    ');
$xml->startDocument('1.0', 'UTF-8');
$xml->startElement('nokaut');
$xml->startElement('offers');

$img_path = Router::url('/', true);

foreach ($products as $product) {
    $productLink = array('plugin' => 'static_product', 'controller' => 'products', 'action' => 'view', $product['Product']['slug']);

    $xml->startElement('offer');
    // id
    $xml->writeElement('id', $product['Product']['id']);
    // name
    $xml->startElement('name');
    $xml->writeCdata($product['Product']['title']);
    $xml->endElement();
    // description
    if ($product['Product']['content']) {
        // opis produktu (krótki)
        $xml->startElement('description');
        $xml->writeCdata($product['Product']['content']);
        $xml->endElement();
    }
    // url
    $xml->writeElement('url', $this->Html->url($productLink, true));
    // image
    if ($product['Photo']) {
        $xml->writeElement('image', $img_path . 'files/photo/' . $product['Photo']['img']);
    }
    // weight
//    $xml->writeElement('weight', $product['Product']['weight']);
    // price
    $xml->writeElement('price', $product['Product']['price']);
    // TODO: category
    // producer
    $xml->startElement('producer');
    $xml->writeCdata($product['Product']['producer']);
    $xml->endElement();

    //niewymagane

    $xml->startElement('attribute');
    $xml->writeAttribute('name', 'EAN');
    $xml->writeCdata('');
    $xml->endElement();


    // opis


    $xml->endElement(); //offer
}

$xml->endElement(); // offers
$xml->endElement(); // nokaut
$xml->endDocument();

//        $this->header('Content-type: text/xml');

$this->set('xml', $xml);


echo $xml->outputMemory();