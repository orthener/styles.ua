<?php
App::uses('AppController', 'Controller');
/**
 * Searchers Controller
 *
 * @property Searcher $Searcher
 */
class SearchersController extends AppController {

    /**
     * Nazwa layoutu
     */
    public $layout = 'admin';

    /**
     * Tablica helperów doładowywana do kontrolera
     */
    public $helpers = array('Paginator');

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
	public function admin_index() {
        $this->helpers[] = 'FebTime';
		$this->Searcher->recursive = 0;
		$this->set('searchers', $this->paginate());
	}

    /**
    * Akcja edytująca obiekt
    *
    * @param string $id
    * @return void
    */
	public function admin_edit($id = null) {
		$this->Searcher->id = $id;
		if (!$this->Searcher->exists()) {
			throw new NotFoundException(__d('cms', 'Niepoprawna referencja.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Searcher->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
			}
		} else {
			$this->request->data = $this->Searcher->read(null, $id);
		}
	}

    /**
    * Akcja usuwająca obiekt
    *
    * @param string $id
    * @return void
    */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Searcher->id = $id;
		if (!$this->Searcher->exists()) {
			throw new NotFoundException(__d('cms', 'Niepoprawna referencja'));
		}
		if ($this->Searcher->delete()) {
			$this->Session->setFlash(__d('cms', 'Poprawnie usunięto.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__d('cms', 'Nie można usunąć'));
		$this->redirect(array('action' => 'index'));
	}
    
    /**
    * Akcja do podpowiadaina danych z formularza
    * 
    * @param type $term
    * @throws MethodNotAllowedException 
    */
    function admin_search($model = null) {
        $this->layout = 'ajax';
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $isResult = false;
        if (trim($this->request->data['fraz']) != "") {
            $options['Searcher']['fraz'] = preg_replace('/[ >]+/', '%', $this->request->data['fraz']);
            $models = $this->Searcher->getModels();
            $searchData = array();

            foreach ($models as $model) {
                $this->loadModel($model['model']);
                $searchData[$model['model']]['data'] = $this->{$model['model']}->search($options);   
                $searchData[$model['model']]['plugin'] = $model['plugin'];   
                if (!empty($searchData[$model['model']])) {
                    $isResult = true;
                }
            }
            
            //Ustawiam jako pierwszy domyślny kontroller jeżeli zostało cos w nim znalezione
//            $currentModel = Inflector::classify($this->request->data['currentController']);
            //Zapamiętuje obency stan
//            if (!empty($searchData[$currentModel])) {
//                $tmp = $searchData[$currentModel];
//                unSet($searchData[$currentModel]);
//                $searchData = array_reverse($searchData);
//                $searchData[$currentModel] = $tmp;
//                $searchData = array_reverse($searchData);
//            }
            
        }

        $this->set(compact('searchData', 'isResult'));
    }


}