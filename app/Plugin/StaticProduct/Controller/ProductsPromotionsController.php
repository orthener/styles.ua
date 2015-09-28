<?php

App::uses('AppController', 'Controller');

/**
 * ProductCategories Controller
 *
 * @property ProductsPromotion $ProductsPromotion
 */
class ProductsPromotionsController extends AppController {

    /**
     * Nazwa layoutu
     */
    public $layout = 'admin';

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array();

    /**
     * Tablica komponentów doładowywana do kontrolera
     */
    public $components = array();

    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function admin_index($porductId = null) {
        $this->helpers[] = 'FebTime';

        $this->ProductsPromotion->recursive = 1;
        $params['conditions']['product_id'] = $porductId;
        $this->paginate = $params;
        $productsPromotions = $this->paginate();
        $this->set(compact('productsPromotions'));
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->ProductsPromotion->id = $id;
        if (!$this->ProductsPromotion->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('productsPromotion', $this->ProductsPromotion->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add($porductId = null) {
        if ($this->request->is('post')) {
            $this->ProductsPromotion->create();

            if ($this->ProductsPromotion->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                //$this->redirect(array('action' => 'index',$this->request->data['ProductsPromotion']['product_id'] ));
                $this->redirect(array('action' => 'index',$this->request->data['ProductsPromotion']['product_id'] ));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
        if($porductId){
            $this->request->data['ProductsPromotion']['product_id'] = $porductId;
        }
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->ProductsPromotion->id = $id;
        if (!$this->ProductsPromotion->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ProductsPromotion->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index', $this->request->data['ProductsPromotion']['product_id']));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
            }
        } else {
            $this->ProductsPromotion->locale = Configure::read('Config.languages');
            $this->request->data = $this->ProductsPromotion->read(null, $id);
        }
    }

    /**
     * Akcja usuwająca obiekt
     *
     * @param string $id
     * @return void
     */
    function admin_delete($id = null, $all = null) {
        $this->FebI18n->delete($id, $all);
        //$this->redirect(array('action' => 'index'), null, true);
        $this->redirect($this->referer(), null, true);
    }

}
