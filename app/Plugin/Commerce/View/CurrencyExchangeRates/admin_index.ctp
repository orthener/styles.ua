<div class="currencyExchangeRates index">
			<?php if($deleted == 0): ?>
	<h2><?php __d('cms', 'Kursy walut');?></h2>
<?php $this->set('title_for_layout', __d('cms', 'Kursy walut :: Administracja', true)); ?>
			<?php else: ?>
	<h2><?php __d('cms', 'Kursy walut (historia zmian)');?></h2>
<?php $this->set('title_for_layout', __d('cms', 'Kursy walut (historia zmian) :: Administracja', true)); ?>
			<?php endif; ?>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Wartości historyczne', true), array(1)); ?></li>
		<li><?php echo $this->Html->link(__('Wartości bieżące', true), array('action' => 'index')); ?></li>
	</ul>
</div>
<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('currency', __d('cms', 'Waluta', true));?></th>
			<th><?php echo __d('cms', 'Wartość dla 100zł'); ?></th>
			<th><?php echo __d('cms', 'Wartość w zł'); ?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<?php if($deleted): ?>
			<th><?php echo $this->Paginator->sort('deleted');?></th>
			<?php else: ?>
			<th class="actions"><?php echo __('Actions');?></th>
			<?php endif; ?>
	</tr>
	<?php
	$i = 0;
	foreach ($currencyExchangeRates as $currencyExchangeRate):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $currencyExchangeRate['CurrencyExchangeRate']['currency']; ?>&nbsp;</td>
		<td><?php echo sprintf($currencyExchangeRate['CurrencyExchangeRate']['price_str'], 100/$currencyExchangeRate['CurrencyExchangeRate']['value']); ?>&nbsp;</td>
		<td><?php echo sprintf("%.4f zł", $currencyExchangeRate['CurrencyExchangeRate']['value']).' = '.sprintf($currencyExchangeRate['CurrencyExchangeRate']['price_str'], 1); ?>&nbsp;</td>
		<td><?php echo $currencyExchangeRate['CurrencyExchangeRate']['created']; ?>&nbsp;</td>
			<?php if($deleted): ?>
		<td><?php echo $currencyExchangeRate['CurrencyExchangeRate']['deleted']; ?>&nbsp;</td>
			<?php else: ?>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $currencyExchangeRate['CurrencyExchangeRate']['id'])); ?>
		</td>
			<?php endif; ?>
	</tr>
<?php endforeach; ?>
	</table>
    
    <?php echo $this->Element('cms/paginator'); ?>

</div>
