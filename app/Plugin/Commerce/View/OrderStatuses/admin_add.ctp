<div class="orderStatuses form">
    <?php echo $this->Form->create('OrderStatus'); ?>
	<?php echo $this->Element('OrderStatuses/fields', array('desc' => __d('cms', 'Admin Add Order Status'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Order Statuses'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
