<?php

if (isset($menus)) {
//$groups = array('investors', 'residents', 'tourists');
    $group = '';
    $echo = '';
    if ($this->Session->check('group')) {
        $group = $this->Session->read('group');
    }
?>
    <?php

    foreach ($menus as $key => $menu) {
//        debug($menu);
        switch ($menu['Menu']['option']):
            case 0:
                $link = '#';
                break;
            case 1:
                $link = $menu['Menu']['url'];
                break;
            case 2:
                $link = array('plugin' => 'page', 'admin' => false, 'controller' => 'pages', 'action' => 'view', $menu['Page']['slug'], 'type'=>$menu['Menu']['siteType']);
//                $link = array('plugin' => 'page', 'admin' => false, 'controller' => 'pages', 'action' => 'view', $menu['Page']['slug']);
//                $link = $this->Html->url($link);
//                $link = '/'.$menu['Menu']['siteType'].$link;
//                debug($link);
                break;
        endswitch;

        $menu['Link']['options']['class'] = ($this->Html->url($_SERVER['REQUEST_URI'], true) == $this->Html->url($link, true)) ? 'active' : '';

        $list = $this->Html->link($menu['Menu']['name'], $link, $menu['Link']['options']);

        $class = (($menu['Menu']['rght'] - $menu['Menu']['lft']) < 2) ? '' : 'class="more"';

        $echo .= '<li ' . $class . '>' . $list;
        $echo .= (($menu['Menu']['rght'] - $menu['Menu']['lft']) > 2) ? $this->element('default/menu_parent', array('menus' => $sub_menus[$menu['Menu']['id']])) : '';
        $echo .= '</li>';
    };
    //debug($echo, true);
    if (!empty($echo)) {
        echo '<ul>
        ' . $echo . '
        </ul>';
    }
}
    ?>
