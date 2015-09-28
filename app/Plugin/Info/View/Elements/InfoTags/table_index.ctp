	<h2><?php echo __d('cms', 'Info Tags'); ?></h2>
	<table cellpadding="0" cellspacing="0">
    <thead>
	<tr>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('count', __d('cms', 'Count'));?></th>
	            	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
    </thead>
     <tbody>
	<?php
	$i = 0;
	foreach ($infoTags as $infoTag): ?>
	<tr data-id="<?php echo $infoTag['InfoTag']['id']; ?>">
		<td><?php echo h($infoTag['InfoTag']['name']); ?>&nbsp;</td>
		<td><?php echo h($infoTag['InfoTag']['count']); ?>&nbsp;</td>
		<td><?php echo $this->FebTime->niceShort($infoTag['InfoTag']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($infoTag['InfoTag']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $infoTag['InfoTag']['id'])); ?>
			<?php // echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $infoTag['InfoTag']['id'])); ?>
			<?php //echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $infoTag['InfoTag']['id']), null, __('Are you sure you want to delete # %s?', $infoTag['InfoTag']['name'])); ?>
         
            <div class="button"><?php echo __d('cms', 'Edit'); ?><br/> 				<?php echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', array('url' => array_merge(array('action' => 'edit', $infoTag['InfoTag']['id'])), 'active' => $infoTag['translateDisplay'], 'title' => __d('cms', 'Edit')))); ?>
            </div>
        			<?php echo $this->element('Translate.flags/trash', array('data' => $infoTag, 'model' => 'InfoTag')); ?>
		</td>
	</tr>
<?php endforeach; ?>
     </tbody>
	</table>