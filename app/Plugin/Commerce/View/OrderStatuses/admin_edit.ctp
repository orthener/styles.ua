<div class="orderStatuses form">
    <?php echo $this->Form->create('OrderStatus'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('OrderStatuses/fields', array('desc' =>  __d('cms', 'Admin Edit Order Status'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('OrderStatus.id')), array('outter'=>'<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('OrderStatus.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Order Statuses'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
