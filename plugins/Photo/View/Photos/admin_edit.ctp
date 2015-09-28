<div class="photos form">
    <?php echo $this->Form->create('Photo', array('type' => 'file')); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('Photos/fields', array('desc' =>  __d('cms', 'Admin Edit Photo'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('plugin' => false, 'action' => 'delete', $this->Form->value('Photo.id')), array('outter'=>'<li>%s</li>'), __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('Photo.title'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Photos'), array('plugin' => false, 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Offers'), array('plugin' => false, 'controller' => 'offers', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Offer'), array('plugin' => false, 'controller' => 'offers', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
<?php //echo $this->Permissions->link(__d('cms', 'List Pages'), array('plugin' => false, 'controller' => 'pages', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Page'), array('plugin' => false, 'controller' => 'pages', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
