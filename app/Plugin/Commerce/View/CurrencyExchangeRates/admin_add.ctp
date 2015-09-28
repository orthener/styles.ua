<div class="currencyExchangeRates form">
<?php echo $this->Form->create('CurrencyExchangeRate');?>
	<fieldset>
 		<legend><?php __('Admin Add Currency Exchange Rate'); ?></legend>
	<?php
		echo $this->Form->input('currency');
		echo $this->Form->input('currency_name');
		echo $this->Form->input('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Currency Exchange Rates', true), array('action' => 'index'));?></li>
	</ul>
</div>