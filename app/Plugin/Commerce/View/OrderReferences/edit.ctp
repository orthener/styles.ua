<?php $this->set('title_for_layout', __d('cms', 'Adding').' &bull; '.__d('cms', 'Order References')); ?><h2><?php echo __d('cms', 'Edit Order Reference'); ?></h2>

<div class="orderReferences form">
    <?php echo $this->Form->create('OrderReference'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('OrderReferences/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('OrderReference.id')), array('outter'=>'<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('OrderReference.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Order References'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
