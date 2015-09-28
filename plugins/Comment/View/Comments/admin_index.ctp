<?php if ($activeMode == 0): ?>
    <h2><?php echo __d('cms', 'Komentarze do moderacji'); ?></h2>
<?php elseif ($activeMode == 1): ?>
    <h2><?php echo __d('cms', 'Komentarze zaakceptowane'); ?></h2>
<?php endif; ?>

<?php echo $this->element('indexsort', array('tree' => $tree)); ?>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'Komentarze do moderacji'), array('action' => 'index', 0), array('outter' => '<li>%s</li>')); ?>
        <?php echo $this->Permissions->link(__d('cms', 'Komentarze zaakceptowane'), array('action' => 'index', 1), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>