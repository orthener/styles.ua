<?php echo $this->Form->create('News', array('id' => 'comment', 'url' => $this->Html->url('/' . $this->params->url, true))); ?>

<fieldset style="color:black;">
    <legend><?php echo __d('cms', 'Dodaj komentarz'); ?></legend>
    <?php
    $user = $this->Session->read('Auth.User');
    echo $this->Form->input('Comment.name', array('label' => 'Komentarz jako:', 'value' => $user['name'], 'disabled' => 'disabled'));
    echo $this->Form->hidden('Comment.name', array('value' => $user['name'])); ?> 
    <div class="reply_to_comment" style="display:none;">
        Odpowiadasz na <a href="#" class="comment_reply_id">ten komentarz</a>. <a href="#" class="cancel_reply">Anuluj odpowiadanie</a>.
    </div>
    <?php
    echo $this->Form->hidden('Comment.user_id', array('value' => $user['id']));
    echo '<br />';
    echo $this->Form->hidden('Comment.news_id', array('value' => $news['News']['id']));
    echo $this->Form->input('Comment.desc', array('label' => 'Treść'));
//    echo $this->Form->label('', 'Przepisz dwa słowa z obrazka', array('style' => 'width: 400px'));
//    echo $this->CaptchaTool->show('Comment');
    ?>
</fieldset>
<?php //echo $this->Form->end('OPUBLIKUJ', array('class' => 'sendOrSearch')); ?>
<?php echo $this->Form->button('OPUBLIKUJ', array('type' => 'submit', 'class' => 'sendOrSearch')); ?>
<?php echo $this->Form->end(); ?>