<h2><?php echo __d('cms', 'Shipment Methods'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name')); ?></th>
        <th><?php echo $this->Paginator->sort('img', __d('cms', 'Img')); ?></th>
        <th><?php echo $this->Paginator->sort('shipment_price', __d('cms', 'Shipment Price')); ?></th>
        <th><?php echo $this->Paginator->sort('is_weight_over', __d('cms', 'Czy można przekroczyć tabelę wag?')); ?></th>
        <th><?php echo $this->Paginator->sort('is_cash_on_delivery', __d('cms', 'Czy jest dostępna przesyłka za pobraniem?')); ?></th>
        <th><?php echo $this->Paginator->sort('cash_on_delivery_price', __d('cms', 'Cash On Delivery Price')); ?></th>
        <th><?php echo $this->Paginator->sort('tax_rate', __d('cms', 'Tax Rate')); ?></th>
        <th><?php echo $this->Paginator->sort('track_link', __d('cms', 'Track Link')); ?></th>
        <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
                        <!--<th><?php echo $this->Paginator->sort('deleted', __d('cms', 'Deleted')); ?></th>-->
        <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($shipmentMethods as $shipmentMethod):
        ?>
        <tr attrId="<?php echo $shipmentMethod['ShipmentMethod']['id']; ?>">
            <td><?php echo h($shipmentMethod['ShipmentMethod']['name']); ?>&nbsp;</td>
            <td><?php echo h($shipmentMethod['ShipmentMethod']['img']); ?>&nbsp;</td>
            <td><?php echo h($shipmentMethod['ShipmentMethod']['shipment_price']); ?>&nbsp;</td>
            <td><?php echo $shipmentMethod['ShipmentMethod']['is_weight_over'] == true ? 'tak' : 'nie'; ?></td>
            <td><?php //echo $shipmentMethod['ShipmentMethod']['is_cash_on_delivery'] == true ? 'tak' : 'nie'; ?></td>
            <td><?php //echo h($shipmentMethod['ShipmentMethod']['cash_on_delivery_price']); ?>&nbsp;</td>
            <td><?php echo h($shipmentMethod['ShipmentMethod']['tax_rate']); ?>&nbsp;</td>
            <td><?php echo h($shipmentMethod['ShipmentMethod']['track_link']); ?>&nbsp;</td>
            <!--<td><?php echo h($shipmentMethod['ShipmentMethod']['deleted']); ?>&nbsp;</td>-->
            <td><?php echo $this->FebTime->niceShort($shipmentMethod['ShipmentMethod']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($shipmentMethod['ShipmentMethod']['modified']); ?></td>
            <td class="actions">
                <?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $shipmentMethod['ShipmentMethod']['id'])); ?>
                <?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $shipmentMethod['ShipmentMethod']['id'])); ?>
                <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $shipmentMethod['ShipmentMethod']['id']), null, __('Are you sure you want to delete # %s?', $shipmentMethod['ShipmentMethod']['name'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>