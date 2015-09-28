	<h2><?php echo __d('cms', 'Brands'); ?></h2>
	<table cellpadding="0" cellspacing="0">
    <thead>
	<tr>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('img', __d('cms', 'Img'));?></th>
	            <th><?php echo $this->Paginator->sort('desc', __d('cms', 'Desc'));?></th>
	            	            <th><?php echo $this->Paginator->sort('img2', __d('cms', 'Img2'));?></th>
	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
	            			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
    </thead>
     <tbody>
	<?php
	$i = 0;
	foreach ($brands as $brand): ?>
	<tr data-id="<?php echo $brand['Brand']['id']; ?>">
		<td><?php echo h($brand['Brand']['name']); ?>&nbsp;</td>
		<td><?php echo h($brand['Brand']['img']); ?>&nbsp;</td>
		<td><?php echo $this->Text->truncate(strip_tags($brand['Brand']['desc']), 200); ?>&nbsp;</td>
		<td><?php echo h($brand['Brand']['img2']); ?>&nbsp;</td>
		<td><?php echo $this->FebTime->niceShort($brand['Brand']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($brand['Brand']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $brand['Brand']['id'])); ?>
			<?php // echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $brand['Brand']['id'])); ?>
			<?php //echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $brand['Brand']['id']), null, __('Are you sure you want to delete # %s?', $brand['Brand']['name'])); ?>
         
                    <div class="button"><?php echo __d('cms', 'Edit'); ?><br /> 				<?php echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', array('url' => array_merge(array('action' => 'edit', $brand['Brand']['id'])), 'active' => $brand['translateDisplay'], 'title' => __d('cms', 'Edit')))); ?>
            </div>
        			<?php echo $this->element('Translate.flags/trash', array('data' => $brand, 'model' => 'Brand')); ?>
		</td>
	</tr>
<?php endforeach; ?>
     </tbody>
	</table>