<?php $title = sprintf(__d('cms', 'Edycja kursu: %s :: Kursy walut :: Administracja', true), $this->Form->value('CurrencyExchangeRate.currency')); ?>
<?php $this->set('title_for_layout', $title); ?>
<div class="currencyExchangeRates form">
	<h2><?php printf(__d('cms', 'Edycja kursu: %s', true), $this->Form->value('CurrencyExchangeRate.currency')); ?></h2>
<?php echo $this->Form->create('CurrencyExchangeRate');?>
	<fieldset>
 		<legend><?php __('Edytuj kurs waluty'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('currency', array('class' => 'readonly', 'readonly' => true, 'label' => __d('cms', 'Kod waluty', true)));
		echo $this->Form->input('currency_name', array('class' => 'readonly', 'readonly' => true, 'label' => __d('cms', 'Waluta', true)));
		echo $this->Form->input('value');
//		echo $this->Form->input('deleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

<?php //echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CurrencyExchangeRate.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CurrencyExchangeRate.id'))); ?>
		<li><?php echo $this->Html->link(__('Kursy walut', true), array('action' => 'index'));?></li>
	</ul>
</div>