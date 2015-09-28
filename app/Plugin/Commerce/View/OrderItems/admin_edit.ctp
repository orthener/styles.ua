<div class="orderItems form">
    <?php echo $this->Form->create('OrderItem'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('OrderItems/fields', array('desc' =>  __d('cms', 'Admin Edit Order Item'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('OrderItem.id')), array('outter'=>'<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('OrderItem.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Order Items'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Orders'), array('controller' => 'orders', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Order'), array('controller' => 'orders', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
<?php //echo $this->Permissions->link(__d('cms', 'List Order Item Files'), array('controller' => 'order_item_files', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Order Item File'), array('controller' => 'order_item_files', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
