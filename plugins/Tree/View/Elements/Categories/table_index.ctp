<h2><?php echo __d('cms', 'Categories'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('name'); ?></th>
        <th><?php echo $this->Paginator->sort('url'); ?></th>
        <th><?php echo $this->Paginator->sort('created'); ?> / <?php echo $this->Paginator->sort('modified'); ?></th>
        <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($categories as $category):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
        ?>
        <tr<?php echo $class; ?>>
            <td><?php echo $category['Category']['id']; ?>&nbsp;</td>
            <td><?php echo $category['Category']['name']; ?>&nbsp;</td>
            <td><?php echo $category['Category']['url']; ?>&nbsp;</td>

            <td><?php echo $category['Category']['created']; ?> / <?php echo $category['Category']['modified']; ?>&nbsp;</td>
            <td class="actions">
                <?php echo $this->Html->div('clearfix', $this->element('flag', array('url' => array('action' => 'edit', $category['Category']['id']), 'active' => $category['translateDisplay']))); ?>
                <?php echo $this->Html->link(__d('cms', 'Delete'), array('action' => 'delete', $category['Category']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $category['Category']['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>