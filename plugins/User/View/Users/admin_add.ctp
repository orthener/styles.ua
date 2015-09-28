<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __d('cms', 'Dodaj ', 'użytkownika'); ?></legend>
	<?php
		echo $this->Form->input('active', array('label' => __d('cms', 'Aktywne')));
		echo $this->Form->input('name', array('label' => __d('cms', 'Nazwa')));
		echo $this->Form->input('email');
		echo $this->Form->input('pass', array('label' => __d('cms', 'Hasło'), 'type' => 'password'));
		echo $this->Form->input('Group', array('label' => __d('cms', 'Grupa')));
        echo $this->Form->input('PermissionGroup.PermissionGroup', array('label' => false, 'multiple' => 'checkbox', 'div' => array('class' => 'input select multiple')));
        
	?>
	</fieldset>
<?php echo $this->Form->end(__d('cms', 'Zapisz'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Lista użytkowników'), array('action' => 'index'));?></li>
	</ul>
</div>