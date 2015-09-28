<?php $this->set('title_for_layout', __d('cms', 'Adding') . ' &bull; ' . __d('cms', 'News')); ?><h2><?php echo __d('cms', 'Admin Edit Blog'); ?></h2>

<div class="news form">
    <?php echo $this->Form->create('News'); ?>
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Element('News/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('News.id')), array('outter' => '<li>%s</li>'), __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('News.title'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List blog articles'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Users'), array('plugin' => false, 'controller' => 'users', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New User'), array('plugin' => false, 'controller' => 'users', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
