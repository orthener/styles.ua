<div class="customers form">
    <?php echo $this->Form->create('Customer'); ?>
    <?php echo $this->Element('Customers/fields', array('desc' => __d('cms', 'Admin Add Customer'))); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Customers'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Users'), array('controller' => 'users', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New User'), array('controller' => 'users', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'List Addresses'), array('controller' => 'addresses', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New Address'), array('controller' => 'addresses', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'List Invoice Identities'), array('controller' => 'invoice_identities', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New Invoice Identity'), array('controller' => 'invoice_identities', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'List Orders'), array('controller' => 'orders', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New Order'), array('controller' => 'orders', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
