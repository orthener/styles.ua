<h2><?php echo __d('cms', 'Photos'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('img', __d('cms', 'Img')); ?></th>
        <th><?php echo $this->Paginator->sort('offer_id', __d('cms', 'Offer Id')); ?></th>
        <th><?php echo $this->Paginator->sort('page_id', __d('cms', 'Page Id')); ?></th>
        <th><?php echo $this->Paginator->sort('title', __d('cms', 'Title')); ?></th>
        <th><?php echo $this->Paginator->sort('order', __d('cms', 'Order')); ?></th>
        <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
        <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($photos as $photo):
        ?>
        <tr attrId="<?php echo $photo['Photo']['id']; ?>">
            <td><?php echo h($photo['Photo']['img']); ?>&nbsp;</td>
            <td>
                <?php echo $this->Permissions->link($photo['Offer']['id'], array('controller' => 'offers', 'action' => 'view', $photo['Offer']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Permissions->link($photo['Page']['id'], array('controller' => 'pages', 'action' => 'view', $photo['Page']['id'])); ?>
            </td>
            <td><?php echo h($photo['Photo']['title']); ?>&nbsp;</td>
            <td><?php echo h($photo['Photo']['order']); ?>&nbsp;</td>
            <td><?php echo $this->FebTime->niceShort($photo['Photo']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($photo['Photo']['modified']); ?></td>
            <td class="actions">
                <?php //echo $this->Permissions->link(__d('cms', 'View'), array('action' => 'view', $photo['Photo']['id'])); ?>
                <?php echo $this->Permissions->link(__d('cms', 'Edit'), array('action' => 'edit', $photo['Photo']['id'])); ?>
                <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $photo['Photo']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $photo['Photo']['title'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>