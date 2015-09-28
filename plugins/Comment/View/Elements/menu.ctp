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
    foreach ($data as $key => $comment) {
        $class = '';
        $echo .= '<li>';
        $echo .= '<div class="textBlock">
                    <div class="info">';
        $user_id = $comment['Comment']['user_id'];
        $img = $users[$user_id]['User']['avatar'];
        $echo .= $this->Html->image('/files/user/' . $img, array('class' => 'fotoComment', 'width' => '55px', 'height' => '55px'));
        $echo .= '<p>' . $comment['Comment']['name'] . '</p>
                        <p id="comment-'.$comment['Comment']['id'].'">' . $comment['Comment']['created'] . '</p>';
        $echo .= '<a data-id="' . $comment['Comment']['id'] . '" class="addComment">';
        $echo .= $this->Html->image('/img/layouts/default/plus.png') . __d('front', 'Odpowiedz').'
                        </a>
                    </div>
                    <span>' . $comment['Comment']['desc'] . '</span>
                </div>';

        $echo .=!empty($comment['children']) ? $this->element('Comment.menu', array('data' => $comment['children'])) : '';
        $echo .= '</li>';
    };
//    if (!empty($echo)) {
//        echo '<ul>' . $echo . '</ul>';
//    }
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
