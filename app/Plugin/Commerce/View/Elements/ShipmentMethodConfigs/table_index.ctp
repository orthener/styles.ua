<h2><?php echo __d('cms', 'Shipment Method Configs'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('shipment_method_id', __d('cms', 'Shipment Method Id')); ?></th>
        <th><?php echo $this->Paginator->sort('weight', __d('cms', 'Weight')); ?></th>
        <th><?php echo $this->Paginator->sort('price', __d('cms', 'Price')); ?></th>
        <th><?php echo $this->Paginator->sort('tax_rate', __d('cms', 'Tax Rate')); ?></th>
        <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($shipmentMethodConfigs as $shipmentMethodConfig):
        ?>
        <tr attrId="<?php echo $shipmentMethodConfig['ShipmentMethodConfig']['id']; ?>">
            <td>
    <?php echo $this->Permissions->link($shipmentMethodConfig['ShipmentMethod']['name'], array('controller' => 'shipment_methods', 'action' => 'view', $shipmentMethodConfig['ShipmentMethod']['id'])); ?>
            </td>
            <td><?php echo h($shipmentMethodConfig['ShipmentMethodConfig']['weight']) . ' kg'; ?>&nbsp;</td>
            <td><?php echo h($shipmentMethodConfig['ShipmentMethodConfig']['price']); ?>&nbsp;</td>
            <td><?php echo h($shipmentMethodConfig['ShipmentMethodConfig']['tax_rate']); ?>&nbsp;</td>
            <td><?php echo $this->FebTime->niceShort($shipmentMethodConfig['ShipmentMethodConfig']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($shipmentMethodConfig['ShipmentMethodConfig']['modified']); ?></td>
            <td class="actions">
                <?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $shipmentMethodConfig['ShipmentMethodConfig']['id'])); ?>
                <?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $shipmentMethodConfig['ShipmentMethodConfig']['id'])); ?>
    <?php echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $shipmentMethodConfig['ShipmentMethodConfig']['id']), null, __('Are you sure you want to delete # %s?', $shipmentMethodConfig['ShipmentMethodConfig']['price'])); ?>
            </td>
        </tr>
<?php endforeach; ?>
</table>