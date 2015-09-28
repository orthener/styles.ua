<?php

/**
 * Output XML for ceneo.pl
 */
/* @var $xml XMLWriter */

$xml = new XMLWriter();
$xml->openMemory();
$xml->setIndent(true);
$xml->setIndentString('    ');
$xml->startDocument('1.0', 'UTF-8');
$xml->startElement('offers');
$xml->writeAttribute('version', 1);

//        <o id = "151" url = "http://www.sklep.tel.pl/id=158" price = "980.15" avail = "1"
//        set = "0" weight = "3.5" basket = "1" stock = "2">
//        <cat>
//        <![CDATA[Komputery/Monitory/Monitory LCD]]>
//        </cat>
//        <name>
//        <![CDATA[Dell UB13H]]>
//        </name>
//        <imgs>
//        <main url = "http://www.sklep.pl/images/151big.jpg"/>
//        <i url = "http://www.sklep.pl/images/151small.jpg"/>
//        </imgs>
//        <desc>
//        <![CDATA[Matryca monitora wykonana z niezwykle...]]>
//        </desc>
//        <attrs>
//        <a name = "Producent">
//        <![CDATA[Dell]]>
//        </a>
//        <a name = "Kod_producenta">
//        <![CDATA[UB13H]]>
//        </a>
//        <a name = "EAN">
//        <![CDATA[142521534124]]>
//        </a>
//        </attrs>
//        </o>

$img_path = Router::url('/', true);

foreach ($products as $product) {
    $productLink = array('plugin' => 'static_product', 'controller' => 'products', 'action' => 'view', $product['Product']['slug']);

    $xml->startElement('o');
    // wymagane
    $xml->writeAttribute('id', $product['Product']['id']);
    $xml->writeAttribute('url', $this->Html->url($productLink, true));
    $xml->writeAttribute('price', $product['Product']['price']);
    //niewymagane
    // Nazwa produktu
    $xml->startElement('name');
    $xml->writeCdata($product['Product']['title']);
    $xml->endElement();
    // cat
    $xml->startElement('cat');
    if (count($product['ProductsCategory']) > 0) {
        foreach ($product['ProductsCategory'] as $category) {
//            $xml->writeCdata($products_categories['Product']['title']);
        }
    }
    $xml->endElement();


    if ($product['Product']['tiny_content']) {
        // opis produktu (krótki)
        $xml->startElement('desc');
        $xml->writeCdata(strip_tags($product['Product']['tiny_content']));
        $xml->endElement();
    }

    if ($product['Photo']) {
        $xml->startElement('imgs'); // imgs

        $xml->startElement('main');
        $xml->writeAttribute('url', $img_path . 'files/photo/' . $product['Photo']['img']);
        $xml->endElement(); // main

        $xml->endElement(); // imgs
    }

    $xml->endElement();
}

$xml->endElement();
$xml->endDocument();

//        $this->header('Content-type: text/xml');

$this->set('xml', $xml);


echo $xml->outputMemory();