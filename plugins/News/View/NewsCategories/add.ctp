<?php $this->set('title_for_layout', __d('cms', 'Editing') . ' &bull; ' . __d('cms', 'News Categories')); ?><h2><?php echo __d('cms', 'Add News Category'); ?></h2>

<div class="newsCategories form">
    <?php echo $this->Form->create('NewsCategory'); ?>
    <?php echo $this->Element('NewsCategories/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List News Categories'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List News'), array('controller' => 'news', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New News'), array('controller' => 'news', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
