<div class="helps form">
    <?php echo $this->Form->create('Help', array('url' => array('admin' => 'admin', 'plugin' => 'help', 'controller' => 'helps', 'action' => 'edit'))); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Admin Edit Help'); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('url');
        echo $this->Form->input('title');
        ?>
    </fieldset>
    <fieldset>
        <legend><?php echo __d('cms', 'Treść'); ?></legend>
        <?php
            echo $this->FebTinyMce->input('content', array('label' => false));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>

        <li><?php echo $this->Form->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('Help.id')), null, __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('Help.id'))); ?></li>
        <li><?php echo $this->Html->link(__d('cms', 'List Helps'), array('action' => 'index')); ?></li>
    </ul>
</div>
