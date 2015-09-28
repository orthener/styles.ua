<div class="affiliatePrograms view">
<h2><?php  echo __('Affiliate Program');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($affiliateProgram['AffiliateProgram']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($affiliateProgram['AffiliateProgram']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Minimum'); ?></dt>
		<dd>
			<?php echo h($affiliateProgram['AffiliateProgram']['minimum']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Discount'); ?></dt>
		<dd>
			<?php echo h($affiliateProgram['AffiliateProgram']['discount']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Affiliate Program'), array('action' => 'edit', $affiliateProgram['AffiliateProgram']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Affiliate Program'), array('action' => 'delete', $affiliateProgram['AffiliateProgram']['id']), null, __('Are you sure you want to delete # %s?', $affiliateProgram['AffiliateProgram']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Affiliate Programs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Affiliate Program'), array('action' => 'add')); ?> </li>
	</ul>
</div>
