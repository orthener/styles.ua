<div class="orderItemFiles form">
    <?php echo $this->Form->create('OrderItemFile'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('OrderItemFiles/fields', array('desc' =>  __d('cms', 'Edit Order Item File'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('OrderItemFile.id')), array('outter'=>'<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('OrderItemFile.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Order Item Files'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Order Items'), array('controller' => 'order_items', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Order Item'), array('controller' => 'order_items', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
