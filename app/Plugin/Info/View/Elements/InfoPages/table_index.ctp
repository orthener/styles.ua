<h2><?php echo __d('cms', 'Article Pages'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <!--<th><?php //echo $this->Paginator->sort('name', __d('cms', 'Name'));  ?></th>-->
            <th><?php echo $this->Paginator->sort('category_id', __d('cms', 'Kategoria')); ?></th>
            <th><?php echo $this->Paginator->sort('title', __d('cms', 'Title')); ?></th>
            <!--<th><?php // echo $this->Paginator->sort('on_blog', __d('cms', 'Aktualności/Blog'));  ?></th>-->
            <th><?php echo $this->Paginator->sort('tags', __d('cms', 'Tags')); ?></th>
            <th><?php echo $this->Paginator->sort('publication_date', __d('cms', 'Data publikacji')); ?></th>
            <th><?php echo $this->Paginator->sort('content', __d('cms', 'Treść')); ?></th>
            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        <?php foreach ($infoPages as $infoPage): ?>
            <tr data-id="<?php echo $infoPage['InfoPage']['id']; ?>">
                <!--<td><?php // echo h($infoPage['InfoPage']['name']);  ?>&nbsp;</td>-->
                <td><?php echo empty($categories[ $infoPage['InfoPage']['category_id'] ])? "":$categories[ $infoPage['InfoPage']['category_id'] ]; ?>&nbsp;</td>
                <td><?php echo h($infoPage['InfoPage']['title']); ?>&nbsp;</td>
                <!--<td><?php // echo $infoPage['InfoPage']['on_blog'] ? "blog" : "aktualności";  ?>&nbsp;</td>-->
                <td><?php echo h($infoPage['InfoPage']['tags']); ?>&nbsp;</td>
                <td><?php echo h($infoPage['InfoPage']['publication_date']); ?>&nbsp;</td>
                <td><?php echo $this->Text->truncate($infoPage['InfoPage']['content'], 100) ?></td>
                <td><?php echo $this->FebTime->niceShort($infoPage['InfoPage']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($infoPage['InfoPage']['modified']); ?></td>
                <td class="actions">
                    <?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $infoPage['InfoPage']['id'])); ?>
                    <?php // echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $infoPage['InfoPage']['id'])); ?>
                    <?php //echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $infoPage['InfoPage']['id']), null, __('Are you sure you want to delete # %s?', $infoPage['InfoPage']['name']));  ?>

                    <?php echo $this->Permissions->link(__('Zdjęcia'), array('plugin' => 'photo', 'controller' => 'photos', 'action' => 'index', 'Info.InfoPage', $infoPage['InfoPage']['id'])); ?>
                    <div class="button"><?php echo __d('cms', 'Edit'); ?><br/> 				
                        <?php echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', array('url' => array_merge(array('action' => 'edit', $infoPage['InfoPage']['id'])), 'active' => $infoPage['translateDisplay'], 'title' => __d('cms', 'Edit')))); ?>
                    </div>
                    <?php echo $this->element('Translate.flags/trash', array('data' => $infoPage, 'model' => 'InfoPage')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>