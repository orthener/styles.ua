<?php

App::uses('AppController', 'Controller');

/**
 * Comments Controller
 *
 * @property Comment $Comment
 */
class CommentsController extends AppController {

    public $uses = array('Comment.Comment');
    public $helpers = array('Js', 'Paginator');
    public $layout = 'admin';

    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('admin_accept', 'admin_delete'));
    }
    
    /**
     * Funkcja wyświetla drzewko komentarzy pod danym wpisem na blogu
     * @param $news_id - id wpisu na blogu
     */
    public function index($news_id) {
        
    }

    public function add() {
        debug($this->request->data);
        $this->request->data['Comment']['comment_parent_id'] = $this->request->data['Comment']['parent_id'];
//        $this->request->data['Comment']['parent_id']= '';
//        debug($this->request->data);
//        exit;
        if (!empty($this->request->data)) {
            $this->Comment->create();
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__d('front', 'Komentarz został dodany i oczekuje na moderację'));
                $this->redirect(array('type' => 'blog', 'plugin' => 'news', 'controller' => 'news', 'action' => 'view', $this->request->data['Comment']['slug']));
            }
        }
    }

    function menu($treeMode = 1, $news_id = null) {
        $data = $this->Comment->findTree(array('Comment.active' => 1, 'Comment.news_id' => $news_id));
        $data = $this->links($data);
        $this->loadModel('User.User');
        $users = $this->User->find('all');
        $users = Set::combine($users, '{n}.User.id', '{n}');
        $this->set(compact('data', 'users'));
        $this->render('Comment./Elements/menu');
    }

    function admin_index($activeMode = '') {
        $this->layout = 'admin';

        if ($activeMode == 0) {
            $tree = $this->Comment->findTree(array('Comment.active' => 0));
        } elseif ($activeMode == 1) {
            $tree = $this->Comment->findTree(array('Comment.active' => 1));
        }
        $tree = $this->links($tree);
        $acceptComments = $this->Comment->find('list', array('fields' => array('id', 'active')));
        $commentsDesc = $this->Comment->find('list', array('fields' => array('id', 'desc')));
        $this->set(compact('tree', 'acceptComments', 'commentsDesc', 'activeMode'));
        return $tree;
    }

    function links(&$data = array()) {

        foreach ($data as &$link) {
            $link = $this->link($link);
            if (!empty($link['children'])) {
                $this->links($link['children']);
            }
        }
        return $data;
    }

    function link($link = array()) {
        $link['Link']['title'] = isset($link['Comment']['name']) ? $link['Comment']['name'] : '';
        $link['Link']['url'] = '#';
        $link['Link']['options'] = array();

        if (!empty($link['Comment']['model'])) {
            $link['Comment']['controller'] = Inflector::pluralize(strtolower($link['Comment']['model']));
        }
        $link['Comment']['plugin'] = (isset($link['Comment']['model']) and $link['Comment']['model'] == 'Page') ? 'page' : '';
//        switch ($link['Comment']['option']) {
//            case 0:
//                $link['Link']['options']['default'] = false;
//                break;
//            case 1:
//                $link['Link']['url'] = $link['Comment']['url'];
//                break;
//            case 2:
//                $link['Link']['title'] = $link['Comment']['name'];
//                $link['Link']['url'] = array();
//                $link['Link']['url']['admin'] = false;
//                $link['Link']['url']['plugin'] = $link['Comment']['plugin'];
//                $link['Link']['url']['controller'] = $link['Comment']['controller'];
//                $link['Link']['url']['action'] = 'view';
//                $link['Link']['url'][] = $link[$link['Comment']['model']]['slug'];
//                break;
//            default:
//                $link['Link']['options'] = array('onclick' => 'return false;');
//        }
        return $link;
    }

    function admin_relatedindex($alias = 'Page.Page', $params = null) {

        if (empty($alias)) {
            throw new NotFoundException(__d('cms', 'Model nie istnieje.'));
        }

        $this->loadModel($alias);
        $this->loadModel("Comment.Comment");

        list($plugin, $model) = pluginSplit($alias);

        if ($this->Comment->Behaviors->attached('Translate') && Configure::read('Config.languages')) {
            $language = Configure::read('Config.languages');
            $this->Page->locale = $language;
            $this->Comment->locale = $language;
            $this->Page->bindTranslation(array('name' => 'translateDisplay'));
            $this->Comment->bindTranslation(array('name' => 'translateDisplay'));
        }
        $this->Page->recursive = 1;

        if ($params) {
            if ($params == 'podstrony') {
                $paginateParams['conditions'][$model . '.gallery'] = 0;
            }
            if ($params == 'galerie') {
                $paginateParams['conditions'][$model . '.gallery'] = 1;
            }
            if ($params == 'shop') {
                $paginateParams['conditions'][$model . '.category'] = 0;
            }
            if ($params == 'blog') {
                $paginateParams['conditions'][$model . '.category'] = 2;
            }
            if ($params == 'studio') {
                $paginateParams['conditions'][$model . '.category'] = 1;
            }
        }
        $paginateParams['limit'] = 10;
        $this->paginate = $paginateParams;

        $relatedData = $this->paginate($model);
        $displayField = $this->Comment->displayField;

        $this->set(compact('relatedData', 'model', 'plugin', 'displayField'));
    }

    function admin_reset() {
        $this->Comment->recover('parent');
        $this->Comment->recover('tree');
        $this->Session->setFlash('Zresetowano');
        $this->redirect(array('action' => 'index'), null, true);
    }

    function admin_update() {
        if (empty($this->request->data['dest_id']) or empty($this->request->data['id'])) {
            throw new MethodNotAllowedException('empty dest_id');
        }

        if (empty($this->request->data['mode'])) {
            $this->request->data['mode'] = null;
        }

        $valid = $this->Comment->validateDepth($this->request->data['id'], $this->request->data['dest_id'], $this->request->data['mode']);
        if ($valid === false) {
            $this->Session->setFlash($this->Comment->validate['depth']['message']);
        }

        if ($valid === true && $this->Comment->moveNode($this->request->data['id'], $this->request->data['dest_id'], $this->request->data['mode'])) {
            //success
            $this->Session->setFlash(__d('cms', 'Zmieniono pozycję'));
        }
        //debug($this->referer());
        $this->render(false);
        //$this->redirect($this->referer());
        return false;
    }

    function admin_add($requested = false) {
        //$this->_checkAccess($model);
        if (empty($this->request->data)) {
            if (!$requested) {
                $this->render(false);
            }
            return false;
        }
        $myData = $this->request->data['Comment']['mode'];

        if (empty($this->request->data['Comment']['name'])) {
            $this->Session->setFlash(__d('cms', 'Wprowadź nazwę, aby dodać pozycję.'));
            $this->redirect(array('action' => 'index', $myData));
        }

        $this->Comment->create();

        //$this->request->data['Comment']['selection_id'] = $this->selection_id;

        if ($this->Comment->save($this->request->data)) {
            if (empty($this->request->data['dest_id'])) {
                $this->Session->setFlash(__d('cms', 'Dodano pozycję na koniec drzewa.'));
            } else {
                $id = $this->Comment->getInsertID();
                if (empty($this->request->data['mode'])) {
                    $this->request->data['mode'] = null;
                }
                if ($this->Comment->moveNode($id, $this->request->data['dest_id'], $this->request->data['mode'])) {
                    $this->Session->setFlash(__d('cms', 'Dodano pozycję do drzewa.'));
                } else {
                    $this->Session->setFlash(__d('cms', 'Dodano pozycję na koniec drzewa.'));
                }
            }
            $this->request->data = array();
        } else {
            $this->Session->setFlash(__d('cms', 'Dodanie pozycji nie powiodło się, sprawdź formularz i spróbuj ponownie'));
        }
        $this->redirect(array('action' => 'index', $myData));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__d('cms', 'Nie znaleziono pozycji o podanym ID'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Zapisano pozycję w menu'));
                $this->redirect(array('admin' => true, 'plugin' => 'menu', 'controller' => 'menus', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Zapisywanie pozycji w menu nie powiodło się. Sprawdź formularz i spróbuj ponownie.'));
            }
        }
        $urlOptions = $this->Comment->urlOptions();

        if (empty($this->request->data)) {
            $this->Comment->locale = Configure::read('Config.languages');
            $this->request->data = $this->Comment->read(null, $id);
            if ($this->request->data['Comment']['option'] == 2) {
                $alias = $this->request->data['Comment']['model'];
                $this->request->data['Comment']['model_title'] = $this->request->data['Page']['slug'];
            }
        }

        $this->set(compact('urlOptions'));
        /*
          if (empty($this->request->data)) {
          $this->Comment->Page->set_translate();
          $this->Comment->locale = Configure::read('Config.languages');
          $this->request->data = $this->Comment->read(null, $id);
          if(!empty($this->request->data['Page']['id'])){
          $this->Comment->Page->recursive = 0;
          $page = $this->Comment->Page->findById($this->request->data['Page']['id']);
          $this->request->data['Category']['model_title'] = $page['Page']['name'];
          }
          } */
    }

    function delete($id = null, $all = null, $treeMode = '') {
        //$this->loadModel($model);
        $model = 'Comment';
        $lang = 'pl'; //$this->I18n->l10n->locale;
        if (empty($id)) {
            $this->cakeError('error404');
        }
        if ($all != 0) {
            $this->Comment->delete($id);
        } else {
            $ile1 = $this->Comment->query("SELECT COUNT(*) as `ile` FROM `i18n` WHERE `model` = '{$model}' AND locale = '{$lang}' AND foreign_key = {$id}");
            $ile2 = $this->Comment->query("SELECT COUNT(*) as `ile` FROM `i18n` WHERE `model` = '{$model}' AND foreign_key = {$id}");
            if ($ile1[0][0]['ile'] == $ile2[0][0]['ile']) {
                $this->Comment->delete($id);
            } else {
                $this->Comment->query("DELETE FROM `i18n` WHERE `model` = '{$model}' AND locale = '{$lang}' AND foreign_key = {$id}");
            }
        }
        $this->redirect(array('admin' => 'admin', 'action' => 'index', $treeMode), null, true);
    }

    /**
     * Funkcja ustawia flagę akceptacji w stan 1 jeśli komentarz nadrzędny również został zaakceptowany
     * @param type $comment_id - identyfikator akceptowanego komentarza
     */
    public function admin_accept($comment_id = null) {
        $this->layout = 'admin';
        $this->Comment->id = $comment_id;
        if (!$this->Comment->exists()) {
            $this->Session->setFlash(__d('cms', 'Nie znaleziono pozycji o podanym ID'));
            $this->redirect(array('action' => 'index'));
        }
        $thisComment = $this->Comment->read(null, $comment_id);
//        debug($thisComment);
        if(!empty($thisComment['Comment']['parent_id'])) {
            $parentComment = $this->Comment->read(null, $thisComment['Comment']['parent_id']);
//            debug($parentComment);
            if(!$parentComment['Comment']['active']) {
                $this->Session->setFlash(__d('cms', 'Zaakceptuj najpierw komentarz nadrzędny'));
                $this->redirect(array('action' => 'index'));                
            }
        }
        $this->Comment->id = $comment_id;
        $this->Comment->saveField('active', true);
        $this->redirect(array('action' => 'index'));
    }

    /**
     * 
     * @param type $comment_id - identyfikator akceptowanego
     */
    public function admin_delete($comment_id = null) {
        $this->layout = 'admin';
        $this->Comment->id = $comment_id;
        if (!$this->Comment->exists()) {
            $this->Session->setFlash(__d('cms', 'Nie znaleziono pozycji o podanym ID'));
            $this->redirect(array('action' => 'index'));
        }
        $thisComment = $this->Comment->read(null, $comment_id);
        $this->delete($comment_id);
        //debug($thisComment);
    }

}
