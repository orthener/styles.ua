<?php $this->set('title_for_layout', __d('cms', 'Komentarze do moderacji')); ?>
<div class="comments index">
    <h2><?php echo __d('cms', 'Komentarze do moderacji'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('Autor', 'name'); ?></th>
            <th><?php echo $this->Paginator->sort('Treść', 'desc'); ?></th>
            <th><?php echo $this->Paginator->sort('Strona', 'page_id'); ?></th>
            <th><?php echo $this->Paginator->sort('Utworzono', 'created'); ?></th>
            <th class="actions"><?php echo __d('cms', 'Opcje'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($comments as $comment):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?> id="display_<?php echo $comment['Comment']['id']; ?>">
                <td>
                    <?php echo $comment['Comment']['name']; ?>
                </td>
                <td><?php echo $comment['Comment']['desc']; ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($comment['Page']['slug'], array('admin' => false, 'controller' => 'pages', 'action' => 'view', $comment['Page']['slug'])); ?>
                </td>
                <td><?php echo $comment['Comment']['created']; ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Js->link(__d('cms', 'Usuń'), array('action' => 'delete', $comment['Comment']['id']), array('update' => '#display_' . $comment['Comment']['id'])); ?>
                    <?php echo $this->Js->link(__d('cms', 'Akceptuj'), array('action' => 'akcept', $comment['Comment']['id']), array('update' => '#display_' . $comment['Comment']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php echo $this->element('cms/paginator'); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'zaakceptowane'), array('action' => 'active')); ?></li>
    </ul>
</div>
<?php echo $this->Js->writeBuffer(); ?>