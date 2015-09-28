<div class="shipmentMethods form">
    <?php echo $this->Form->create('ShipmentMethod', array('type' => 'file')); ?>
	<?php echo $this->Element('ShipmentMethods/fields', array('desc' => __d('cms', 'Admin Add Shipment Method'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Shipment Methods'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Shipment Method Configs'), array('controller' => 'shipment_method_configs', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Shipment Method Config'), array('controller' => 'shipment_method_configs', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
