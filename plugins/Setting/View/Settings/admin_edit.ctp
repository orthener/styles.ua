<div class="settings form">
    <h2><? echo $title_for_layout; ?></h2>
    <?php echo $this->Form->create('Setting'); ?>
    <fieldset>
        <div class="tabs">

            <?php echo $this->Form->input('id'); ?>
            <?php echo $this->element('Setting/fields'); ?>
        </div>
    </fieldset>
    <div class="buttons">
        <?php
        echo $this->Form->end(__d('cms', 'Zapisz'));
        echo $this->Html->link(__d('cms', 'Anuluj'), array(
            'action' => 'index',
                ), array(
            'class' => 'cancel button',
        ));
        ?>
    </div>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Lista ustawień'), array('action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'Dodaj ustawienie'), array('action'=>'add')); ?> </li>
	</ul>
</div>