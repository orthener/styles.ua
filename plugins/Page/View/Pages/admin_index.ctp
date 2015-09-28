<div class="categories index">
    <?php echo $this->Filter->formCreate($filtersSettings, array('legend' => __d('cms', 'Filtruj'), 'submit' => __d('cms', 'Filtruj'))); ?>
    <?php $this->Paginator->options(array('url' => $filtersParams)); ?>
        <?php echo $this->element('Pages/table_index'); ?>
        <?php echo $this->element('cms/paginator'); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'Dodaj pozycję'), array('action' => 'add')); ?></li>
    </ul>
</div>