<div class="invoiceIdentities form">
    <?php echo $this->Form->create('InvoiceIdentity'); ?>
	<?php echo $this->Element('InvoiceIdentities/fields', array('desc' => __d('cms', 'Admin Add Invoice Identity'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Invoice Identities'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Customers'), array('controller' => 'customers', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Customer'), array('controller' => 'customers', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
<?php //echo $this->Permissions->link(__d('cms', 'List Regions'), array('controller' => 'regions', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Region'), array('controller' => 'regions', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
<?php //echo $this->Permissions->link(__d('cms', 'List Countries'), array('controller' => 'countries', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New Country'), array('controller' => 'countries', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
