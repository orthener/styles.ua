<div class="countries view">
<h2><?php  echo __d('cms', 'Country');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($country['Country']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($country['Country']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Printable Name En'); ?></dt>
		<dd>
			<?php echo h($country['Country']['printable_name_en']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Printable Name'); ?></dt>
		<dd>
			<?php echo h($country['Country']['printable_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Iso3'); ?></dt>
		<dd>
			<?php echo h($country['Country']['iso3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Numcode'); ?></dt>
		<dd>
			<?php echo h($country['Country']['numcode']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Edit Country'), array('action' => 'edit', $country['Country']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__d('cms', 'Delete Country'), array('action' => 'delete', $country['Country']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $country['Country']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List Countries'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New Country'), array('action' => 'add')); ?> </li>
	</ul>
</div>
