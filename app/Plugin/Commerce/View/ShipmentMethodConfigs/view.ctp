<div class="shipmentMethodConfigs view">
<h2><?php  echo __('Shipment Method Config');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($shipmentMethodConfig['ShipmentMethodConfig']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shipment Method'); ?></dt>
		<dd>
			<?php echo $this->Html->link($shipmentMethodConfig['ShipmentMethod']['name'], array('controller' => 'shipment_methods', 'action' => 'view', $shipmentMethodConfig['ShipmentMethod']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Weight'); ?></dt>
		<dd>
			<?php echo h($shipmentMethodConfig['ShipmentMethodConfig']['weight']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Price'); ?></dt>
		<dd>
			<?php echo h($shipmentMethodConfig['ShipmentMethodConfig']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Tax Rate'); ?></dt>
		<dd>
			<?php echo h($shipmentMethodConfig['ShipmentMethodConfig']['tax_rate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($shipmentMethodConfig['ShipmentMethodConfig']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($shipmentMethodConfig['ShipmentMethodConfig']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Shipment Method Config'), array('action' => 'edit', $shipmentMethodConfig['ShipmentMethodConfig']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Shipment Method Config'), array('action' => 'delete', $shipmentMethodConfig['ShipmentMethodConfig']['id']), null, __('Are you sure you want to delete # %s?', $shipmentMethodConfig['ShipmentMethodConfig']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Shipment Method Configs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shipment Method Config'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shipment Methods'), array('controller' => 'shipment_methods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shipment Method'), array('controller' => 'shipment_methods', 'action' => 'add')); ?> </li>
	</ul>
</div>
