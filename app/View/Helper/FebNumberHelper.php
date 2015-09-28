<?php

class FebNumberHelper extends AppHelper {

    var $helpers = array('Number', 'Html');
    var $slowa = Array(
        'minus',
        Array(
            'zero',
            'jeden',
            'dwa',
            'trzy',
            'cztery',
            'pięć',
            'sześć',
            'siedem',
            'osiem',
            'dziewięć'),
        Array(
            'dziesięć',
            'jedenaście',
            'dwanaście',
            'trzynaście',
            'czternaście',
            'piętnaście',
            'szesnaście',
            'siedemnaście',
            'osiemnaście',
            'dziewiętnaście'),
        Array(
            'dziesięć',
            'dwadzieścia',
            'trzydzieści',
            'czterdzieści',
            'pięćdziesiąt',
            'sześćdziesiąt',
            'siedemdziesiąt',
            'osiemdziesiąt',
            'dziewięćdziesiąt'),
        Array(
            'sto',
            'dwieście',
            'trzysta',
            'czterysta',
            'pięćset',
            'sześćset',
            'siedemset',
            'osiemset',
            'dziewięćset'),
        Array(
            'tysiąc',
            'tysiące',
            'tysięcy'),
        Array(
            'milion',
            'miliony',
            'milionów'),
        Array(
            'miliard',
            'miliardy',
            'miliardów'),
        Array(
            'bilion',
            'biliony',
            'bilionów'),
        Array(
            'biliard',
            'biliardy',
            'biliardów'),
        Array(
            'trylion',
            'tryliony',
            'trylionów'),
        Array(
            'tryliard',
            'tryliardy',
            'tryliardów'),
        Array(
            'kwadrylion',
            'kwadryliony',
            'kwadrylionów'),
        Array(
            'kwintylion',
            'kwintyliony',
            'kwintylionów'),
        Array(
            'sekstylion',
            'sekstyliony',
            'sekstylionów'),
        Array(
            'septylion',
            'septyliony',
            'septylionów'),
        Array(
            'oktylion',
            'oktyliony',
            'oktylionów'),
        Array(
            'nonylion',
            'nonyliony',
            'nonylionów'),
        Array(
            'decylion',
            'decyliony',
            'decylionów')
    );

    function priceFormat($price, $options = array(), $spanOptions = array()) {
        $standartOptions = array(
            'places' => 2,
            'before' => false,
            'after' => ' ₴',
            'escape' => true,
            'decimals' => ',',
            'thousands' => ' '
        );
        $options = array_merge($options, $standartOptions);
        $ret = $this->Number->format($price, $options);
        $standardSpanOptions = array(
            'price' => $price,
        );
        $spanOptions = array_merge($spanOptions, $standardSpanOptions);
        $rett = $this->Html->tag('span', $ret, $spanOptions);
        return $rett;
    }
    /**
     * Funkcja generuje cenę w formacie domyslnym tj. 12 345,67
     * uzywając helpera Number
     * @param type $price - cena
     * @param type $currency - waluta
     * @param type $options - dodatkowe opcje
     */
    function currency($price, $currency = 'PLN', $options = array()) {
        $defaultOptions['zero'] = '0,00 ' . $currency;
        $defaultOptions['decimals'] = ',';
        $defaultOptions['thousands'] = ' ';
        $defaultOptions['places'] = 2;
        $defaultOptions['wholePosition'] = true;
        $mergeOptions = array_merge($defaultOptions, $options);
        
        $result = $this->Number->currency($price, $currency, $mergeOptions);
        return $result;
    }
    
    function priceInWords($price){
        $price = explode('.',$price);
        $ret = $this->numberInWords($price[0]);
        if (!empty($price[1])) {
            $ret .= " {$price[1]}/100 ₴";
        }
        return $ret;
    }
    

    function numberInWords($price) {
        global $slowa;
      
        $in = preg_replace('/[^-\d]+/','',$price);
        $out = '';
      
        if ($in{0} == '-'){
          $in = substr($in, 1);
          $out = $this->slowa[0].' ';
        }
      
        $txt = str_split(strrev($in), 3);
    
        if ($in == 0) $out = $this->slowa[1][0].' ';
    
        for ($i = count($txt) - 1; $i >= 0; $i--){
          $liczba = (int) strrev($txt[$i]);
          if ($liczba > 0)
            if ($i == 0)
              $out .= $this->liczba($liczba).' ';
                else
              $out .= ($liczba > 1 ? $this->liczba($liczba).' ' : '')
                .$this->odmiana( $this->slowa[4 + $i], $liczba).' ';
        }
        return trim($out); 
    }
    
    private function liczba($int){ // odmiana dla liczb < 1000
        global $slowa;
        $wynik = '';
        $j = abs((int) $int);
      
        if ($j == 0) return $slowa[1][0];
        $jednosci = $j % 10;
        $dziesiatki = ($j % 100 - $jednosci) / 10;
        $setki = ($j - $dziesiatki*10 - $jednosci) / 100;
      
        if ($setki > 0) $wynik .= $this->slowa[4][$setki-1].' ';
    
        if ($dziesiatki > 0)
              if ($dziesiatki == 1) $wynik .= $this->slowa[2][$jednosci].' ';
        else
          $wynik .= $this->slowa[3][$dziesiatki-1].' ';
      
        if ($jednosci > 0 && $dziesiatki != 1) $wynik .= $this->slowa[1][$jednosci].' ';
        return $wynik;
    }
    
    private function odmiana($odmiany, $int) { // $odmiany = Array('jeden','dwa','pięć')
        $txt = $odmiany[2];
        if ($int == 1) $txt = $odmiany[0];
        $jednosci = (int) substr($int,-1);
        $reszta = $int % 100;
        if (($jednosci > 1 && $jednosci < 5) &! ($reszta > 10 && $reszta < 20))
          $txt = $odmiany[1];
        return $txt;
    }
    

}

?>