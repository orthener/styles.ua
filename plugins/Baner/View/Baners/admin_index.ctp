<div class="baners index">
    <h2><?php echo __d('cms', 'Baners'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('url', __d('cms', 'URL')); ?></th>
            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Nazwa')); ?></th>
            <th><?php echo $this->Paginator->sort('clicks_counter', __d('cms', 'Ilość kliknięć')); ?></th>
            <th><?php echo $this->Paginator->sort('shows_counter', __d('cms', 'Ilość wyświetleń')); ?></th>
            <th><?php echo $this->Paginator->sort('group', __d('cms', 'Grupa')); ?></th>
            <th><?php echo $this->Paginator->sort('published', __d('cms', 'Publikowany')); ?></th>
            <th class="actions"><?php __d('cms', 'Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($baners as $baner):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $this->Html->link($baner['Baner']['url'], $baner['Baner']['url'], array('target' => '_blank')); ?>&nbsp;</td>
                <td><?php echo h($baner['Baner']['name']); ?>&nbsp;</td>
                <td><?php echo h($baner['Baner']['clicks_counter']); ?>&nbsp;</td>
                <td><?php echo h($baner['Baner']['shows_counter']); ?>&nbsp;</td>
                <td><?php echo h($baner['Baner']['group']); ?>&nbsp;</td>

                <td><?php
        if ($baner['Baner']['published']) {
            echo "TAK";
        } else {
            echo "NIE";
        }
            ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('cms', 'Edit'), array('action' => 'edit', $baner['Baner']['id'])); ?>
                    <?php echo $this->Form->postLink(__d('cms', 'Delete'), array('action' => 'delete', $baner['Baner']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $baner['Baner']['name'])); ?>
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
<div class="actions">
    <h3><?php __d('cms', 'Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'New Baner'), array('action' => 'add')); ?></li>
<!--        <li><?php //echo $this->Html->link(__d('cms', 'Statystyki'), array('action' => 'baner_stats')); ?></li>-->
    </ul>
</div>