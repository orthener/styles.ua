<?php $this->set('title_for_layout', __d('cms', 'Wycinki strony').' ('.__d('cms', 'Fragmenty layoutu').')'); ?>
<div class="dynamicElements index">
	<h2><?php echo  __d('cms', 'Wycinki strony');?> (<?php echo  __d('cms', 'Fragmenty layoutu'); ?>)</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('slug');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo  __d('cms', 'Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($dynamicElements as $dynamicElement):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $dynamicElement['DynamicElement']['id']; ?>&nbsp;</td>
		<td><?php echo $dynamicElement['DynamicElement']['name']; ?>&nbsp;</td>
		<td><?php echo $dynamicElement['DynamicElement']['slug']; ?>&nbsp;</td>
		<td><?php echo $dynamicElement['DynamicElement']['created']; ?>&nbsp;</td>
		<td><?php echo $dynamicElement['DynamicElement']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__d('cms', 'Edit'), array('action' => 'edit', $dynamicElement['DynamicElement']['id'])); ?>
			<?php //echo $this->Html->link(__d('cms', 'Delete'), array('action' => 'delete', $dynamicElement['DynamicElement']['id']), null, sprintf(__d('cms', 'Are you sure you want to delete # %s?'), $dynamicElement['DynamicElement']['id'])); ?>
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
<?php /* ?>
<div class="actions">
	<h3><?php echo  __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php //echo $this->Html->link(__d('cms', 'Nowy wycinek'), array('action' => 'add')); ?></li>
	</ul>
</div>
<?php /**/ ?>