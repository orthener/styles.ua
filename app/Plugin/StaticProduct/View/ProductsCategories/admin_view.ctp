<div class="productCategories view">
<h2><?php  echo __('Product Category');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($productCategory['ProductsCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($productCategory['ProductsCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Parent Id'); ?></dt>
		<dd>
			<?php echo h($productCategory['ProductsCategory']['parent_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Lft'); ?></dt>
		<dd>
			<?php echo h($productCategory['ProductsCategory']['lft']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Rght'); ?></dt>
		<dd>
			<?php echo h($productCategory['ProductsCategory']['rght']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($productCategory['ProductsCategory']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($productCategory['ProductsCategory']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Product Category'), array('action' => 'edit', $productCategory['ProductsCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Product Category'), array('action' => 'delete', $productCategory['ProductsCategory']['id']), null, __('Are you sure you want to delete # %s?', $productCategory['ProductsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Product Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Category'), array('action' => 'add')); ?> </li>
	</ul>
</div>
