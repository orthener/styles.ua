	<h2><?php echo __d('cms', 'Notes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
	            <th><?php echo $this->Paginator->sort('title', __d('cms', 'Title'));?></th>
	            <th><?php echo $this->Paginator->sort('user_id', __d('cms', 'User Id'));?></th>
	            <th><?php echo $this->Paginator->sort('row_id', __d('cms', 'Row Id'));?></th>
	            <th><?php echo $this->Paginator->sort('model', __d('cms', 'Model'));?></th>
	            <th><?php echo $this->Paginator->sort('content', __d('cms', 'Content'));?></th>
	            	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
			<th class="actions"><?php echo __d('cms', 'Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($notes as $note): ?>
	<tr attrId="<?php echo $note['Note']['id']; ?>">
		<td><?php echo h($note['Note']['title']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Permissions->link($note['User']['name'], array('controller' => 'users', 'action' => 'view', $note['User']['id'])); ?>
		</td>
		<td><?php echo h($note['Note']['row_id']); ?>&nbsp;</td>
		<td><?php echo h($note['Note']['model']); ?>&nbsp;</td>
		<td><?php echo h($note['Note']['content']); ?>&nbsp;</td>
		<td><?php echo $this->FebTime->niceShort($note['Note']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($note['Note']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__d('cms', 'View'), array('action' => 'view', $note['Note']['id'])); ?>
			<?php echo $this->Permissions->link(__d('cms', 'Edit'), array('action' => 'edit', $note['Note']['id'])); ?>
			<?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $note['Note']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $note['Note']['title'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>