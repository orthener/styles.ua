<?php
class Permission extends AppModel {
	var $name = 'Permission';
	var $displayField = 'name';
    
    var $useTable = 'permissions';
    
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User.User',
			'joinTable' => 'requesters_permissions',
			'with' => 'RequestersPermission',
			'foreignKey' => 'permission_id',
			'associationForeignKey' => 'row_id',
			'unique' => true,
			'conditions' => array('RequestersPermission.model' => 'User'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Group' => array(
			'className' => 'User.Group',
			'joinTable' => 'requesters_permissions',
			'with' => 'RequestersPermission',
			'foreignKey' => 'permission_id',
			'associationForeignKey' => 'row_id',
			'unique' => true,
			'conditions' => array('RequestersPermission.model' => 'Group'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
    
            
    public  $belongsTo  = array(
        'PermissionGroup' => array(
            'className'     => 'User.PermissionGroup',
            'foreignKey'    => 'permission_group_id',
            'conditions'    => '',
            'fields'        => ''
        )
    );  
    
    function getLastModified(){
        list(list($modified)) = $this->query("SELECT MAX(modified) AS last_modified FROM requesters_permissions;");
        return $modified['last_modified'];
    }

    function getCountPermissions(){
        list(list($counter)) = $this->query("SELECT COUNT(id) AS counter FROM requesters_permissions;");
        return $counter['counter'];
    }

    /**
     * createIfNotExists
     * 
     * Tries to find permission by name. If permission not exists, it is created
     * 
     * @return array inserted, or found Permission data
     * @param $name string Permission.name
     * 
     */
    function createIfNotExists($name){
        $recursive = $this->recursive;
        $this->recursive = -1;
        $permission = $this->findByName($name);
        if(empty($permission)){
            $this->create(array('Permission' => array(
                'name' => $name
            )));
            if(!$this->save()){
                $permission = false;
            } else {
                $permission = $this->findByName($name);
            }
        }
        $this->recursive = $recursive;
        return $permission;
    }
    
    
    function getPermissionTree() {
        $permissionTree = array();
        
        $this->recursive = -1;
        $grupedPermission = $this->find('list', array('conditions' => array('Permission.permission_group_id <>' => null)));
        
        
        $this->ignoredMethods = am($this->ignoredMethods, get_class_methods('AppController'));

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
        
        
        foreach ($controllersTree AS $plugin => $controllerList) {
            foreach ($controllerList AS $controllerName) {
                if (in_array($controllerName, $this->ignoredMethods)) {
                    continue;
                }
                $prefix = empty($plugin) ? '' : $plugin . '.';
                App::uses($controllerName, $prefix . 'Controller');
                $actionsList = get_class_methods($controllerName);
   
                if (!is_array($actionsList)) {
                    continue;
                }
                foreach ($actionsList AS &$actionName) {
                    if (in_array($actionName, $this->ignoredMethods) or substr_compare($actionName, '_', 0, 1) === 0) {
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
        
        foreach ($controllers AS $plugin => &$routes) {
            $plugin = empty($plugin) ? '' : $plugin; 
            foreach ($routes AS $route => &$controllersNames) {
                $route = empty($route) ? '' : $route;
                foreach ($controllersNames AS $controllerName => &$controllerActions) {
                    foreach ($controllerActions AS &$action) {
                        $actionName = $plugin . ':' . $route . ':' . $controllerName . ':' . $action;
                        $actionOwnName = $plugin . ':' . $route . ':' . $controllerName . ':' . $action . ':own';     
                                                
                        $permissionTree[$plugin][$route][$controllerName][$action]['name'] = $action; 
                        $permissionTree[$plugin][$route][$controllerName][$action]['permissionName']['name'] = $actionName; 
                        $permissionTree[$plugin][$route][$controllerName][$action]['permissionNameOwn']['name'] = $actionOwnName; 
                        

                        $permissionTree[$plugin][$route][$controllerName][$action]['permissionName']['grouped'] = 0;
                        if (in_array($actionName, $grupedPermission)) {
                            $permissionTree[$plugin][$route][$controllerName][$action]['permissionName']['grouped'] = 1;
                        } 
                        $permissionTree[$plugin][$route][$controllerName][$action]['permissionNameOwn']['grouped'] = 0;
                        if (in_array($actionOwnName, $grupedPermission)) {
                            $permissionTree[$plugin][$route][$controllerName][$action]['permissionNameOwn']['grouped'] = 1;
                        } 
                        
                    }
                }
            }
        }
        return $permissionTree;
    }

}
?>