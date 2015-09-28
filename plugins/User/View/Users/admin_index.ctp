<?php $this->set('title_for_layout', __d('cms', 'Users')); ?>
<div class="users index">
    <?php echo $this->Filter->formCreate($filtersSettings, array('legend' => __d('cms', 'Filtruj'), 'submit' => __d('cms', 'Filtruj'))); ?>
    <?php $this->Paginator->options(array('url' => $filtersParams)); ?>
    <?php echo $this->element('Users/table_index'); ?>
    <?php echo $this->element('cms/paginator'); ?>
</div>
<div class="actions" style="padding:5px 0">
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'Dodaj użytkownika'), array('action' => 'add')); ?></li>
    </ul>
</div>