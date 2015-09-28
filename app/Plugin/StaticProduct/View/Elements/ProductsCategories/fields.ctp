<fieldset>
    <legend><?php echo __d('cms', 'Product Category Data'); ?></legend>
    <?php
    echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
    echo $this->FebForm->file('img', array('label' => __d('cms', 'Grafika').' (450px x 430px)'));
    echo $this->Form->input('link', array('label' => __d('cms', 'Link')));
    ?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Ustawienia html');?></legend>
    <?php echo $this->Form->input('metakey', array('label' => __d('cms', 'Słowa kluczowe'), 'type' => 'textarea'));?>
    <?php echo $this->Form->input('metadesc', array('label' => __d('cms', 'Opis strony'), 'type' => 'textarea'));?>
</fieldset>