<?php $this->set('title_for_layout', __d('cms', 'Adding').' &bull; '.__d('cms', 'News Categories')); ?><h2><?php echo __d('cms', 'Edit News Category'); ?></h2>

<div class="newsCategories form">
    <?php echo $this->Form->create('NewsCategory'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('NewsCategories/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('NewsCategory.id')), array('outter'=>'<li>%s</li>'), __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('NewsCategory.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List News Categories'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List News'), array('controller' => 'news', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New News'), array('controller' => 'news', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
