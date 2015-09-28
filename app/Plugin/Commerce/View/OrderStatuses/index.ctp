<div class="orderStatuses index">
     
    <?php echo $this->Element('OrderStatuses/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php echo $this->Permissions->link(__d('cms', 'New Order Status'), array('action' => 'add'), array('outter'=>'<li>%s</li>')); ?>
        	</ul>
</div>
