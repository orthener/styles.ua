<div class="categories form">
    <?php echo $this->Form->create('Menu'); ?>
    <fieldset>
        <legend><?php __d('cms', 'Menu'); ?></legend>	
        <?php
        echo $this->Form->input('id');
        echo $this->element('fields');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'Menu'), array('plugin' => 'menu', 'admin' => true, 'controller' => 'menus', 'action' => 'index')); ?></li>
    </ul>
</div>