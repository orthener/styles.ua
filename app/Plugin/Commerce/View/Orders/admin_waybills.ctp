
<h2><?php echo __d('cms', 'Listy przewozowe');?></h2>

<div>
    <h2><?php echo 'KE-X:'; ?></h2>
    <?php echo __d('cms', 'Generuj listy przewozowe do zamówień, dla których wybrano wysyłkę za pomocą K-EX:'); ?>
    <?php echo $this->Form->create('Order', array('id' => 'generateWaybillsForm', 'url' => array('action' => 'waybills', 'ext' => 'csv'))) ?>
    <?php echo $this->Form->hidden('Order.order_ids'); ?>
    <?php echo $this->Form->hidden('Order.shipment_method_id', array('value' => '19')); ?>
    <?php echo $this->Form->submit('Generuj!'); ?>
    <?php echo $this->Form->end(); ?>
</div>
