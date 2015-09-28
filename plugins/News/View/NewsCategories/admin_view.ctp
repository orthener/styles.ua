<div class="newsCategories view">
<h2><?php  echo __d('cms', 'News Category');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($newsCategory['NewsCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($newsCategory['NewsCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($newsCategory['NewsCategory']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($newsCategory['NewsCategory']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Edit News Category'), array('action' => 'edit', $newsCategory['NewsCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__d('cms', 'Delete News Category'), array('action' => 'delete', $newsCategory['NewsCategory']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $newsCategory['NewsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List News Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New News Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List News'), array('controller' => 'news', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New News'), array('controller' => 'news', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __d('cms', 'Related News');?></h3>
	<?php if (!empty($newsCategory['News'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __d('cms', 'Id'); ?></th>
		<th><?php echo __d('cms', 'Blog'); ?></th>
		<th><?php echo __d('cms', 'Main'); ?></th>
		<th><?php echo __d('cms', 'User Id'); ?></th>
		<th><?php echo __d('cms', 'Photo Id'); ?></th>
		<th><?php echo __d('cms', 'Order'); ?></th>
		<th><?php echo __d('cms', 'Date'); ?></th>
		<th><?php echo __d('cms', 'News Category Id'); ?></th>
		<th><?php echo __d('cms', 'Modified'); ?></th>
		<th><?php echo __d('cms', 'Created'); ?></th>
		<th class="actions"><?php echo __d('cms', 'Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($newsCategory['News'] as $news): ?>
		<tr>
			<td><?php echo $news['id'];?></td>
			<td><?php echo $news['blog'];?></td>
			<td><?php echo $news['main'];?></td>
			<td><?php echo $news['user_id'];?></td>
			<td><?php echo $news['photo_id'];?></td>
			<td><?php echo $news['order'];?></td>
			<td><?php echo $news['date'];?></td>
			<td><?php echo $news['news_category_id'];?></td>
			<td><?php echo $news['modified'];?></td>
			<td><?php echo $news['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__d('cms', 'View'), array('controller' => 'news', 'action' => 'view', $news['id'])); ?>
				<?php echo $this->Html->link(__d('cms', 'Edit'), array('controller' => 'news', 'action' => 'edit', $news['id'])); ?>
				<?php echo $this->Form->postLink(__d('cms', 'Delete'), array('controller' => 'news', 'action' => 'delete', $news['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $news['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__d('cms', 'New News'), array('controller' => 'news', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
