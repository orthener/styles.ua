<?php

/**
 * Permissions control component class
 *
 * Provides permissions control logic
 * 
 * Permissions types:
 *    * - superuser full access  
 *    controller_name:* - per controller full access
 *    controller_name:action_name - per action access
 *    controller_name:action_name:record_id - per action, per record_id access (for ex. pages:edit:25)
 *    model_name:record_id - per record_id access (for ex. page:25 - user has full access to record: edit, delete, etc.)
 *    controller_name:action_name:own - per action, per owner access (for ex. users:edit:own - user can edit his own profile)
 * 
 */
class PermissionsComponent extends Object {
    /**
     * Other components utilized by PermissionsComponent
     *
     * @var array
     * @access public
     */
    //var $components = array('Session', 'Auth');

    /**
     * Loggedin user permissions
     * 
     * Retrived from database or session
     *
     * @var array
     * @access private
     */
    var $_permissions = false;

    /**
     * Possible foreign keys array in Models which "belongs to" User 
     * 
     * @var array
     * @access private
     */
    var $users_ids = array('user_id', 'users_id');

    /**
     * Initializes PermissionsComponent for use in the controller
     *
     * @param object $controller A reference to the instantiating controller object
     * @return void
     * @access public
     */
    function startup() {
        
    }

    function beforeRender() {
        
    }

    function shutdown() {
        
    }

    function beforeRedirect() {
        
    }

    function initialize(&$controller, $settings = array()) {
        
        $this->controller = &$controller;

        $this->_set($settings);

        ClassRegistry::addObject('permissions_component', $this);
    }

    /**
     * isAuthorized
     * 
     * Helper function returns true if the currently authenticated user has permission 
     * to access the controller:action specified by $controllerName:$actionName
     * @return boolean isAuthorized
     * @param $controllerName Object
     * @param $actionName Object
     */
    function isAuthorized($url = null, $record_id = null) {

        if (empty($url)) {
            $url = '/' . $this->controller->params->url;
        }

        if (!is_array($url) AND empty($record_id)) {
            $url = Router::parse($url);
        } elseif (!is_array($url)) {
            $modelClass = $url;
        } else {
            $url = Router::parse(Router::url($url));
        }

        if (empty($modelClass)) {

            if (!empty($url['prefix']) && !empty($url['action']) && strpos($url['action'], $url['prefix'] . '_') === 0) {
                $url['action'] = substr($url['action'], strlen($url['prefix'] . '_'));
            }

            //Set required fields
            $this->_plugin = empty($url['plugin']) ? null : Inflector::camelize($url['plugin']);
            $this->_prefix = empty($url['prefix']) ? null : $url['prefix'];
            $this->_controllerName = empty($url['controller']) ? null : strtolower($url['controller']);
            $this->_actionName = empty($url['action']) ? null : $url['action'];
            $this->_modelClass = null;
            //$this->_record_id = 
            $this->_setRecordId($url);
        } else {
            $this->_plugin = 'null';
            $this->_prefix = null;
            $this->_controllerName = null;
            $this->_actionName = null;
            $this->_modelClass = $modelClass;
            $this->_record_id = $record_id;
        }

//         //Ensure checks are all made lower case
//         $this->_controllerName = strtolower($this->_controllerName);
//         $this->_actionName = strtolower($this->_actionName);

        $this->__read_permissions();
        return $this->__check_permissions();
    }

    /**
     * __read_permissions
     * 
     * Retrive permissions array from database or from cache
     * 
     * @return 
     * @param $controllerName Object
     * @param $actionName Object
     */
    function __read_permissions() {
        $userPermissionGroup = $this->controller->Session->read('Auth.Groups');
        if (isSet($userPermissionGroup['superAdmins'])) {
            $this->_permissions['*'] = 1;
        }
        
        //Check, If permissions could be read from cache and saved to session...
        $from_session = false;
        if ($this->controller->Session->check('Permissions.permissions') AND $this->controller->Session->check('Permissions.time') AND $this->controller->Session->check('Permissions.count')) {
            if ($this->controller->Session->read('Permissions.users_id') != $this->controller->Session->read('Auth.User.id')) {
                //przelogowanie - nie można czytać z sesji
            } else {
                if ($this->controller->Session->read('Permissions.time') > date('Y-m-d H:i:s', strtotime('-10 seconds'))) {
                    $from_session = true;
                } else {

                    if (!isSet($this->controller->User)) {
                        //We need user model
                        $this->controller->loadModel('User.User');
                    }
                    $permissions_time = $this->controller->User->Permission->getLastModified();
                    $permissions_count = $this->controller->User->Permission->getCountPermissions();

                    if ($this->controller->Session->read('Permissions.time') > $permissions_time AND $this->controller->Session->read('Permissions.count') == $permissions_count) {
                        $from_session = true;
                        $this->controller->Session->write('Permissions.time', date('Y-m-d H:i:s', strtotime('-1 second')));
                    }
                }
            }
        }

        if ($from_session) {
            //Permissions have been cached already and are up to date, so retrieve them
            $this->_permissions = $this->controller->Session->read('Permissions.permissions');
        } else {

            //We need user model
            if (!isSet($this->controller->User)) {
                $this->controller->loadModel('User.User');
            }

            //Build permissions array and cache it
            $this->_permissions = array();
            //everyone gets permission to logout
            $this->_permissions['User:users:logout'] = 1;

            $this->controller->Session->write('Permissions.time', date('Y-m-d H:i:s'));
            //Now bring in the current users full record along with groups
            $thisGroups = $this->controller->User->find('first', array('conditions' => array('User.id' => $this->controller->Session->read('Auth.User.id'))));
            
            $this->controller->Session->write('Permissions.count', $this->controller->User->Permission->getCountPermissions());
            $this->controller->Session->write('Permissions.users_id', $this->controller->Session->read('Auth.User.id'));

            if (!empty($thisGroups['Permission'])) {
                foreach ($thisGroups['Permission'] as $thisPermission) {
                    $this->_permissions[$thisPermission['name']] = 1;
                }
            }

            $thisGroups = is_array($thisGroups['Group']) ? $thisGroups['Group'] : array();
            $groupsList = array();
            
            foreach ($thisGroups as $thisGroup) {
                if ($thisGroup['alias'] == 'superAdmins') {
                    $this->_permissions['*'] = 1;
                }
                $groupsList[$thisGroup['alias']] = $thisGroup['name'];
                $thisPermissions = $this->controller->User->Group->find('first', array('conditions' => array('Group.id' => $thisGroup['id'])));
                $thisPermissions = $thisPermissions['Permission'];
                foreach ($thisPermissions as $thisPermission) {
                    $this->_permissions[$thisPermission['name']] = 1;
                }
            }
            $this->controller->Session->write('Auth.Groups', $groupsList);
            //write the permissions array to session
            $this->controller->Session->write('Permissions.permissions', $this->_permissions);
        }
    }

