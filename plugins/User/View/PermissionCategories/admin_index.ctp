<?php $this->set('title_for_layout', __d('cms', 'List').' &bull; '.__d('cms', 'Permission Categories')); ?><div class="permissionCategories index">
     
    <?php echo $this->Element('PermissionCategories/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
	<h3><?php echo __d('cms', 'Actions'); ?></h3>
	<ul>
		<?php echo $this->Permissions->link(__d('cms', 'New Permission Category'), array('action' => 'add'), array('outter'=>'<li>%s</li>')); ?>
        <?php echo $this->Permissions->link(__d('cms', 'Zarzadzanie akcjami uprawnień'), array('controller' => 'permission_groups', 'action' => 'summary'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New Permission Group'), array('plugin' => false, 'controller' => 'permission_groups', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
	</ul>
</div>
