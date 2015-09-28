<?php $this->set('title_for_layout', __d('cms', 'Odbiorcy mailingu')); ?>
<div class="newsletters index">
    <?php echo $this->element('Newsletters/table_index'); ?>
    <?php echo $this->element('cms/paginator'); ?>
</div>