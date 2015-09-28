<?php 

    $permissionCategories = array();
    foreach($permissionCategoriesAll as $key => $permissionCategory) {
        $permissionCategories[$key]['title'] = $permissionCategory['PermissionCategory']['name'];
        $permissionCategories[$key]['key'] = $permissionCategory['PermissionCategory']['id'];
        $permissionCategories[$key]['isFolder'] = true;
        $permissionCategories[$key]['addHref'] =  $this->Html->url(array('controller' => 'permission_groups', 'action' => 'add', $permissionCategory['PermissionCategory']['id']));

        $permissionCategories[$key]['children'] = array();
        foreach($permissionCategory['PermissionGroup'] as $permissionGroup) {
            $permissionCategories[$key]['children'][] = array(
                'key' => $permissionGroup['id'],
                'title' => $permissionGroup['name'],
                'delHref' => $this->Html->url(array('controller' => 'permission_groups', 'action' => 'delete', $permissionGroup['id'])),
                'editHref' => $this->Html->url(array('controller' => 'permission_groups', 'action' => 'edit', $permissionGroup['id'])),
            );
        }
    }

    echo json_encode($permissionCategories);
?>