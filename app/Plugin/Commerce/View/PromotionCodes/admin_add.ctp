<?php $this->set('title_for_layout', __d('cms', 'Editing').' &bull; '.__d('cms', 'Promotion Codes')); ?><h2><?php echo __d('cms', 'Admin Add Promotion Code'); ?></h2>

<div class="promotionCodes form">
    <?php echo $this->Form->create('PromotionCode'); ?>
	<?php echo $this->Element('PromotionCodes/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Promotion Codes'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
