<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->Form->input('user_plugin', array('label' => __d('cms', 'User Plugin')));
		echo $this->Form->input('user_model', array('label' => __d('cms', 'User Model')));
		echo $this->Form->input('user_row_id', array('label' => __d('cms', 'User Row Id')));
		echo $this->Form->input('related_plugin', array('label' => __d('cms', 'Related Plugin')));
		echo $this->Form->input('related_model', array('label' => __d('cms', 'Related Model')));
		echo $this->Form->input('related_row_id', array('label' => __d('cms', 'Related Row Id')));
		echo $this->Form->input('client_ip', array('label' => __d('cms', 'Client Ip')));
		echo $this->Form->input('payment_gate', array('label' => __d('cms', 'Payment Gate')));
		echo $this->Form->input('title', array('label' => __d('cms', 'Title')));
		echo $this->Form->input('amount', array('label' => __d('cms', 'Amount')));
		echo $this->Form->input('payment_date', array('label' => __d('cms', 'Payment Date')));
		echo $this->Form->input('status', array('label' => __d('cms', 'Status')));
		echo $this->Form->input('email_confirm', array('label' => __d('cms', 'Email Confirm')));
		echo $this->Form->input('platnosci_status', array('label' => __d('cms', 'Platnosci Status')));
		echo $this->Form->input('platnosci_pay_type', array('label' => __d('cms', 'Platnosci Pay Type')));
		echo $this->Form->input('platnosci_amount', array('label' => __d('cms', 'Platnosci Amount')));
		echo $this->Form->input('platnosci_desc', array('label' => __d('cms', 'Platnosci Desc')));
		echo $this->Form->input('platnosci_desc2', array('label' => __d('cms', 'Platnosci Desc2')));
		echo $this->Form->input('platnosci_firstname', array('label' => __d('cms', 'Platnosci Firstname')));
		echo $this->Form->input('platnosci_lastname', array('label' => __d('cms', 'Platnosci Lastname')));
	?>
</fieldset>
