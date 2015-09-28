<div class="shipmentMethodConfigs index">
     
    <?php echo $this->Element('ShipmentMethodConfigs/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php echo $this->Permissions->link(__d('cms', 'New Shipment Method Config'), array('action' => 'add'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Shipment Methods'), array('controller' => 'shipment_methods', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Shipment Method'), array('controller' => 'shipment_methods', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
	</ul>
</div>
