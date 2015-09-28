<div class="newsletters form">
    <?php echo $this->Form->create('Newsletter'); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Admin Edit Newsletter'); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('email');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('Newsletter.id')), null, __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('Newsletter.id'))); ?></li>
        <li><?php echo $this->Html->link(__d('cms', 'List Newsletters'), array('action' => 'index')); ?></li>
    </ul>
</div>