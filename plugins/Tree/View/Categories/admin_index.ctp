<div class="categories index">
    <?php echo $this->element('Categories/table_index'); ?>
    <?php echo $this->element('cms/paginator'); ?>
</div>
<div class="actions">
	<h3><?php echo  __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'New Category'), array('action' => 'add')); ?></li>
	</ul>
</div>