    /**
     * __check_permissions
     * 
     * Check permissions array against controller, action or edited record
     * 
     * @return boolean true if any permission match to requested resource
     */
    function __check_permissions() {
//        debug($this->_permissions); exit;
// 
//        if($this->_modelClass == 'Player'){
//            debug($this->_record_id);
//            debug($this->_permissions); exit;
//        }
        if (isSet($this->_permissions['*'])) {
            return true; //Super Admin Bypass Found
        }

        if (isSet($this->_permissions[$this->_plugin . ':*'])) {
            return true; //Controller permission found
        }

        if (isSet($this->_permissions[$this->_plugin . ':' . $this->_prefix . ':*'])) {
            return true; //Controller permission found
        }

        if (isSet($this->_permissions[$this->_plugin . ':' . $this->_prefix . ':' . $this->_controllerName . ':*'])) {
            return true; //Controller permission found
        }

        if (isSet($this->_permissions[$this->_plugin . ':' . $this->_prefix . ':' . $this->_controllerName . ':' . $this->_actionName])) {
            return true; //Action permission found
        }

        if (!$this->_setRecordId()) {
            return false; //Record Id not found
        }

        if (isSet($this->_permissions[$this->_plugin . ':' . $this->_prefix . ':' . $this->_controllerName . ':' . $this->_actionName . ':' . $this->_record_id])) {
            return true; //Controller:Action:Record permission found
        }

        //flatCheck - not really check - only test if link should be displayed:
        if (empty($this->flatCheck) AND !$this->_loadModel2Controller()) {
            return false; //Model not found
        }

        if (isSet($this->_permissions[$this->_modelClass . ':' . $this->_record_id])) {
            return true; //Model:Record permission found
        }

        if (isSet($this->_permissions[$this->_plugin . ':' . $this->_prefix . ':' . $this->_controllerName . ':' . $this->_actionName . ':own'])) {
            //Controller:action : own record permission
            //Need to check ownership
            //flatCheck - not really check - only test if link should be displayed:
            if (!empty($this->flatCheck) AND !empty($this->_record_id)) {
                return true;
            }

            if ($this->_modelClass == 'User') {
                //User edit User
                if ($this->_record_id == $this->controller->Auth->user('id')) {
                    return true;
                }
            } else {
                //Test if User edit Object releted by "bt User"
                //find foreign key used in Model
                foreach ($this->users_ids AS $user_id) {
                    if ($this->controller->{$this->_modelClass}->isForeignKey($user_id)) {
                        break;
                    }
                    $user_id = null;
                }

                if (!empty($user_id)) {
                    $is_authorized = $this->controller->{$this->_modelClass}->find('count', array('conditions' => array(
                            $this->controller->{$this->_modelClass}->alias . '.' . $this->controller->{$this->_modelClass}->primaryKey => $this->_record_id,
                            $this->controller->{$this->_modelClass}->alias . '.' . $user_id => $this->controller->Auth->user('id')
                            )));

                    if ($is_authorized) {
                        return true;
                    }
                }
            }
        }


        return false;
    }

    /**
     * _loadModel2Controller
     * 
     * Check if controller has loaded Model, and if not, it tries to load Model
     * 
     * @return boolean true if Model is finaly loaded
     */
    function _loadModel2Controller() {

        //Check for object and its id in controller
        if (empty($this->_modelClass) AND !empty($this->controller->modelClass)) {
            $this->_modelClass = $this->controller->modelClass;
        }

        if (empty($this->_modelClass)) {
            return false;
        }

        if (empty($this->controller->{$this->_modelClass})) {
            if (App::import('Model', $this->_modelClass) == false) {
                return false;
            }
            $this->controller->loadModel($this->_modelClass);
        }

        return true;
    }

    /**
     * _setRecordId
     * 
     * Looking for "$record_id" set somewhere in controller
     * 
     * @return boolean true if find record_id 
     */
    function _setRecordId($params = null) {

        if (!empty($this->_record_id)) {
            return true;
        }

        if (empty($params)) {
            $params = $this->controller->params;
        }
        if (!empty($params['record_id'])) {
            $this->_record_id = $params['record_id'];
        } elseif (!empty($params['pass'][0])) {
            $this->_record_id = $params['pass'][0];
        } else {
            //brak ID, generowac błąd, czy domyślnie zabraniać lub zezwalać?
            return false;
        }

        return true;
    }

}

?>