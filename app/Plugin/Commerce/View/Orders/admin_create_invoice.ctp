<div class="orders form">
<?php echo $this->Form->create('Invoice', array('url' => $this->here));?>
	<fieldset>
 		<legend><?php echo __d('commerce', 'Wystaw Fakturę'); ?></legend>
 		
 		<p>
    <?php __d('commerce', 'Faktura zostanie wystawiona zgodnie z danymi zawartymi w zamówieniu. 
    Przed wystawieniem faktury upewnij się, że dane w zamówieniu są prawidłowe'); ?>
   </p>
 		
	<?php
		echo $this->Form->input('invoice_date', array('type' => 'text', 'label' => __d('commerce', 'Data wystawienia / Data sprzedaży')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
