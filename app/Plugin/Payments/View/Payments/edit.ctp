<?php $this->set('title_for_layout', __d('cms', 'Adding').' &bull; '.__d('cms', 'Payments')); ?><h2><?php echo __d('cms', 'Edit Payment'); ?></h2>

<div class="payments form">
    <?php echo $this->Form->create('Payment'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('Payments/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('Payment.id')), array('outter'=>'<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('Payment.title'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Payments'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
