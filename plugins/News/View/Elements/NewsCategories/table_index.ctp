<h2><?php echo __d('cms', 'Blog Categories'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name')); ?></th>
            <th><?php echo __d('cms', 'News Count'); ?></th>
            <th><?php echo $this->Paginator->sort('is_promoted', __d('cms', 'Czy promowany')); ?></th>
            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
            <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        <?php foreach ($newsCategories as $newsCategory): ?>
            <tr data-id="<?php echo $newsCategory['NewsCategory']['id']; ?>">
                <td><?php echo h($newsCategory['NewsCategory']['name']); ?>&nbsp;</td>
                <td><?php echo count($newsCategory['News']); ?>&nbsp;</td>
                <td><?php echo $newsCategory['NewsCategory']['is_promoted'] ? __d('cms', 'Tak') : __d('cms', 'Nie'); ?></td>
                <td><?php echo $this->FebTime->niceShort($newsCategory['NewsCategory']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($newsCategory['NewsCategory']['modified']); ?></td>
                <td class="actions">
                    <?php //echo $this->Permissions->link(__d('cms', 'View'), array('action' => 'view', $newsCategory['NewsCategory']['id'])); ?>
                    <?php // echo $this->Permissions->link(__d('cms', 'Edit'), array('action' => 'edit', $newsCategory['NewsCategory']['id'])); ?>
                    <?php //echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $newsCategory['NewsCategory']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $newsCategory['NewsCategory']['name']));  ?>

                    <div class="button"><?php echo __d('cms', 'Edytuj'); ?><br /> 				
                        <?php echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', array('url' => array_merge(array('action' => 'edit', $newsCategory['NewsCategory']['id'])), 'active' => $newsCategory['translateDisplay'], 'title' => __d('cms', 'Edit')))); ?>
                    </div>
                    <?php echo $this->element('Translate.flags/trash', array('data' => $newsCategory, 'model' => 'NewsCategory')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>