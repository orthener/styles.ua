<div class="orderItemFiles index">
     
    <?php echo $this->Element('OrderItemFiles/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php echo $this->Permissions->link(__d('cms', 'New Order Item File'), array('action' => 'add'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Order Items'), array('controller' => 'order_items', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Order Item'), array('controller' => 'order_items', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
	</ul>
</div>
