<div class="newsletters index">
	<h2><?php echo  __d('cms', 'Newsletters');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo  __d('cms', 'Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($newsletters as $newsletter):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $newsletter['Newsletter']['id']; ?>&nbsp;</td>
		<td><?php echo $newsletter['Newsletter']['email']; ?>&nbsp;</td>
		<td><?php echo $newsletter['Newsletter']['created']; ?>&nbsp;</td>
		<td><?php echo $newsletter['Newsletter']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__d('cms', 'View'), array('action' => 'view', $newsletter['Newsletter']['id'])); ?>
			<?php echo $this->Html->link(__d('cms', 'Edit'), array('action' => 'edit', $newsletter['Newsletter']['id'])); ?>
			<?php echo $this->Html->link(__d('cms', 'Delete'), array('action' => 'delete', $newsletter['Newsletter']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $newsletter['Newsletter']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __d('cms', 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __d('cms', 'previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__d('cms', 'next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo  __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'New Newsletter'), array('action' => 'add')); ?></li>
	</ul>
</div>