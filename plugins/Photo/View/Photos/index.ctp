<div class="photos index">
     
    <?php echo $this->Element('Photos/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
	<h3><?php echo __d('cms', 'Actions'); ?></h3>
	<ul>
		<?php echo $this->Permissions->link(__d('cms', 'New Photo'), array('action' => 'add'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Offers'), array('plugin' => false, 'controller' => 'offers', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Offer'), array('plugin' => false, 'controller' => 'offers', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'List Pages'), array('plugin' => false, 'controller' => 'pages', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Page'), array('plugin' => false, 'controller' => 'pages', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
	</ul>
</div>
