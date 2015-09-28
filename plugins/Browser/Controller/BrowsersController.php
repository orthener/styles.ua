<?php

App::uses('AppController', 'Controller');

/**
 * Searchers Controller
 *
 * @property Searcher $Searcher
 */
class BrowsersController extends AppController {

    /**
     * Nazwa layoutu
     */
    //public $layout = 'admin';

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array();

    /**
     * Tablica komponentów doładowywana do kontrolera
     */
    public $components = array('Browser.Browser');

    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('noNoticeBrowser','browser');

    }
    
    function browser(){
        $browser['browser'] = $this->Browser->getBrowser();
        $browser['version'] = (int)$this->Browser->getVersion();
        $this->set(compact('browser'));
        $this->render('/Elements/browser');
    }
    function noNoticeBrowser(){
        $this->Session->write('Browser.notice',true);
        $this->render(false);
        return false;
    }

}
