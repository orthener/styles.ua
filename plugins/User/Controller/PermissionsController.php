<?php

class PermissionsController extends AppController {

    /**
     * Controller name
     * 
     * @var $name string
     * @access public
     */
    var $name = 'Permissions';

    /**
     * per Controller layout
     * 
     * @var $layout string
     * @access public
     */
    var $layout = 'admin';

    /**
     * models loaded for this controller
     * 
     * @var $uses array
     * @access public
     */
    var $uses = array('User.RequestersPermission', 'User.Permission');

    /**
     * ignored_controllers
     * 
     * Those controllers should be ignored in permissions configuration
     * 
     * @var $_ignored_controllers array
     * @access protected
     */
    protected $_ignored_controllers = array('App');

    /**
     * ignored_methods
     * 
     * Those methods should be ignored in permissions configuration
     * 
     * @var $_ignored_methods array
     * @access protected
     */
    protected $_ignored_methods = array();

    /**
     * _get_permissions_list_from_app
     * 
     * Returns all "global" permissions based on controllers names, and action methods inside controllers
     * 
     * @access public 
     */
    function _get_permissions_list_from_app() {

        $this->_ignored_methods = am($this->_ignored_methods, get_class_methods('AppController'));

        //get plugin list
        $pluginsList = App::objects('plugin');

        //get routing prefixes
        $prefixes = Configure::read('Routing.prefixes');

        //declare all controllers container
        $controllersTree = array();

        //get controller list from app
        $controllersTree[] = App::objects('Controller'); //, NULL, false
        //iterate over all plugins
        foreach ($pluginsList AS $plugin) {
            //get controller list from plugin
            $controllersTree[$plugin] = App::objects($plugin . '.Controller'); //, $plugin_path.$plugin.DS.'controllers', false);
        }

        $controllers = array();

        foreach ($controllersTree AS $plugin => $controllerList) {
            foreach ($controllerList AS $controllerName) {
                if (in_array($controllerName, $this->_ignored_controllers)) {
                    continue;
                }
                $prefix = empty($plugin) ? '' : $plugin . '.';
                App::uses($controllerName, $prefix . 'Controller');
                $actionsList = get_class_methods($controllerName);
                if (!is_array($actionsList)) {
                    continue;
                }
                foreach ($actionsList AS &$actionName) {
                    if (in_array($actionName, $this->_ignored_methods) or substr_compare($actionName, '_', 0, 1) === 0) {
                        continue;
                    }

                    $action = explode('_', $actionName);

                    $controller_name = Inflector::underscore(substr($controllerName, 0, -10));

                    if (in_array($action[0], $prefixes)) {
                        $prefix = $action[0];
                        unset($action[0]);
                        $actionName = implode('_', $action);
                        $controllers[$plugin][$prefix][$controller_name][] = strtolower($actionName);
                    } else {
                        $controllers[$plugin][0][$controller_name][] = strtolower($actionName);
                    }
                }
            }
        }

        $permissionsNames = array('*');

        foreach ($controllers AS $plugin => $routes) {
            $plugin = empty($plugin) ? '' : $plugin;
            $permissionsNames[] = $plugin . ':*';
            foreach ($routes AS $route => $controllersNames) {
                $route = empty($route) ? '' : $route;
                $permissionsNames[] = $plugin . ':' . $route . ':*';
                foreach ($controllersNames AS $controllerName => $controllerActions) {
                    $permissionsNames[] = $plugin . ':' . $route . ':' . $controllerName . ':*';
                    foreach ($controllerActions AS &$action) {
                        $permissionsNames[] = $plugin . ':' . $route . ':' . $controllerName . ':' . $action;
                        $permissionsNames[] = $plugin . ':' . $route . ':' . $controllerName . ':' . $action . ':own';
                    }
                }
            }
        }

        return $permissionsNames;
    }

