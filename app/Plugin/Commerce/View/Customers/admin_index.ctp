<div class="customers index">
    <div class="filtruj clearfix">
        <?php echo $this->Filter->formCreate($filtersSettings, array('legend' => __d('cms', 'Filtry'), 'submit' => __d('cms', 'szukaj'))); ?>
        <?php $this->Paginator->options(array('url' => $filtersParams)); ?>
    </div>
    <?php echo $this->Element('Customers/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'New Customer'), array('action' => 'add'), array('outter' => '<li>%s</li>')); ?>
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
