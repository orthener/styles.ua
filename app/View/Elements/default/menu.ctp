<?php

if (isset($data)) {
//$groups = array('investors', 'residents', 'tourists');
    $group = '';
    $echo = '';
    if ($this->Session->check('group')) {
        $group = $this->Session->read('group');
    }
?>
    <?php

    foreach ($data as $key => $menu) {

        $menu['Link']['options']['class'] = ($this->Html->url($_SERVER['REQUEST_URI'], true) == $this->Html->url($menu['Link']['url'], true)) ? 'active' : '';

        $list = $this->Html->link($menu['Link']['title'], $menu['Link']['url'], $menu['Link']['options']);

        $class = empty($menu['children']) ? '' : 'class="more"';

        $echo .= '<li ' . $class . '>' . $list;
        $echo .=!empty($menu['children']) ? $this->element('default/menu', array('data' => $menu['children'])) : '';
        $echo .= '</li>';
    }
    //debug($echo, true);
    if (!empty($echo)) {
        echo '<ul>
        ' . $echo . '
        </ul>';
    }
}
    ?>
