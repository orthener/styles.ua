<?php

App::uses('AppController', 'Controller');

/**
 * InfoPages Controller
 *
 * @property InfoPage $InfoPage
 * @property InfoTag $InfoTag
 */
class InfoPagesController extends AppController {

    /**
     * Nazwa layoutu
     */
    public $layout = 'admin';

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array('FebSocial', 'FebTinyMce4');

    /**
     * Tablica komponentów doładowywana do kontrolera
     */
    public $components = array('Slug.Slug', 'Filtering');
    public $uses = array('Info.InfoPage', 'Info.InfoTag');

    /**
     * Callback wykonywujący się przed wykonaniem akcji kontrollera
     * 
     * @access public 
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('index', 'view'));
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function index($slug = null) {
        $this->layout = 'default';
        $this->helpers += array('Filter');

        $this->filters = array(
            'InfoPage.category_id' => array('param_name' => 'category'),
            'InfoPage.tag' => array('param_name' => 'tag'),
        );
        $filtersParams = $this->Filtering->getParams();

        $params = array('conditions' => array());
        $params = $this->InfoPage->filterParams($this->request->data);
        $params['limit'] = 10;
        $on_blog = 1;   // domyślne ustawienie dla blogu
        if (isset($slug) && !empty($slug)) {
            $on_blog = $slug == 'blog' ? 1 : 0;
            $params['conditions']['InfoPage.on_blog'] = $on_blog;
        }
        $start_date = date('Y-m-d');
        $params['conditions']['InfoPage.publication_date <='] = date('Y-m-d');
        $params['order'] = 'InfoPage.publication_date DESC';
        //$params['conditions']['InfoPage.selection_id'] = $this->selection_id;
        $this->paginate = $params;
        $this->InfoPage->recursive = 0;
        $infoCategories = $this->InfoPage->InfoCategory->find('list', array(
            'conditions' => array(
                'InfoCategory.selection_id' => $this->selection_id,
            //'InfoPage.on_blog' => $on_blog
            )
        ));
        //debug($infoCategories);
        $tags = $this->InfoPage->InfoTag->find('all', array(
            'conditions' => array(
                'InfoTag.selection_id' => $this->selection_id,
            //'InfoPage.on_blog' => $on_blog
            )
        ));

        $this->set(compact('filtersParams', 'infoCategories', 'tags', 'on_blog'));
        $this->set('infoPages', $this->paginate());
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->layout = 'default';
        $id = $this->Slug->basic($id);
        $this->InfoPage->id = $id;
        $this->InfoPage->recursive = 1;
        if (!$this->InfoPage->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }

        $febSocial = null; //new $this->FebSocialHelper('view');
        $this->set(compact('febSocial'));
        $this->set('infoPage', $this->InfoPage->read());
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function admin_index() {

        $this->helpers[] = 'FebTime';
        $this->InfoPage->recursive = 1;
        $this->InfoPage->locale = Configure::read('Config.languages');
        $this->InfoPage->bindTranslation(array($this->InfoPage->displayField => 'translateDisplay'));
        $params['conditions']['InfoPage.selection_id'] = $this->selection_id;
        $this->paginate = $params;
        $this->set('infoPages', $this->paginate());

        $categories = $this->InfoPage->InfoCategory->find('list', array(
            'conditions' => array(
                'InfoCategory.selection_id' => $this->selection_id
            )
        ));
        $this->set(compact('categories'));
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->InfoPage->id = $id;
        if (!$this->InfoPage->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('infoPage', $this->InfoPage->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $dataSource = $this->InfoPage->getDataSource();
            $dataSource->begin($this->InfoPage);
            try {
                $this->InfoPage->create();
                $this->request->data['InfoPage']['selection_id'] = $this->selection_id;
                if (!$this->InfoPage->save($this->request->data)) {
                    throw new Exception(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'));
                }

                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $dataSource->commit($this->InfoPage);
                $this->redirect(array('action' => 'index'));
            } catch (Exception $exc) {
                $dataSource->rollback($this->InfoPage);
                $this->Session->setFlash($exc->getMessage(), 'flash/error');
//                throw $exc;
            }
        }

        $categories = $this->InfoPage->InfoCategory->find('list', array(
            'conditions' => array(
                'InfoCategory.selection_id' => $this->selection_id
            )
        ));
        $this->set(compact('categories'));
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->InfoPage->id = $id;
        if (!$this->InfoPage->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $dataSource = $this->InfoPage->getDataSource();
            $dataSource->begin($this->InfoPage);

            try {

                $this->InfoPage->create();
                $this->request->data['InfoPage']['selection_id'] = $this->selection_id;
                if (!$this->InfoPage->save($this->request->data)) {
                    throw new Exception(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'));
                }

                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $dataSource->commit($this->InfoPage);
                //$this->redirect(array('action' => 'index'));
            } catch (Exception $exc) {
                $dataSource->rollback($this->InfoPage);
                $this->Session->setFlash($exc->getMessage(), 'flash/error');
                throw $exc;
            }
        } else {
            $this->InfoPage->locale = Configure::read('Config.languages');
            $this->request->data = $this->InfoPage->read(null, $id);
        }

        $categories = $this->InfoPage->InfoCategory->find('list', array(
            'conditions' => array(
                'InfoCategory.selection_id' => $this->selection_id
            )
        ));

        $this->set(compact('categories'));
    }

    /**
     * Akcja usuwająca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null, $all = null) {
        $this->FebI18n->delete($id, $all);

        $this->InfoPage->id = $id;

        $InfoPage = $this->InfoPage->read(array('tags'));

        $this->InfoPage->InfoTag->removeTags($InfoPage['InfoPage']['tags'], $this->selection_id);

        $this->redirect(array('action' => 'index'), null, true);
    }

}
