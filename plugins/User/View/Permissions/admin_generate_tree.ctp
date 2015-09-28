<?php 

    $ret = array();
    $i = 0;
    //debug($permissionTree);
    foreach ($permissionTree as $plugin => &$routes) {
        $plugin = empty($plugin) ? 'app' : $plugin; 
        
        $ret[$i]['title'] = $plugin;
        $ret[$i]['isFolder'] = 'true';
        $ret[$i]['children'] = array();
        
        $j = 0;
        foreach ($routes as $route => $controllersNames) {
            $route = empty($route) ? 'default' : $route;
            
            $ret[$i]['children'][$j]['title'] = $route;
            $ret[$i]['children'][$j]['isFolder'] = true;
            
            $k = 0;
            foreach ($controllersNames as $controllerName => $controllerActions) {
                                
                $ret[$i]['children'][$j]['children'][$k]['title'] = $controllerName;
                $ret[$i]['children'][$j]['children'][$k]['isFolder'] = true;
                
                
                $l = 0;
                foreach ($controllerActions as $type => $action) {
                   
                    $ret[$i]['children'][$j]['children'][$k]['children'][$l]['title'] = $action['name'];

                    $ret[$i]['children'][$j]['children'][$k]['children'][$l]['isFolder'] = true;
                    
                    
                    $ret[$i]['children'][$j]['children'][$k]['children'][$l]['children'][0]['title'] = 'all';
                    $ret[$i]['children'][$j]['children'][$k]['children'][$l]['children'][0]['key'] = $action['permissionName']['name'];
                    
                    $ret[$i]['children'][$j]['children'][$k]['children'][$l]['children'][1]['title'] = 'own';
                    $ret[$i]['children'][$j]['children'][$k]['children'][$l]['children'][1]['key'] = $action['permissionNameOwn']['name'];
                    
                    if ($action['permissionName']['grouped']) {
                        $ret[$i]['children'][$j]['children'][$k]['children'][$l]['children'][0]['isGrupped'] = true;
                    }
                    if ($action['permissionNameOwn']['grouped']) {
                        $ret[$i]['children'][$j]['children'][$k]['children'][$l]['children'][1]['isGrupped'] = true;
                    }
  
                    $l++;
                }
 
                $k++;
            }
            
            $j++;
        }
        $i++;
    }
    
    echo json_encode($ret);
?>