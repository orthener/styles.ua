<div class="shipmentMethodConfigs form">
    <?php echo $this->Form->create('ShipmentMethodConfig'); ?>
	<?php echo $this->Element('ShipmentMethodConfigs/fields', array('desc' => __d('cms', 'Add Shipment Method Config'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Shipment Method Configs'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Shipment Methods'), array('controller' => 'shipment_methods', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Shipment Method'), array('controller' => 'shipment_methods', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
