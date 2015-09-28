<div class="helps index">
    <h2><?php echo __d('cms', 'Helps'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('url'); ?></th>
            <th><?php echo $this->Paginator->sort('title'); ?></th>
            <th><?php echo $this->Paginator->sort('content'); ?></th>
            <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($helps as $help):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $help['Help']['id']; ?>&nbsp;</td>
                <td><?php echo $help['Help']['url']; ?>&nbsp;</td>
                <td><?php echo $help['Help']['title']; ?>&nbsp;</td>
                <td><?php echo $help['Help']['content']; ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('cms', 'Edit'), array('action' => 'edit', $help['Help']['id'])); ?>
                    <?php echo $this->Html->link(__d('cms', 'Delete'), array('action' => 'delete', $help['Help']['id']), null, sprintf(__d('cms', 'Are you sure you want to delete # %s?'), $help['Help']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __d('cms', 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
        ));
        ?>	</p>

    <div class="paging">
        <?php echo $this->Paginator->prev('<< ' . __d('cms', 'previous'), array(), null, array('class' => 'disabled')); ?>
        | 	<?php echo $this->Paginator->numbers(); ?>
        |
        <?php echo $this->Paginator->next(__d('cms', 'next') . ' >>', array(), null, array('class' => 'disabled')); ?>
    </div>
</div>
