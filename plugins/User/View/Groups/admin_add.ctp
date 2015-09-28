<div class="groups form">
    <?php echo $this->Form->create('Group'); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Utwórz %s', 'grupę'); ?></legend>
        <?php
        echo $this->Form->input('name', array('label' => __d('cms', 'Nazwa')));
        echo $this->Form->input('alias');
        ?>
        <?php echo $this->Form->input('PermissionGroup.PermissionGroup', array('label' => false, 'multiple' => 'checkbox', 'div' => array('class' => 'input select multiple'))); ?>
    </fieldset>
    <?php echo $this->Form->end(__d('cms', 'Zapisz')); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'Lista %s', 'grup'), array('action' => 'index')); ?> </li>
    </ul>
</div>
