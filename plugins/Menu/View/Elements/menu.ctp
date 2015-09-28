<?php

if ($data):
//$groups = array('investors', 'residents', 'tourists');
    $group = '';
    $echo = '';
    $isBlinkInMenu = false;
    if ($this->Session->check('group')) {
        $group = $this->Session->read('group');
    }
?>
    <?php

    foreach ($data as $key => $menu) {
        $menu['Link']['options']['class'] = ($this->Html->url($_SERVER['REQUEST_URI'], true) == $this->Html->url($menu['Link']['url'], true)) ? 'active' : '';

        $list = $this->Html->link($menu['Link']['title'], $menu['Link']['url'], $menu['Link']['options']);

        $class = empty($menu['children']) ? '' : 'more ';
        $class .= ($menu['Menu']['blink']) ? ' blink ' : '';
        if($menu['Menu']['blink']){
            $isBlinkInMenu = true;
        }
        $echo .= '<li class="' . $class . '">' . $list;
        $echo .=!empty($menu['children']) ? $this->element('Menu.menu', array('data' => $menu['children'])) : '';
        $echo .= '</li>';
    };
    //debug($echo, true);
    if (!empty($echo)) {
        echo '<ul>
        ' . $echo . '
        </ul>';
        
        if($isBlinkInMenu){
            echo "<script>
                var p = $('.blink > a');

p.blinker();

p.bind({
    // pause blinking on mouseenter
    mouseenter: function(){
        $(this).data('blinker').pause();
    },
    // resume blinking on mouseleave
    mouseleave: function(){
        $(this).data('blinker').blinkagain();
    }
});
</script>
                ";
        }
    }
endif;
    ?>
