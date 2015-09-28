<?php $this->set('title_for_layout', __d('cms', 'Przypomnienie Hasła')); ?>

<div id="newPass" class="documentContent">
<?php echo $this->Form->create('User', array('url' => Router::url(array('controller' => 'users', 'action' => 'new_pass', $id, $hash)))); ?>
<?php
    echo $this->Form->input('newpassword', array('label' =>  __d('cms', 'Hasło'), 'type' => 'password', 'value' => ''));
    echo $this->Form->input('confirmpassword', array('label' =>  __d('cms', 'Powtórz hasło'), 'type' => 'password', 'value' => ''));
?>
<?php echo $this->Form->end(__d('cms', 'Zmień', true)); ?>
</div>