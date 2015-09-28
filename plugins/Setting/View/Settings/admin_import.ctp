<div class="settings form">
    
    <div class="output">
        <?php echo $this->FebHtml->printArray($saveOutput); ?>
    </div>
    
    <h2><? echo $title_for_layout; ?></h2>
    <?php echo $this->Form->create('Setting'); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Ustawienia z pliku settings.yml'); ?></legend>
    <?php echo $this->Form->input('import_area', array('type' => 'textarea', 'rows' => 50, 'default' => $settings));?>
    </fieldset>
    <?php echo $this->Form->end(__d('cms', 'Importuj'));  ?>      
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Lista ustawień'), array('action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'Dodaj ustawienie'), array('action'=>'add')); ?> </li>
	</ul>
</div>