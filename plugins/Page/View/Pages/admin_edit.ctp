<?php
if (!empty($add_params)):
    $this->set('title_for_layout', __d('cms', 'Edycja pozycji » Realizacje'));
else:
    $this->set('title_for_layout', __d('cms', 'Edycja pozycji » Podstrony'));
endif;
?>

<div class="products form">
    <?php echo $this->Form->create('Page', array('type' => 'file')); ?>

    <?php echo $this->element('Pages/fields'); ?>

    <?php echo $this->Form->input('id'); ?>

<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'Usuń'), array('action' => 'delete', $this->Form->value('Page.id')), null, __d('cms', 'Czy napewno chcesz bezpowrotnie usunąć # %s?', $this->Form->value('Page.tytul'))); ?></li>
        <li><?php echo $this->Html->link(__d('cms', 'Lista stron'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__d('cms', 'Edytuj zdjęcia'), array('controller' => 'page_photos', 'action' => 'editindex', $this->Form->value('Page.id'))); ?></li>
    </ul>
</div>