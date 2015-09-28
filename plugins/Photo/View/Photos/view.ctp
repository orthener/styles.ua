<div class="photos view">
<h2><?php  echo __d('cms', 'Photo');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($photo['Photo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Img'); ?></dt>
		<dd>
			<?php echo h($photo['Photo']['img']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Offer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($photo['Offer']['id'], array('controller' => 'offers', 'action' => 'view', $photo['Offer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Page'); ?></dt>
		<dd>
			<?php echo $this->Html->link($photo['Page']['id'], array('controller' => 'pages', 'action' => 'view', $photo['Page']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Title'); ?></dt>
		<dd>
			<?php echo h($photo['Photo']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Order'); ?></dt>
		<dd>
			<?php echo h($photo['Photo']['order']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($photo['Photo']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($photo['Photo']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Edit Photo'), array('action' => 'edit', $photo['Photo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__d('cms', 'Delete Photo'), array('action' => 'delete', $photo['Photo']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $photo['Photo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List Photos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New Photo'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List Offers'), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New Offer'), array('controller' => 'offers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List Pages'), array('controller' => 'pages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New Page'), array('controller' => 'pages', 'action' => 'add')); ?> </li>
	</ul>
</div>
