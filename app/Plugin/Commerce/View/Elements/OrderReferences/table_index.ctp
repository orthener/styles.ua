	<h2><?php echo __d('cms', 'Order References'); ?></h2>
	<table cellpadding="0" cellspacing="0">
    <thead>
	<tr>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('phone', __d('cms', 'Phone'));?></th>
	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
	            			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
    </thead>
     <tbody>
	<?php
	$i = 0;
	foreach ($orderReferences as $orderReference): ?>
	<tr data-id="<?php echo $orderReference['OrderReference']['id']; ?>">
		<td><?php echo h($orderReference['OrderReference']['name']); ?>&nbsp;</td>
		<td><?php echo h($orderReference['OrderReference']['phone']); ?>&nbsp;</td>
		<td><?php echo $this->FebTime->niceShort($orderReference['OrderReference']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($orderReference['OrderReference']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $orderReference['OrderReference']['id'])); ?>
			<?php // echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $orderReference['OrderReference']['id'])); ?>
			<?php echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $orderReference['OrderReference']['id']), null, __('Are you sure you want to delete # %s?', $orderReference['OrderReference']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
     </tbody>
	</table>