    /**
     * admin_groups
     * 
     * Returns all "global" permissions based on controllers names, and action methods inside controllers
     * 
     * @access public 
     */
    function admin_groups() {
        if (empty($this->RequestersPermission->belongsTo)) {
            $this->RequestersPermission->bindModel(array(
                'belongsTo' => array('Permission')
                    ), false);
        }

        set_time_limit(300);
        /////////
        //TODO: 1. Delete unrelated permissions
        /////////
        /////////
        //2. Get permissions list "from app"
        //and use names AS keys
        /////////
        $permissionsNames = $this->_get_permissions_list_from_app();
        $permissionsNames = array_combine($permissionsNames, array_fill(0, count($permissionsNames), false));

        /////////
        //3. Prepare $permissionsNames data for view
        /////////
        $regexp = '^[a-z0-9_]*:([*]|[a-z0-9_]*:([*]|[a-z0-9_]+:[*]|[a-z0-9_]+:[a-z0-9_]+|[a-z0-9_]+:[a-z0-9_]+:own))$';
        $this->Permission->Behaviors->attach('Containable');
        $permissions = $this->Permission->find('all', array(
            'conditions' => array('or' => array('Permission.name REGEXP "' . $regexp . '"', 'Permission.name' => '*')),
            'contain' => array('Group'),
                ));

        foreach ($permissions AS &$permission) {
            if (isSet($permissionsNames[$permission['Permission']['name']])) {
                $groupsByIds = array();
                foreach ($permission['Group'] AS $group) {
                    $groupsByIds[$group['id']] = $group;
                }
                $permission['Group'] = $groupsByIds;
                $permissionsNames[$permission['Permission']['name']] = $permission;
            }
        }


        foreach ($permissionsNames AS $key => &$permission) {
            if (empty($permission)) {
                $permission = array('Permission' => array('name' => $key), 'Group' => array());
            }
        }

        $this->set('permissionsNames', $permissionsNames);

        /////////
        //4. Prepare $groups data for view
        /////////
        $this->set('groups', $this->Permission->Group->find('list', array('order' => 'Group.order ASC')));

        /////////
        //5. Save permissions if data is sent
        /////////
        if (!empty($this->request->data)) {

            $groups = $this->Permission->Group->find('list', array('fields' => array('id', 'alias')));

            //przesĹ‚ano zserializowane dane - trzeba odtworzyÄ‡
            if (!empty($this->request->data['Serialized']['text'])) {
//                $old_data = unserialize(str_replace(array("\r\n{\r\n", "\r\n}\r\n"), array("{", "}"), $this->request->data['Serialized']['text']));
                $old_data = $this->_xml_to_array($this->request->data['Serialized']['text']);
                $groups2 = array_flip($groups);

                $this->request->data = array('Permission' => array());
                foreach ($old_data['Permission'] AS $key => $value) {
                    $this->request->data['Permission'][$key] = array();
                    foreach ($value AS $sub_key => $checked) {
                        $this->request->data['Permission'][$key][$groups2[$sub_key]] = $checked;
                    }
                }
            }

            foreach ($this->request->data['Permission'] AS $key => &$permission) {
                foreach ($permission AS $sub_key => $value) {
                    if (empty($value)) {
                        //try to delete relation
                        $this->RequestersPermission->deleteAll(array(
                            'Permission.name' => $key,
                            'RequestersPermission.row_id' => $sub_key,
                            'RequestersPermission.model' => 'Group'
                                ), false);
                    } else {
                        //is there Permission row with name == $key?
                        if (($permissionRow = $this->Permission->createIfNotExists($key)) == false) {
                            $this->Session->setFlash('Zapisywanie uprawnienie zostało przerwane, poniĹĽej przedstawiono stan rzeczywisty');
                            $this->redirect($this->here);
                        }

                        $requestersPermission = $this->RequestersPermission->find('count', array('conditions' => array(
                                'RequestersPermission.permission_id' => $permissionRow['Permission']['id'],
                                'RequestersPermission.row_id' => $sub_key,
                                'RequestersPermission.model' => 'Group'
                                )));
                        if (empty($requestersPermission)) {
                            $this->RequestersPermission->create(array('RequestersPermission' => array(
                                    'permission_id' => $permissionRow['Permission']['id'],
                                    'row_id' => $sub_key,
                                    'model' => 'Group'
                                    )));
                            if (!$this->RequestersPermission->save()) {
                                $this->Session->setFlash('Zapisywanie uprawnienie zostało przerwane, poniĹĽej przedstawiono stan rzeczywisty');
                                $this->redirect($this->here);
                            }
                        }
                    }
                }
            }

            $new_data = array('Permission' => array());
            foreach ($this->request->data['Permission'] AS $key => $value) {
                $new_data['Permission'][$key] = array();
                foreach ($value AS $sub_key => $checked) {
                    $new_data['Permission'][$key][$groups[$sub_key]] = $checked;
                }
            }

            $dir = APP . 'Config/permissions/';
//            $i = 1;
            $file_name = $dir . 'groups_permissions.xml';
//             while(file_exists($unique_file_name = $dir.'groups_permissions'.$i.'.txt')){
//                 $i++;
//             };
//             $filecontent = "\n-- Utworzono: ".date('Y-m-d H:i:s')." \r\n";
//             $filecontent .= "-- Na stacji administrowanej przez: {$_SERVER['SERVER_ADMIN']}\r\n\r\n";
//             $filecontent .=   "=======Dane do przetworzenia:=======\r\n";
            $filecontent = $this->_array_to_xml($new_data);
//            $filecontent .= "\r\n================KONIEC==============\r\n";
//debug($new_data);
//            file_put_contents($unique_file_name, $filecontent);
            file_put_contents($file_name, $filecontent);

            $this->Session->setFlash('Uprawnienia grup zostały zapisane');
            $this->redirect($this->here);
        }
    }

