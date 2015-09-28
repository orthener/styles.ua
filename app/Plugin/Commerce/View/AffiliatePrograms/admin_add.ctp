<div class="affiliatePrograms form">
    <?php echo $this->Form->create('AffiliateProgram'); ?>
	<?php echo $this->Element('AffiliatePrograms/fields', array('desc' => __d('cms', 'Admin Add Affiliate Program'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Affiliate Programs'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
