<?php $this->set('title_for_layout', __d('cms', 'List').' &bull; '.__d('cms', 'News Categories')); ?><div class="newsCategories index">
     
    <?php echo $this->Element('NewsCategories/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
	<h3><?php echo __d('cms', 'Actions'); ?></h3>
	<ul>
		<?php echo $this->Permissions->link(__d('cms', 'New News Category'), array('action' => 'add'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List News'), array('controller' => 'news', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New News'), array('controller' => 'news', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
	</ul>
</div>
