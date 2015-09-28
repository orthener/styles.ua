<div class="permissionCategories view">
<h2><?php  echo __d('cms', 'Permission Category');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($permissionCategory['PermissionCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($permissionCategory['PermissionCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($permissionCategory['PermissionCategory']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($permissionCategory['PermissionCategory']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Edit Permission Category'), array('action' => 'edit', $permissionCategory['PermissionCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__d('cms', 'Delete Permission Category'), array('action' => 'delete', $permissionCategory['PermissionCategory']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $permissionCategory['PermissionCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List Permission Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New Permission Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List Permission Groups'), array('controller' => 'permission_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New Permission Group'), array('controller' => 'permission_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __d('cms', 'Related Permission Groups');?></h3>
	<?php if (!empty($permissionCategory['PermissionGroup'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __d('cms', 'Id'); ?></th>
		<th><?php echo __d('cms', 'Name'); ?></th>
		<th><?php echo __d('cms', 'Permission Category Id'); ?></th>
		<th><?php echo __d('cms', 'Modified'); ?></th>
		<th><?php echo __d('cms', 'Created'); ?></th>
		<th class="actions"><?php echo __d('cms', 'Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($permissionCategory['PermissionGroup'] as $permissionGroup): ?>
		<tr>
			<td><?php echo $permissionGroup['id'];?></td>
			<td><?php echo $permissionGroup['name'];?></td>
			<td><?php echo $permissionGroup['permission_category_id'];?></td>
			<td><?php echo $permissionGroup['modified'];?></td>
			<td><?php echo $permissionGroup['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__d('cms', 'View'), array('controller' => 'permission_groups', 'action' => 'view', $permissionGroup['id'])); ?>
				<?php echo $this->Html->link(__d('cms', 'Edit'), array('controller' => 'permission_groups', 'action' => 'edit', $permissionGroup['id'])); ?>
				<?php echo $this->Form->postLink(__d('cms', 'Delete'), array('controller' => 'permission_groups', 'action' => 'delete', $permissionGroup['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $permissionGroup['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__d('cms', 'New Permission Group'), array('controller' => 'permission_groups', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
