<?php
App::uses('AppController', 'Controller');
/**
 * PermissionGroups Controller
 *
 * @property PermissionGroup $PermissionGroup
 */
class PermissionGroupsController extends AppController {

    
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
	public function admin_index() {
        //Dla końcowego użytkownika
        $this->helpers[] = 'FebTime';
		$this->PermissionGroup->recursive = 0;
		$this->set('permissionGroups', $this->paginate());
	}

    public function admin_get_permissions() {
        $this->layout = 'ajax';
        $this->PermissionGroup->Permission->recursive = -1;
        $params['conditions']['Permission.permission_group_id'] = $this->request->data['PermissionGroup']['id'];
        $permissions = $this->PermissionGroup->Permission->find('all', $params);
        $this->set(compact('permissions'));
    }
    
    /**
    * Akcja dodająca obiekt
    *
    * @return void
    */
	public function admin_add($permission_category_id = null) {
        $this->layout = 'ajax';
		$this->PermissionGroup->PermissionCategory->id = $permission_category_id;
		if (!$this->PermissionGroup->PermissionCategory->exists()) {
			throw new NotFoundException(__d('cms', 'Brak kategorii.'));
		}
        //Dla developera
		if ($this->request->is('post')) {
			$this->PermissionGroup->create();
			if ($this->PermissionGroup->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('controller' => 'permission_groups', 'action' => 'summary'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
		}

		$permissionCategories = $this->PermissionGroup->PermissionCategory->find('list');
		$this->set(compact('permissionCategories', 'permission_category_id'));
        $this->render('/Elements/PermissionGroups/addForm');
	}

    /**
    * Akcja edytująca obiekt
    *
    * @param string $id
    * @return void
    */
	public function admin_edit($id = null) {
        $this->layout = 'ajax';
        //Dla developera
		$this->PermissionGroup->id = $id;
		if (!$this->PermissionGroup->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PermissionGroup->save($this->request->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('controller' => 'permission_groups', 'action' => 'summary'));
			} else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.', 'flash/error'));
			}
		} else {
			$this->request->data = $this->PermissionGroup->read(null, $id);
		}
		$permissionCategories = $this->PermissionGroup->PermissionCategory->find('list');
		$this->set(compact('permissionCategories'));
        $this->render('/Elements/PermissionGroups/editForm');
	}

    /**
    * Akcja usuwająca obiekt
    *
    * @param string $id
    * @return void
    */
	public function admin_delete($id = null) {
        //Dla developera
        $this->layout = 'ajax';
//		if (!$this->request->is('ajax')) {
//			throw new MethodNotAllowedException();
//		}
		$this->PermissionGroup->id = $id;
		if (!$this->PermissionGroup->exists()) {
			throw new NotFoundException(__d('cms', 'Strona nie istnieje.'));
		}
		if ($this->PermissionGroup->delete()) {

		}
		$this->render(false);
	}
    
    /**
    * Główny panel kontrolny Developera
    *
    * @param string $id
    * @return void
    */
	public function admin_summary($id = null) {
        //Dla developera
        $this->PermissionGroup->PermissionCategory->recursive = 1;
        $permissionCategories = $this->PermissionGroup->PermissionCategory->find('all');
               
        $this->set(compact('permissionCategories'));
        
	}   
    
    /**
     * Akcja aktualizuje wszystkie uprawnienia dla grup obecnie już przydzielonych 
     */
    public function admin_fix() {
        
        //Tworzę tranzakcję
        $dataSource = $this->PermissionGroup->Permission->RequestersPermission->getDataSource();
        $dataSource->begin($this->PermissionGroup->Permission->RequestersPermission);
        
        //Wyciągam wszystkie grupy w raz z ich uprawnieniami
        $params['fields'] = array('Permission.id', 'Permission.permission_group_id');
        $permissionGroups = $this->PermissionGroup->Permission->find('list', $params);

//        //Czyszczę całą tabelę
        if (!$this->PermissionGroup->Permission->RequestersPermission->deleteAll(array('1' => '1'), false)) {
            $dataSource->rollback($this->PermissionGroup->Permission->RequestersPermission);
            throw new ErrorException('Błąd podczas czyszczenia tabeli modelu RequestersPermission');
        }
            
        $this->loadModel('User.User');

        $this->User->recursive = -1;
        $allUsers = $this->User->find('all');
                
        foreach($allUsers as $user) {
            $toSave = array();
            if (!empty($user['PermissionGroup']['PermissionGroup'])) {
                $toSave['RequestersPermission']['model'] = 'User';
                $toSave['RequestersPermission']['row_id'] = $user['User']['id'];
                foreach ($permissionGroups as $permissionId => $permissionGroupId) {
                    if (in_array($permissionGroupId, $user['PermissionGroup']['PermissionGroup'])) {
                        $toSave['RequestersPermission']['permission_id'] = $permissionId;
                        $this->PermissionGroup->Permission->RequestersPermission->create();
                        if (!$this->PermissionGroup->Permission->RequestersPermission->save($toSave)) {
                            $dataSource->rollback($this->PermissionGroup->Permission->RequestersPermission);
                            throw new ErrorException(__d('cms', 'Krytyczny błąd podczas zapisywania uprawnień'));
                        }
                    }
                }
            }
        }
        
        $this->loadModel('User.Group');
        $this->Group->recursive = -1;
        $allGroup = $this->Group->find('all');
        
        foreach($allGroup as $group) {
            $toSave = array();
            if (!empty($group['PermissionGroup']['PermissionGroup'])) {
                $toSave['RequestersPermission']['model'] = 'Group';
                $toSave['RequestersPermission']['row_id'] = $group['Group']['id'];
                foreach ($permissionGroups as $permissionId => $permissionGroupId) {
                    if (in_array($permissionGroupId, $group['PermissionGroup']['PermissionGroup'])) {
                        $toSave['RequestersPermission']['permission_id'] = $permissionId;;
                        $this->PermissionGroup->Permission->RequestersPermission->create();
                        if (!$this->PermissionGroup->Permission->RequestersPermission->save($toSave)) {
                            $dataSource->rollback($this->PermissionGroup->Permission->RequestersPermission);
                            throw new ErrorException(__d('cms', 'Krytyczny błąd podczas zapisywania uprawnień'));
                        }
                    }
                }
            }
        }
        
        //Commituję tranzakcję
        $dataSource->commit($this->PermissionGroup->Permission->RequestersPermission);
        if (empty($this->request->params['requested'])) {
            $this->Session->setFlash(__d('cms', 'Tabela uprawnień została pomyślnie przeładowana'), 'flash/success');
            $this->redirect('summary');
        }
        $this->autoRender = false;;
        
    }
    
    /**
     * Akcja exportująca tabelę kategorii uprawnień, grup uprawnień, grup użytkowników wraz z przywiązanymi do nich uprawnieniami
     */
    public function admin_export() {
        
        
        $this->Session->setFlash(__d('cms', 'Export został wykonany poprawnie'));
        $this->redirect('summary');
        $this->render(false);
    }
    
}
