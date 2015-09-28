<?php echo $this->Form->create('PermissionGroup'); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Permission Group Data'); ?></legend>
        <?php
            echo $this->Form->input('permission_category_id', array('default' => $permission_category_id));
            echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
        ?>
    </fieldset>         
<?php echo $this->Form->end(__d('cms', 'Submit')); ?>