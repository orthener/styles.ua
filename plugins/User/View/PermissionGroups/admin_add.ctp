<?php $this->set('title_for_layout', __d('cms', 'Editing').' &bull; '.__d('cms', 'Permission Categories')); ?><h2><?php echo __d('cms', 'Admin Add Permission Category'); ?></h2>

<div class="permissionGroup form">
    <?php echo $this->Form->create('PermissionGroup'); ?>
	<?php echo $this->Element('PermissionGroups/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Permission Categories'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Permission Groups'), array('plugin' => false, 'controller' => 'permission_groups', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Permission Group'), array('plugin' => false, 'controller' => 'permission_groups', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
