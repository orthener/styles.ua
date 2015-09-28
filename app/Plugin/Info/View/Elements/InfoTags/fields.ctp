<fieldset>
    <legend><?php echo __d('cms', 'Info Tag Data'); ?></legend>
    <?php
    echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
    echo $this->Form->input('count', array('label' => __d('cms', 'Count')));
    ?>
</fieldset>
