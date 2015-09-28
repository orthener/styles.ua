<div class="promotionCodes view">
<h2><?php  echo __('Promotion Code');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($promotionCode['PromotionCode']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Code'); ?></dt>
		<dd>
			<?php echo h($promotionCode['PromotionCode']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Single'); ?></dt>
		<dd>
			<?php echo h($promotionCode['PromotionCode']['single']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Value'); ?></dt>
		<dd>
			<?php echo h($promotionCode['PromotionCode']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Expiry Date'); ?></dt>
		<dd>
			<?php echo h($promotionCode['PromotionCode']['expiry_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Used'); ?></dt>
		<dd>
			<?php echo h($promotionCode['PromotionCode']['used']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Deleted'); ?></dt>
		<dd>
			<?php echo h($promotionCode['PromotionCode']['deleted']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($promotionCode['PromotionCode']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($promotionCode['PromotionCode']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Promotion Code'), array('action' => 'edit', $promotionCode['PromotionCode']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Promotion Code'), array('action' => 'delete', $promotionCode['PromotionCode']['id']), null, __('Are you sure you want to delete # %s?', $promotionCode['PromotionCode']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Promotion Codes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Promotion Code'), array('action' => 'add')); ?> </li>
	</ul>
</div>