    function _array_to_xml(&$data) {
        $this->xmlWriter = new XMLWriter();
        $this->xmlWriter->openMemory();
        $this->xmlWriter->setIndent(true);
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
        $this->_array_to_xml_internal($data);

        $this->xmlWriter->endDocument();
        return $this->xmlWriter->outputMemory(true);
    }

    function _array_to_xml_internal(&$data) {
        if (is_array($data)) {
            foreach ($data AS $key => &$value) {
                $key = str_replace(array('*', ':'), array('_ASTERISK_', '_COLON_'), $key);


                $this->xmlWriter->startElement($key);
                $this->_array_to_xml_internal($value);
                $this->xmlWriter->endElement();
            }
        } else {
            $this->xmlWriter->text($data);
        }
    }

    function _xml_to_array(&$data) {
        $this->xmlReader = new XMLReader();
        $this->xmlReader->xml($data);

        $this->arrayFromXML = array();

        $this->_xml_to_array_internal($this->arrayFromXML, -1);

        $this->xmlReader->close();

        return $this->arrayFromXML;
    }

    function _xml_to_array_internal(&$arrayFromXML, $depth) {
        while ($this->xmlReader->read()) {
            if ($this->xmlReader->nodeType == XMLReader::SIGNIFICANT_WHITESPACE || $this->xmlReader->nodeType == XMLReader::WHITESPACE) {
                continue;
            }

            if ($this->xmlReader->nodeType == XMLReader::ELEMENT) {
                $name = str_replace(array('_ASTERISK_', '_COLON_'), array('*', ':'), $this->xmlReader->name);
                $arrayFromXML[$name] = false;
                $this->_xml_to_array_internal($arrayFromXML[$name], $this->xmlReader->depth);
            } elseif ($this->xmlReader->nodeType == XMLReader::TEXT) {
                $arrayFromXML = $this->xmlReader->value;
                return;
            } elseif ($this->xmlReader->nodeType == XMLReader::END_ELEMENT) {
                if ($this->xmlReader->depth == $depth) {
                    return;
                }
            }
        }
    }

