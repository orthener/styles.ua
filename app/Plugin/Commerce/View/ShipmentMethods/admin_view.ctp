<div class="shipmentMethods view">
<h2><?php  echo __('Shipment Method');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($shipmentMethod['ShipmentMethod']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($shipmentMethod['ShipmentMethod']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Img'); ?></dt>
		<dd>
			<?php echo h($shipmentMethod['ShipmentMethod']['img']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Shipment Price'); ?></dt>
		<dd>
			<?php echo h($shipmentMethod['ShipmentMethod']['shipment_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Cash On Delivery Price'); ?></dt>
		<dd>
			<?php echo h($shipmentMethod['ShipmentMethod']['cash_on_delivery_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Tax Rate'); ?></dt>
		<dd>
			<?php echo h($shipmentMethod['ShipmentMethod']['tax_rate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Track Link'); ?></dt>
		<dd>
			<?php echo h($shipmentMethod['ShipmentMethod']['track_link']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($shipmentMethod['ShipmentMethod']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($shipmentMethod['ShipmentMethod']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Deleted'); ?></dt>
		<dd>
			<?php echo h($shipmentMethod['ShipmentMethod']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Shipment Method'), array('action' => 'edit', $shipmentMethod['ShipmentMethod']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Shipment Method'), array('action' => 'delete', $shipmentMethod['ShipmentMethod']['id']), null, __('Are you sure you want to delete # %s?', $shipmentMethod['ShipmentMethod']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Shipment Methods'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shipment Method'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shipment Method Configs'), array('controller' => 'shipment_method_configs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shipment Method Config'), array('controller' => 'shipment_method_configs', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Shipment Method Configs');?></h3>
	<?php if (!empty($shipmentMethod['ShipmentMethodConfig'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Shipment Method Id'); ?></th>
		<th><?php echo __('Weight'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Tax Rate'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($shipmentMethod['ShipmentMethodConfig'] as $shipmentMethodConfig): ?>
		<tr>
			<td><?php echo $shipmentMethodConfig['id'];?></td>
			<td><?php echo $shipmentMethodConfig['shipment_method_id'];?></td>
			<td><?php echo $shipmentMethodConfig['weight'];?></td>
			<td><?php echo $shipmentMethodConfig['price'];?></td>
			<td><?php echo $shipmentMethodConfig['tax_rate'];?></td>
			<td><?php echo $shipmentMethodConfig['modified'];?></td>
			<td><?php echo $shipmentMethodConfig['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shipment_method_configs', 'action' => 'view', $shipmentMethodConfig['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shipment_method_configs', 'action' => 'edit', $shipmentMethodConfig['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'shipment_method_configs', 'action' => 'delete', $shipmentMethodConfig['id']), null, __('Are you sure you want to delete # %s?', $shipmentMethodConfig['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Shipment Method Config'), array('controller' => 'shipment_method_configs', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
