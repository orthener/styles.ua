<?php echo $this->Form->create('PermissionGroup'); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Permission Group Data'); ?></legend>
        <?php
            echo $this->Form->hidden('id');
            echo $this->Form->input('permission_category_id');
            echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
        ?>
    </fieldset> 
    <div id="permissionsWithGroup"></div>
<?php echo $this->Form->end(__d('cms', 'Submit')); ?>