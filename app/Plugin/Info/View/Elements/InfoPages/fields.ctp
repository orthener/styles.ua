
<fieldset>
    <legend><?php echo __d('cms', 'Article Page Data'); ?></legend>
    <?php
    //echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
    echo $this->Form->input('title', array('label' => __d('cms', 'Title')));
    echo $this->Form->input('category_id', array('label' => __d('cms', 'Kategoria')));
 //   $opt = array(0 => 'Aktualność', 1 => 'Blog');
 //   echo $this->Form->input('on_blog', array('label' => false, 'options' => $opt, 'type' => 'radio', 'default' => 0, 'legend' => false, 'separator' => ''));
    echo $this->Form->input('publication_date', array('label' => __d('cms', 'Data publikacji'), 'type' => 'text'));
    ?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Content') ?></legend>
    <?php echo $this->FebTinyMce4->input('content', array('label' => false), 'full'); ?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Tags'); ?></legend>
    <?php echo $this->Form->input('tags', array('type' => 'textarea', 'label' => false, 'after' => 'Tagi oddzielone przecinkami')); ?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Kod reklamy'); ?></legend>
    <?php echo $this->Form->input('ad_code', array('type' => 'textarea', 'label' => false, 'after' => '')); ?>
</fieldset>
<script>
    $('#InfoPagePublicationDate').datepicker();
</script>