<h2><?php echo __d('cms', 'Article Categories'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name')); ?></th>
            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        <?php foreach ($infoCategories as $infoCategory): ?>
            <tr data-id="<?php echo $infoCategory['InfoCategory']['id']; ?>">
                <td><?php echo h($infoCategory['InfoCategory']['name']); ?>&nbsp;</td>
                <td><?php echo $this->FebTime->niceShort($infoCategory['InfoCategory']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($infoCategory['InfoCategory']['modified']); ?></td>
                <td class="actions">
                    <?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $infoCategory['InfoCategory']['id'])); ?>
                    <?php // echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $infoCategory['InfoCategory']['id'])); ?>
                    <?php //echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $infoCategory['InfoCategory']['id']), null, __('Are you sure you want to delete # %s?', $infoCategory['InfoCategory']['name']));  ?>

                    <div class="button"><?php echo __d('cms', 'Edit'); ?><br/> 	
                        <?php $opts = array('url' => array_merge(array('action' => 'edit', $infoCategory['InfoCategory']['id'])), 'active' => $infoCategory['translateDisplay'], 'title' => __d('cms', 'Edit')); ?>
                        <?php echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', $opts)); ?>
                    </div>
                    <?php echo $this->element('Translate.flags/trash', array('data' => $infoCategory, 'model' => 'InfoCategory')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>