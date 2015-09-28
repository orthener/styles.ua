<div class="affiliatePrograms form">
    <?php echo $this->Form->create('AffiliateProgram'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('AffiliatePrograms/fields', array('desc' =>  __d('cms', 'Admin Edit Affiliate Program'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('AffiliateProgram.id')), array('outter'=>'<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('AffiliateProgram.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Affiliate Programs'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
