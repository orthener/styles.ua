	<h2><?php echo __d('cms', 'Regions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('order', __d('cms', 'Order'));?></th>
			<th class="actions"><?php echo __d('cms', 'Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($regions as $region): ?>
	<tr attrId="<?php echo $region['Region']['id']; ?>">
		<td><?php echo h($region['Region']['name']); ?>&nbsp;</td>
		<td><?php echo h($region['Region']['order']); ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__d('cms', 'View'), array('action' => 'view', $region['Region']['id'])); ?>
			<?php echo $this->Permissions->link(__d('cms', 'Edit'), array('action' => 'edit', $region['Region']['id'])); ?>
			<?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $region['Region']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $region['Region']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>