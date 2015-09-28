<div class="shipmentMethods index">

    <?php echo $this->Element('ShipmentMethods/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'New Shipment Method'), array('action' => 'add'), array('outter' => '<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Shipment Method Configs'), array('controller' => 'shipment_method_configs', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New Shipment Method Config'), array('controller' => 'shipment_method_configs', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
