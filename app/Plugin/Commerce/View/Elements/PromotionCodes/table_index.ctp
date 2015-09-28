	<h2><?php echo __d('cms', 'Promotion Codes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
    <thead>
	<tr>
	            <th><?php echo $this->Paginator->sort('code', __d('cms', 'Code'));?></th>
	            <th><?php echo $this->Paginator->sort('single', __d('cms', 'Jednokrotengo użytku'));?></th>
	            <th><?php echo $this->Paginator->sort('value', __d('cms', 'Value'));?></th>
	            <th><?php echo $this->Paginator->sort('expiry_date', __d('cms', 'Expiry Date'));?></th>
	            <th><?php echo $this->Paginator->sort('used', __d('cms', 'Used'));?></th>
<!--	            <th><?php echo $this->Paginator->sort('deleted', __d('cms', 'Deleted'));?></th>-->
	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
	            			<th class="actions"><?php echo __d('cms', 'Actions');?></th>
	</tr>
    </thead>
     <tbody>
	<?php
	$i = 0;
	foreach ($promotionCodes as $promotionCode): ?>
	<tr data-id="<?php echo $promotionCode['PromotionCode']['id']; ?>">
		<td><?php echo h($promotionCode['PromotionCode']['code']); ?>&nbsp;</td>
                <td><?php echo ($promotionCode['PromotionCode']['single'])?  __d('cms', "TAK"):  __d('cms', "NIE"); ?>&nbsp;</td>
		<td><?php echo h($promotionCode['PromotionCode']['value']); ?>&nbsp;</td>
		<td><?php echo h($promotionCode['PromotionCode']['expiry_date']); ?>&nbsp;</td>
		<td><?php echo ($promotionCode['PromotionCode']['used'])? __d('cms', "TAK"):  __d('cms', "NIE"); ?>&nbsp;</td>
<!--		<td><?php echo ($promotionCode['PromotionCode']['deleted'])? __d('cms', "TAK"):  __d('cms', "NIE"); ?>&nbsp;</td>-->
		<td><?php echo $this->FebTime->niceShort($promotionCode['PromotionCode']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($promotionCode['PromotionCode']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $promotionCode['PromotionCode']['id'])); ?>
			<?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $promotionCode['PromotionCode']['id'])); ?>
			<?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $promotionCode['PromotionCode']['id']), null, __('Are you sure you want to delete # %s?', $promotionCode['PromotionCode']['code'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
     </tbody>
	</table>