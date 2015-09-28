	<h2><?php echo __d('cms', 'Modifications');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
	            <th><?php echo $this->Paginator->sort('user_id', __d('cms', 'User Id'));?></th>
	            <th><?php echo $this->Paginator->sort('model', __d('cms', 'Model'));?></th>
	            <th><?php echo $this->Paginator->sort('foreign_key', __d('cms', 'Foreign Key'));?></th>
	            <th><?php echo $this->Paginator->sort('action', __d('cms', 'Action'));?></th>
	            <th><?php echo $this->Paginator->sort('user_details', __d('cms', 'User Details'));?></th>
	            <th><?php echo $this->Paginator->sort('content_before', __d('cms', 'Content Before'));?></th>
	            <th><?php echo $this->Paginator->sort('content_after', __d('cms', 'Content After'));?></th>
	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created'));?></th>
			<th class="actions"><?php echo __d('cms', 'Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($modifications as $modification): ?>
	<tr attrId="<?php echo $modification['Modification']['id']; ?>">
		<td><?php echo h($modification['Modification']['user_id']); ?>&nbsp;</td>
		<td><?php echo h($modification['Modification']['model']); ?>&nbsp;</td>
		<td><?php echo h($modification['Modification']['foreign_key']); ?>&nbsp;</td>
		<td><?php echo h($modification['Modification']['action']); ?>&nbsp;</td>
		<td><?php echo h($modification['Modification']['user_details']); ?>&nbsp;</td>
		<td><?php echo h($modification['Modification']['content_before']); ?>&nbsp;</td>
		<td><?php echo h($modification['Modification']['content_after']); ?>&nbsp;</td>
		<td><?php echo $this->FebTime->niceShort($modification['Modification']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__d('cms', 'View'), array('action' => 'view', $modification['Modification']['id'])); ?>
			<?php echo $this->Permissions->link(__d('cms', 'Edit'), array('action' => 'edit', $modification['Modification']['id'])); ?>
			<?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $modification['Modification']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $modification['Modification']['user_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>