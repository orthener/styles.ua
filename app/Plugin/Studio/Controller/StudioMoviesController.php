<?php

App::uses('AppController', 'Controller');

/**
 * StudioMovies Controller
 *
 * @property StudioMovie $StudioMovie
 */
class StudioMoviesController extends AppController {

    /**
     * Nazwa layoutu
     */
    public $layout = 'admin';

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array('FebForm');

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
        $this->Auth->allow(array('movies_main', 'movies_list'));
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function index() {
        $this->helpers[] = 'FebTime';
        $this->StudioMovie->recursive = 0;
        $this->set('studioMovies', $this->paginate());
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
//        $slug = $this->StudioMovie->isSlug($slug);
//        if (!$slug) {
//            throw new NotFoundException(__('Strona nie istnieje.'));
//        }
//        if (!empty($slug['error'])) {
//            $this->redirect(array($slug['slug']), $slug['error']);
//        }
//        $this->StudioMovie->id = $slug['id'];

        $this->StudioMovie->id = $id;
        if (!$this->StudioMovie->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('studioMovie', $this->StudioMovie->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->StudioMovie->create();
            if ($this->StudioMovie->save($this->request->data)) {
                $this->Session->setFlash(__d('public', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('public', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->StudioMovie->id = $id;
        if (!$this->StudioMovie->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->StudioMovie->save($this->request->data)) {
                $this->Session->setFlash(__d('public', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('public', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        } else {
            $this->request->data = $this->StudioMovie->read(null, $id);
        }
    }

    /**
     * Akcja usuwająca obiekt
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->StudioMovie->id = $id;
        if (!$this->StudioMovie->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->StudioMovie->delete()) {
            $this->Session->setFlash(__d('public', 'Poprawnie usunięto.'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('public', 'Nie można usunąć.'), 'flash/error');
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Akcja wyświetlająca listę obiektów
     * 
     * @return void
     */
    public function admin_index() {
        $this->helpers[] = 'FebTime';
        $this->StudioMovie->recursive = 1;
        $this->StudioMovie->locale = Configure::read('Config.languages');
        $this->StudioMovie->bindTranslation(array($this->StudioMovie->displayField => 'translateDisplay'));
        $this->set('studioMovies', $this->paginate());
    }

    /**
     * Akcja podglądu obiektu
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {

        $this->StudioMovie->id = $id;
        if (!$this->StudioMovie->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        $this->set('studioMovie', $this->StudioMovie->read(null, $id));
    }

    /**
     * Akcja dodająca obiekt
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
//            debug($this->request->data);
//            exit;
            if(empty($this->request->data['StudioMovie']['url']) && empty($this->request->data['StudioMovie']['file']['name'])) {
                $this->request->data['StudioMovie']['is_active'] = 0;
            }
            $this->StudioMovie->create();
            if ($this->StudioMovie->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
//                debug($this->request->data);
                //debug($this->StudioMovie->validationErrors);
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
        $mediaTypes = $this->StudioMovie->mediaTypes;
        $this->set(compact('mediaTypes'));
    }

    /**
     * Akcja edytująca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->layout = 'admin';
        $this->StudioMovie->id = $id;
        if (!$this->StudioMovie->exists()) {
            throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $studioMovie = $this->StudioMovie->read(null, $id);
            $file = $studioMovie['StudioMovie']['file'];
            if(!empty($this->request->data['StudioMovie']['file_delete']) && $this->request->data['StudioMovie']['file_delete'] == 1) {
                //debug($studioMovie);
                //debug($file);
                if(unlink('files/studiomovie/' . $file)) {
                    $this->request->data['StudioMovie']['file'] = "";
                    if(empty($this->request->data['StudioMovie']['url'])) {
                        $this->request->data['StudioMovie']['is_active'] = 0;        
                    } else {
                        $this->request->data['StudioMovie']['media_type'] = 0;
                    }
                }
            }
//            debug($this->request->data);
//            debug($file);
            if(!empty($this->request->data['StudioMovie']['url']) && empty($this->request->data['StudioMovie']['file']['name']) && empty($file)) {
                $this->request->data['StudioMovie']['media_type'] = 0;
            }
            if(empty($this->request->data['StudioMovie']['url']) && empty($this->request->data['StudioMovie']['file']['name']) && empty($file)) {
                $this->request->data['StudioMovie']['is_active'] = 0;
            }
            
            
//            debug($this->request->data);
//            exit;
            if ($this->StudioMovie->save($this->request->data)) {
                
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                //exit;
                $this->redirect(array('action' => 'index'));
            } else {
                //debug($this->StudioMovie->validationErrors);
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        } else {
            $this->StudioMovie->locale = Configure::read('Config.languages');
//            debug($this->StudioMovie->read(null, $id));
            $this->request->data = $this->StudioMovie->read(null, $id);
        }
        $mediaTypes = $this->StudioMovie->mediaTypes;
        $this->set(compact('mediaTypes'));
//            exit;
    }

    /**
     * Akcja usuwająca obiekt
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null, $all = null) {
        $this->FebI18n->delete($id, $all);
        $this->redirect(array('action' => 'index'), null, true);
    }

    /**
     * Akcja do podpowiadaina danych z formularza
     * 
     * @param type $term
     * @throws MethodNotAllowedException 
     */
    function admin_autocomplete($term = null) {
        $this->layout = 'ajax';
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $params = array();
        $params['fields'] = array('name');

        //Dodatkowe dane przekazywane z FebFormHelper-a
        //if (!empty($this->request->data['fields']['field_name'])) {
        //    $params['conditions']['StudioMovie.field_name'] = $_POST['fields']['field_name'];
        //}

        $this->request->data['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
        $this->StudioMovie->recursive = -1;
        $params['conditions']["StudioMovie.name LIKE"] = "%{$this->request->data['fraz']}%";
        $res = $this->StudioMovie->find('all', $params);
        echo json_encode($res);
        $this->render(false);
    }
    /**
     * Funkcja wyświetla główny odtwarzacz multimedialny w centrum strony
     */
    public function movies_main() {
        $this->layout = false;
        $params['conditions']['StudioMovie.is_active'] = 1;
        $params['conditions']['StudioMovie.media_type'] = 1;
        $movie = $this->StudioMovie->find('first', $params);
//        debug($movie);
        $this->set(compact('movie'));
        $this->render();
    }
    /**
     * Funkcja wyświetla listę utworów wraz z odtwarzaczami
     */
    public function movies_list() {
        $this->layout = false;
        $params['conditions']['StudioMovie.is_active'] = 1;
        $params['conditions']['StudioMovie.media_type'] = 1;
        $tmp_movie = $this->StudioMovie->find('first', $params);
        
        unset($params['conditions']['StudioMovie.media_type']);
        $params['conditions']['StudioMovie.id <>'] = $tmp_movie['StudioMovie']['id'];
        $params['limit'] = 2;
        $params['offset'] = 0;
        $params['conditions']['StudioMovie.media_type'] = 0;
        $params['order'] = 'RAND()';
        $moviesYT = $this->StudioMovie->find('all', $params);
        unset($params['order']);
        $params['limit'] = count($moviesYT)== 2 ? 2 : 4-count($moviesYT);
        $params['conditions']['StudioMovie.media_type'] = 1;
        $params['offset'] = 0;
        $musics = $this->StudioMovie->find('all', $params);
        $movies = array_merge($moviesYT, $musics);
        //debug($movies);
        $this->set(compact('movies'));
        //debug($movies);
        $this->render();
    }
    /**
     * Funkcja wyświetla listę utworów wraz z odtwarzaczami
     */
    public function all_movies() {
        $this->layout = false;
//        unset($params['conditions']['StudioMovie.media_type']);
        $params['conditions']['StudioMovie.is_active'] = 1;
        $params['conditions']['StudioMovie.media_type'] = 1;
        $tmp_movie = $this->StudioMovie->find('first', $params);
        
        $params['conditions']['StudioMovie.id <>'] = $tmp_movie['StudioMovie']['id'];
        $params['offset'] = 2;
        $params['limit'] = 24;
        $movies = $this->StudioMovie->find('all', $params);
        //debug($movies);
        $this->set(compact('movies'));
        //debug($movies);
        $this->render();
    }
}
