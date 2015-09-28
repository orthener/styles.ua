<?php $this->set('title_for_layout', __d('cms', 'Adding').' &bull; '.__d('cms', 'Permission Categories')); ?><h2><?php echo __d('cms', 'Edit Permission Category'); ?></h2>

<div class="permissionCategories form">
    <?php echo $this->Form->create('PermissionCategory'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('PermissionCategories/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('PermissionCategory.id')), array('outter'=>'<li>%s</li>'), __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('PermissionCategory.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Permission Categories'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Permission Groups'), array('plugin' => false, 'controller' => 'permission_groups', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Permission Group'), array('plugin' => false, 'controller' => 'permission_groups', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
