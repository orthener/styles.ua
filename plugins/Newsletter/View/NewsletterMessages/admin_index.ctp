<?php $this->set('title_for_layout', __d('cms', 'Lista wiadomości » Newsletter')); ?>
<div class="newsletterMessages index">
    <?php echo $this->element('NewsletterMessages/table_index'); ?>
    <?php echo $this->element('cms/paginator'); ?>
</div>
<div class="actions">
<br />
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Nowa wiadomość newslettera'), array('action' => 'add')); ?></li>
	</ul>
</div>