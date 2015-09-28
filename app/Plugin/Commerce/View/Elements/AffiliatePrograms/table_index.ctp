	<h2><?php echo __d('cms', 'Affiliate Programs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('minimum', __d('cms', 'Minimum'));?></th>
	            <th><?php echo $this->Paginator->sort('discount', __d('cms', 'Discount'));?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($affiliatePrograms as $affiliateProgram): ?>
	<tr attrId="<?php echo $affiliateProgram['AffiliateProgram']['id']; ?>">
		<td><?php echo h($affiliateProgram['AffiliateProgram']['name']); ?>&nbsp;</td>
		<td><?php echo h($affiliateProgram['AffiliateProgram']['minimum']); ?>&nbsp;</td>
		<td><?php echo h($affiliateProgram['AffiliateProgram']['discount']); ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $affiliateProgram['AffiliateProgram']['id'])); ?>
			<?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $affiliateProgram['AffiliateProgram']['id'])); ?>
			<?php echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $affiliateProgram['AffiliateProgram']['id']), null, __('Are you sure you want to delete # %s?', $affiliateProgram['AffiliateProgram']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>