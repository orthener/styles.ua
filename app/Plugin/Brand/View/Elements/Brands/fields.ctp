<fieldset>
    <legend><?php echo __d('cms', 'Brand Data'); ?></legend>
    <?php
    echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
    echo $this->FebForm->file('img', array('type' => 'file', 'label' => __d('cms', 'Img')));
    echo $this->FebForm->file('img2', array('type' => 'file', 'label' => __d('cms', 'Img2')));
    echo $this->Form->input('url', array('label' => __d('cms', 'Url')));
    ?>
</fieldset>
<fieldset class="textareaFull">
    <legend><?php echo __d('cms', 'Opis'); ?></legend>
    <?php echo $this->FebTinyMce4->input('desc', array('label' => false), 'full', array('width' => 718)); ?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Ustawienia html');?></legend>
    <?php echo $this->Form->input('metakey', array('label' => __d('cms', 'Słowa kluczowe'), 'type' => 'textarea'));?>
    <?php echo $this->Form->input('metadesc', array('label' => __d('cms', 'Opis strony'), 'type' => 'textarea'));?>
</fieldset>
