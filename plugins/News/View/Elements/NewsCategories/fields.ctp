<fieldset>
    <legend><?php echo __d('cms', 'Blog Category Data'); ?></legend>
    <?php echo $this->Form->input('name', array('label' => __d('cms', 'Name'))); ?>
    <?php echo $this->Form->input('is_promoted', array('label' => __d('cms', 'Czy promować kategorię')));?>
    <?php echo $this->Form->hidden('slug');?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Kody reklam zewnętrznego reklamodawcy');?></legend>
    <?php echo $this->Form->input('ad_code', array('label' => __d('cms', 'Reklama nr 1'), 'type' => 'textarea'));?>
    <?php echo $this->Form->input('ad_code2', array('label' => __d('cms', 'Reklama nr 2'), 'type' => 'textarea'));?>
    <?php echo $this->Form->input('head_code', array('label' => __d('cms', 'Kod w sekcji head'), 'type' => 'textarea'));?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Ustawienia html');?></legend>
    <?php echo $this->Form->input('metakey', array('label' => __d('cms', 'Słowa kluczowe'), 'type' => 'textarea'));?>
    <?php echo $this->Form->input('metadesc', array('label' => __d('cms', 'Opis strony'), 'type' => 'textarea'));?>
</fieldset>