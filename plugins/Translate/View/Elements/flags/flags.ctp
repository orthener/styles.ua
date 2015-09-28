<?php

/*
  Parametry jakie są w elemencie

  url - link gdzie ma kierować flaga
  active - która flaga ma być aktywna np: array('pl'=>1)
  title - tytuł strony z automatu jest dodawana nazwa języka

 */

//prefix lang
$params = isset($this->params['lang']) ? $this->params['lang'] : 'pol';
//debug($params);
//przygotowanie tabeli active jezeli jest zdefiniowana z translateDisplay
if (isset($active[0]['locale'])) {
    //lista aktywnych języków
    foreach ($active as &$activeTmp) {
        $active[$activeTmp['locale']] = true;
    }
}
//gdy nie zdefinowane active to pobieramy z parametru lang
$active = isset($active) ? $active : array($params => 1);

$pass = isset($this->params['pass']) ? $this->params['pass'] : array();
//gdy nie zdefinowane url pobieramy domyslne
$url = isset($url) ? $url : $pass;

//tytul linku
$title = isset($title) ? $title . ' - ' : '';

$languages = isset($languages) ? $languages : array();


foreach ($languages AS &$lang) {
    if (!empty($lang['Lang']['name']) && $lang['Lang']['name'] == 'polski') {
        $lang['Lang']['name'] = __d('cms', 'Название');
    }
    //parametr lang dla pl brak
    $prefixLink = $lang['Lang']['code'] == 'pol' ? false : $lang['Lang']['code'];
    //link adres
    $langLink = is_array($url) ? array_merge($url, array('lang' => $prefixLink)) : '/' . $prefixLink . $url;
    //aktywny język
    $langActive = (!empty($active[$lang['Lang']['code']]) or !empty($active[$lang['Lang']['lc']]) ) ? 'active' : '';

    //opcje do linku takie jak title oraz classa
    $langOptions = array('class' => "{$lang['Lang']['lc']} flag $langActive", 'title' => $title . $lang['Lang']['name']);

    //Opcja dodajaca dodatkowe mozliwosci na elemencie flagi
    $langOptions = isset($addit) ? array_merge($addit, $langOptions) : $langOptions;
//    debug($langOptions);
    //generowany link zpodanych parametrów
    echo $this->Html->link($lang['Lang']['name'], $langLink, $langOptions);
    break;
}

//uwolnienie pamięci
unset($params, $active, $url, $prefixLink, $langActive, $langTitle, $langOptions, $title);
?>