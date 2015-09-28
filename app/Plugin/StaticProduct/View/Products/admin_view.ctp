<div class="products view">
<h2><?php  echo __('Product');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($product['Product']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Photo'); ?></dt>
		<dd>
			<?php echo $this->Html->link($product['Photo']['title'], array('controller' => 'photos', 'action' => 'view', $product['Photo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($product['ProductsCategory']['name'], array('controller' => 'product_categories', 'action' => 'view', $product['ProductsCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Title'); ?></dt>
		<dd>
			<?php echo h($product['Product']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Content'); ?></dt>
		<dd>
			<?php echo h($product['Product']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Slug'); ?></dt>
		<dd>
			<?php echo h($product['Product']['slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Price'); ?></dt>
		<dd>
			<?php echo h($product['Product']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Tax Rate'); ?></dt>
		<dd>
			<?php echo h($product['Product']['tax_rate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Tax Value'); ?></dt>
		<dd>
			<?php echo h($product['Product']['tax_value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($product['Product']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($product['Product']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Product'), array('action' => 'edit', $product['Product']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Product'), array('action' => 'delete', $product['Product']['id']), null, __('Are you sure you want to delete # %s?', $product['Product']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Photos'), array('controller' => 'photos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Photo'), array('controller' => 'photos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product Categories'), array('controller' => 'product_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Category'), array('controller' => 'product_categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
