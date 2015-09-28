<div class="groups view">
<h2><?php  __d('cms', 'Grupa');?>: <?php echo $group['Group']['name']; ?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo  __d('cms', 'Alias'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['alias']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo  __d('cms', 'Utworzono'); ?> (<?php echo  __d('cms', 'Zmodyfikowano'); ?>)</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['created']; ?> (<?php echo $group['Group']['modified']; ?>)
			&nbsp;
		</dd>
	</dl>
</div>
<br />
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Edytuj %s', 'grupę'), array('action' => 'edit', $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'Usuń %s', 'grupę'), array('action' => 'delete', $group['Group']['id']), null, __d('cms', 'Jesteś pewien, że chcesz usunąć grupę "%s"?', $group['Group']['name'])); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'Lista %s', 'grup'), array('action' => 'index')); ?> </li>
	</ul>
</div>
<br />
<div class="related">
	<h3><?php echo __d('cms', 'Uprawnienia %s', 'grupy'); ?></h3>
	<?php if (!empty($group['Permission'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo  __d('cms', 'Id'); ?></th>
		<th><?php echo  __d('cms', 'Nazwa'); ?></th>
		<th><?php echo  __d('cms', 'Utworzono'); ?></th>
		<th><?php echo  __d('cms', 'Zmodyfikowano'); ?></th>
		<th class="actions"><?php echo  __d('cms', 'Akcje');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($group['Permission'] as $permission):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $permission['id'];?></td>
			<td><?php echo $permission['name'];?></td>
			<td><?php echo $permission['created'];?></td>
			<td><?php echo $permission['modified'];?></td>
			<td class="actions">
				<?php 
                    echo $this->Html->link(__d('cms', 'Usuń powiązanie'), array(
                            'controller' => 'permissions', 
                            'action' => 'delete_rp', 
                            'Group', 
                            $group['Group']['id'], 
                            $permission['id']
                        ), null, 
                        __d('cms', 'Jesteś pewnien, że chcesz usunąć uprawnienie grupy "%s" do zasobu "%s"?', $group['Group']['name'], $permission['name'])
                    );
                ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__d('cms', 'Dodaj %s','uprawnienie'), array('controller' => 'permissions', 'action' => 'add_rp', 'Group', $group['Group']['id']));?> </li>
		</ul>
	</div>
</div>