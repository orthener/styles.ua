<div class="groups form">
    <?php echo $this->Form->create('Group'); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Edycja %s', ''); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('name', array('label' => __d('cms', 'Nazwa')));
        echo $this->Form->input('alias');
        ?>
    </fieldset>
    <?php echo $this->Form->input('PermissionGroup.PermissionGroup', array('label' => false, 'multiple' => 'checkbox', 'div' => array('class' => 'input select multiple'))); ?>
    <?php echo $this->Form->end(__d('cms', 'Zapisz')); ?>
</div>

<div class="actions">
    <ul>
        <!--<li><?php // echo $this->Html->link(__d('cms', 'Usuń %s', 'grupę'), array('action' => 'delete', $this->Form->value('Group.id')), null, __d('cms', 'Jesteś pewien, że chcesz usunąć grupę "%s"?', $this->Form->value('Group.name'))); ?> </li>-->
        <li><?php echo $this->Html->link(__d('cms', 'Lista %s', ''), array('action' => 'index')); ?> </li>
    </ul>
</div>
