<?php $this->set('title_for_layout', __d('cms', 'Adding').' &bull; '.__d('cms', 'Promotion Codes')); ?><h2><?php echo __d('cms', 'Admin Edit Promotion Code'); ?></h2>

<div class="promotionCodes form">
    <?php echo $this->Form->create('PromotionCode'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('PromotionCodes/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('PromotionCode.id')), array('outter'=>'<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('PromotionCode.code'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Promotion Codes'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
