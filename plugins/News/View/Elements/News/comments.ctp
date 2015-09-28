<?php echo $this->Form->create('Comment', array('id' => 'comment', 'url' => array('plugin' => 'comment', 'controller' => 'comments', 'action' => 'add'))); ?>

<fieldset style="color:black;">
    <legend><?php echo __d('front', 'Dodaj komentarz'); ?></legend>
    <?php
    $user = $this->Session->read('Auth.User');
    echo $this->Form->input('Comment.name', array('label' => __d('front', 'Komentarz jako:'), 'value' => $user['name'], 'disabled' => 'disabled'));
    echo $this->Form->hidden('Comment.name', array('value' => $user['name'])); 
    echo $this->Form->hidden('Comment.user_id', array('value' => $user['id']));
    echo $this->Form->hidden('Comment.parent_id', array('value' => ''));
    echo '<br />';
    ?>
    <div class="reply_to_comment" style="display:none;">
        <?php echo __d('front', 'Odpowiadasz na'); ?> <a href="#" class="comment_reply_id"><?php echo __d('front', 'ten komentarz'); ?></a>. <br/> <a href="#" class="cancel_reply"><?php echo __d('front', 'Anuluj odpowiadanie'); ?></a>.
    </div>    
    <?php 
    echo $this->Form->hidden('Comment.news_id', array('value' => $news['News']['id']));
    echo $this->Form->hidden('Comment.slug', array('value' => $news['News']['slug']));
    echo $this->Form->input('Comment.desc', array('label' => __d('front', 'Treść')));
//    echo $this->Form->label('', 'Przepisz dwa słowa z obrazka', array('style' => 'width: 400px'));
//    echo $this->CaptchaTool->show('Comment');
    ?>
</fieldset>
<?php //echo $this->Form->end('OPUBLIKUJ', array('class' => 'sendOrSearch')); ?>
<?php echo $this->Form->button(__d('front', 'OPUBLIKUJ'), array('type' => 'submit', 'class' => 'sendOrSearch')); ?>
<?php echo $this->Form->end(); ?>