<?php $this->set('title_for_layout', __d('cms', 'Komentarze do moderacji')); ?>
<div class="comments index">
    <h2><?php echo __d('cms', 'Komentarze zaakceptowane'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('name', 'Autor'); ?></th>
            <th><?php echo $this->Paginator->sort('desc', 'Treść'); ?></th>
            <th><?php echo $this->Paginator->sort('news_id', 'Wpis'); ?></th>
            <th><?php echo $this->Paginator->sort('created', 'Utworzono'); ?></th>
            <th class="actions"><?php echo __d('cms', 'Opcje'); ?></th>
        </tr>
        <?php $i = 0; ?>
        <?php //debug($comments[0]); ?>
        <?php foreach ($comments as $comment): ?>
            <?php $class = ($i++ % 2 == 0) ? $class = ' class="altrow"' : null; ?>
            <tr <?php echo $class; ?> id="display_<?php echo $comment['Comment']['id']; ?>">
                <td><?php echo $comment['Comment']['name']; ?></td>
                <td><?php echo $comment['Comment']['desc']; ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($comment['News']['title'], array('type' => 'blog', 'admin' => false, 'controller' => 'news', 'action' => 'view', $comment['News']['slug'])); ?>
                </td>
                <td><?php echo $comment['Comment']['created']; ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Js->link(__d('cms', 'Usuń'), array('action' => 'delete', $comment['Comment']['id']), array('update' => '#display_' . $comment['Comment']['id'], 'confirm' => 'Czy napewno chcesz usunąć ten komentarz? Jest on już zaakceptowany.')); ?>
                    <?php //echo $this->Js->link(__d('cms', 'Akceptuj'), array('action' => 'akcept', $comment['Comment']['id']), array('update'=>'#display_'.$comment['Comment']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php echo $this->element('cms/paginator'); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'do akceptacji'), array('action' => 'index')); ?></li>
    </ul>
</div>
<?php echo $this->Js->writeBuffer(); ?>