    /**
     * admin_delete_rp
     * 
     * Delete requester relation to permission
     * 
     * @param string $model Model name which is pointed by $row_id
     * @param string $row_id record id from Model
     * @param string $permission_id record id from Permission
     * 
     * @access public 
     */
    function admin_delete_rp($model, $row_id, $permission_id) {
        if (!isSet($model, $row_id, $permission_id)) {
            $this->Session->setFlash(__d('cms', 'Nieprawidłowe wywołanie'));
            $this->redirect($this->referer());
        }
        if ($this->RequestersPermission->deleteAll(array(
                    'RequestersPermission.permission_id' => $permission_id,
                    'RequestersPermission.row_id' => $row_id,
                    'RequestersPermission.model' => $model
                ))) {
            $this->Session->setFlash(__d('cms', 'Uprawnienie zostało usunięte'));
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(__d('cms', 'Uprawnienie nie zostało usunięte'));
        $this->redirect($this->referer());
    }

    /**
     * admin_add_rp
     * 
     * Create requester relation to permission (and possibly permission record itself)
     * 
     * @param string $model Model name which is pointed by $row_id
     * @param string $row_id record id from Model
     * 
     * @access public 
     */
    function admin_add_rp($model = null, $row_id = null) {
        if ((empty($model) OR empty($row_id)) AND empty($this->request->data)) {
            $this->Session->setFlash(__d('cms', 'NieprawidĹ‚owe wywoĹ‚anie'));
            $this->redirect($this->referer());
        }
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['Permission']['name'])) {
                //save permission record before saving relation
                $permissionRow = $this->Permission->createIfNotExists($this->request->data['Permission']['name']);
                if (!empty($permissionRow)) {
                    $this->request->data['RequestersPermission']['permission_id'] = $permissionRow['Permission']['id'];
                }
            }

            $this->RequestersPermission->create();
            if ($this->RequestersPermission->save(array('RequestersPermission' => $this->request->data['RequestersPermission']))) {
                $this->Session->setFlash(__d('cms', 'Uprawnienie zostało zapisane'));
                $this->redirect(array(
                    'controller' => Inflector::underscore(Inflector::pluralize($this->request->data['RequestersPermission']['model'])),
                    'action' => 'view',
                    $this->request->data['RequestersPermission']['row_id']
                ));
            } else {
                $this->Session->setFlash(__d('cms', 'Zapisywanie nie powiodlo się'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data['RequestersPermission']['model'] = $model;
            $this->request->data['RequestersPermission']['row_id'] = $row_id;
        }
        $record = $this->Permission->{$this->request->data['RequestersPermission']['model']}->find('first', array(
            'conditions' => array($this->request->data['RequestersPermission']['model'] . '.id' => $this->request->data['RequestersPermission']['row_id']),
            'fields' => array($this->request->data['RequestersPermission']['model'] . '.*')
                ));

        $this->set('record', $record);
        $this->set('permissions', $this->Permission->find('list'));
    }

    function admin_view() {
        $this->layout = 'ajax';
        $this->Permission->recursive = 1;
        $permission = $this->Permission->findByName($this->request->data['Permission']['name']);
        $permissionCategories = $this->Permission->PermissionGroup->PermissionCategory->find('list');
        $this->set(compact('permission', 'permissionCategories'));
    }

    function admin_add() {
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
            if (empty($this->request->data['Permission']['permission_group_id'])) {
                throw new ErrorException(__d('cms', "Nie przekazany parametr grupy uprawnienia"));
            }
            if ($permission = $this->Permission->createIfNotExists($this->request->data['Permission']['name'])) {
                $permission['Permission']['permission_group_id'] = $this->request->data['Permission']['permission_group_id'];
                if ($this->Permission->save($permission)) {
                    $this->set(compact('permission'));
                }
            } else {
                throw new ErrorException(__d('cms', "BĹ‚Ä…d podczas zapisu uprawnienia"));
            }
        }
    }


    function admin_disgroup($id = null) {
        $this->laytout = 'ajax';
		$this->Permission->id = $id;
		if (!$this->Permission->exists()) {
			throw new NotFoundException(__d('cms', 'Nie ma takiego uprawnienia.'));
		}
        $toSave['Permission']['id'] = $id;
        $toSave['Permission']['permission_group_id'] = null;
        $this->Permission->save($toSave);
        $this->render(false);
    }

    
    function admin_generate_tree() {
        $permissionTree = $this->Permission->getPermissionTree();
        $this->set(compact('permissionTree'));
    }
            
    
}

?>