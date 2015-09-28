<?php $this->set('title_for_layout', __d('cms', 'Editing').' &bull; '.__d('cms', 'Payments')); ?><h2><?php echo __d('cms', 'Add Payment'); ?></h2>

<div class="payments form">
    <?php echo $this->Form->create('Payment'); ?>
	<?php echo $this->Element('Payments/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Payments'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
