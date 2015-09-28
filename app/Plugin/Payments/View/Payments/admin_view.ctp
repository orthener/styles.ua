<div class="payments view">
<h2><?php  echo __('Payment');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'User Plugin'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['user_plugin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'User Model'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['user_model']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'User Row Id'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['user_row_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Related Plugin'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['related_plugin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Related Model'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['related_model']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Related Row Id'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['related_row_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Client Ip'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['client_ip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Payment Gate'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['payment_gate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Title'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Amount'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Payment Date'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['payment_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Status'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Email Confirm'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['email_confirm']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Platnosci Status'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['platnosci_status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Platnosci Pay Type'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['platnosci_pay_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Platnosci Amount'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['platnosci_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Platnosci Desc'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['platnosci_desc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Platnosci Desc2'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['platnosci_desc2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Platnosci Firstname'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['platnosci_firstname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Platnosci Lastname'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['platnosci_lastname']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Payment'), array('action' => 'edit', $payment['Payment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Payment'), array('action' => 'delete', $payment['Payment']['id']), null, __('Are you sure you want to delete # %s?', $payment['Payment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Payments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payment'), array('action' => 'add')); ?> </li>
	</ul>
</div>
