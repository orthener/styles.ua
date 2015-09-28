<?php

App::uses('AppController', 'Controller');

/**
 * Eurocookies Controller
 * Wyświetla informację o używaniu przez stronę plików cookie
 *
 *  * @author Tomasz Skręt <t.skret@feb.net.pl>
 */
class EurocookiesController extends AppController {
    /**
     * Nazwa layoutu
     */
    public $layout = 'ajax';

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array('Html', 'Js');

    /**
     * Tablica komponentów doładowywana do kontrolera
     */
    public $components = array();

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('cookie', 'politykaCookies');
    }

    function cookie() {
        $this->render('/Elements/cookie');
    }

    /**
     * Informacja o przetwarzaniu cookies
     */
    function politykaCookies() {
        $this->render('/polityka_cookies');
    }

}
