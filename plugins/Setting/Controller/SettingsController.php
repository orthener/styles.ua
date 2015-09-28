<?php

/**
 * Settings Controller
 *
 * PHP version 5
 *
 * @category Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>, Przebudowane i uaktualnione pod CakePHP 2.0+ Sławomir Jach <s.jach@feb.net.pl>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class SettingsController extends AppController {

    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Settings';

    public $layout = 'admin';

    public function admin_dashboard() {
        $this->set('title_for_layout', __d('cms', 'Panel'));
    }

    public function admin_index() {
        $this->set('title_for_layout', __d('cms', 'Ustawienia'));

        $this->Setting->recursive = 0;
        $paginate['limit'] = 100;

        if (isset($this->params['named']['p'])) {
            $paginate['conditions'] = "Setting.key LIKE '" . $this->params['named']['p'] . "%'";
        }
        $this->paginate = $paginate;
        $this->set('settings', $this->paginate());
    }

    public function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__d('cms', 'Strona nie istnieje..'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        $this->set('setting', $this->Setting->read(null, $id));
    }

    public function admin_add() {
        $this->set('title_for_layout', __d('cms', 'Nowe ustawienie'));

        if (!empty($this->data)) {
            $this->Setting->create();
            if ($this->Setting->save($this->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
    }

    public function admin_edit($id = null) {
        $this->set('title_for_layout', __d('cms', 'Edycja ustawień'));

        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__d('cms', 'Strona nie istnieje.'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Setting->save($this->data)) {
                $this->Session->setFlash(__d('cms', 'Poprawnie zapisano.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('cms', 'Wystąpił błąd podczas zapisu, popraw formularz i spróbuj ponownie.'), 'flash/error');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Setting->read(null, $id);
        }
    }

    public function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__d('cms', 'Strona nie istnieje'), 'flash/error');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Setting->delete($id)) {
            $this->Session->setFlash(__d('cms', 'Poprawnie usunięto'));
        } else {
            $this->Session->setFlash(__d('cms', 'Nie można usunąć'), 'flash/error');
        }

        $this->redirect(array('action' => 'index'));
    }

    public function admin_prefix($prefix = null) {
        $this->set('title_for_layout', sprintf(__d('cms', 'Ustawienie: %s'), $prefix));
        $this->helpers[] = 'FebTinyMce';
        
        $settings = $this->Setting->find('all', array(
            'conditions' => array(
                'Setting.key LIKE' => $prefix . '.%',
                'Setting.editable' => 1,
            ),
        ));
        
        if (!empty($this->data)) {
            $this->Setting->set($this->data);
            
            if ($this->Setting->saveAll($this->data['Setting'])) {
                $this->Session->setFlash(__d('cms', "Poprawnie zapisano"));
            } else {
                $this->Session->setFlash(__d('cms', "Wystąpiły błędy podczas zapisu, sprawdź poniższy formularz i spróbuj ponownie", 'flash/error'));
            }
            foreach($settings as $k => &$data) {
                $data['Setting']['value'] = $this->request->data['Setting'][$k]['value'];
            }
        } 

        $this->set(compact('settings'));

        if (count($settings) == 0) {
            $this->Session->setFlash(__d('cms', "Strona nie istnieje"), 'flash/error');
        }

        $this->set("prefix", $prefix);
    }

    function admin_movedown($id = null) {
        $this->Setting->id = $id;
        $this->Setting->moveDown($this->Setting->id, 1);
        $this->redirect($this->referer());
    }
    
    /**
     * Akcja szybkiego importu i exportu ustawień w panelu 
     */
    function admin_import() {
        $this->set('title_for_layout', sprintf(__d('cms', 'Import/export ustawień')));    
        
        $list = $this->Setting->find('list', array(
            'fields' => array(
                'key',
                'value',
            ),
            'order' => array(
                'Setting.key' => 'ASC',
            ),
        ));
        $filePath = APP . 'Config' . DS . 'settings.yml';
        $saveOutput = array();
        
        if ($this->request->is('post')) {
            $settings = Spyc::YAMLLoad($this->request->data['Setting']['import_area']); 
            
            //Logika do zapisu danych na podstawie pliku yml
            foreach($settings as $key => $setting) {
                //Aktualizacja, klucze juz istnieją
                if (isSet($list[$key])) {
                    
                    $this->Setting->updateAll(
                        array('Setting.value' => is_string($setting)?"'{$setting}'":$setting),
                        array('Setting.key' => $key)
                    );
                } else {
                    //Dodaje nowy klucz
                    $toSave = array(
                        'Setting' => array(
                            'key' => $key,
                            'value' => $setting
                        )
                    );
                    $this->Setting->create();
                    $this->Setting->save($toSave);
                    $saveOutput[] = __d('cms', "UWAGA!! Dodano do bazy klucz %s o wartości: %s", $key, $setting);
                }
            }
            
            //Mam komplet danych zapisuje
            $listYaml = Spyc::YAMLDump($settings, 4, 60);
            file_put_contents($filePath, $listYaml);
        } else {
            $settings = file_get_contents($filePath);
        }
        
        $this->set(compact('saveOutput', 'settings'));        
    }

    function admin_moveup($id = null) {
        $this->Setting->id = $id;
        $this->Setting->moveUp($this->Setting->id, 1);
        $this->redirect($this->referer());
    }

}

?>