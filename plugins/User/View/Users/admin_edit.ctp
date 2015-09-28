<div class="users form clearfix">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Edytuj użytkownika'); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('active', array('label' => __d('cms', 'Aktywne')));
        echo $this->Form->input('name', array('label' => __d('cms', 'Nazwa użytkownika')));
        echo $this->Form->input('email');
//        if (!$cantEditGroup) {
            echo $this->Form->input('Group', array('label' => __d('cms', 'Grupa')));
//        }
        ?>
    </fieldset>
<!--    <div id="UserPermissions">
        <fieldset>
            <legend><?php // echo __d('cms', 'Uprawnienia'); ?></legend>
            <?php 
//                echo $this->Form->input('PermissionGroup.PermissionGroup', array('label' => false, 'multiple' => 'checkbox', 'div' => array('class' => 'input select multiple')));
            ?>
        </fieldset>
    </div>-->
    <?php echo $this->Form->end(__d('cms', 'Zapisz')) ?>
</div>

<script type="text/javascript">
    $(function(){
        
        var refreshCheckbox = function(list) {
            $('#UserPermissions').find('input').removeAttr('disabled checked');
            $(list).each(function(index, perm){
                $('#PermissionGroupPermissionGroup'+perm).attr('disabled', 'disabled').attr('checked', 'checked');
            });
        }
        
        $('#GroupGroup').change(function(){
            $.ajax({
                url: '<?php echo $this->Html->url(array('action' => 'permission_checkboxes')); ?>',
                dataType: 'json',
                type: 'POST',
                data: $('#GroupGroup').serialize(),
                success: function(json) {
                    refreshCheckbox(json);
                }
            });
        })
    });
</script>

<div class="users form clearfix">
    <?php echo $this->Form->create('User', array('type' => 'file')); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Edycja Avatar-a'); ?></legend>
        <?php echo $this->Form->input('avatar', array('type' => 'file', 'label' => false)); ?>
        <?php
        //crop image
        $imageOptions = array('width' => 100, 'height' => 100, 'x' => $user['User']['x'], 'y' => $user['User']['y']);
        echo $this->Image->thumb('/files/user/' . $user['User']['avatar'], $imageOptions, array('onclick' => 'editCrop();'), true);
        echo $this->Jcrop->edit('User', 'avatar', $user['User']['id']);
        ?>
    </fieldset>
    <?php echo $this->Form->end(__d('cms', 'Zapisz')); ?>
</div>

<div class="users form clearfix">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Zmień hasło'); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('pass', array('label' => __d('cms', 'Hasło'), 'type' => 'password', 'value' => ''));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__d('cms', 'Zapisz')); ?>
</div>

<div class="actions">
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'Szczegóły użytkownika'), array('action' => 'view', $this->Form->value('User.id')), array('outter' => '<li>%s</li>')); ?>
        <?php if ($this->Form->value('User.date_locked')) { ?>
            <?php echo $this->Permissions->postLink(__d('cms', 'Odblokuj %s', 'użytkownika'), array('action' => 'unlock', $this->Form->value('User.id')), array('outter' => '<li>%s</li>'), __d('cms', 'Jesteś pewien, że chcesz odblokować użytkownika "%s"?', $this->Form->value('User.name'), 0)); ?>
        <?php } ?>        
        <?php echo $this->Permissions->link(__d('cms', 'Usuń użytkownika'), array('action' => 'delete', $this->Form->value('User.id')), array('outter' => '<li>%s</li>'), __d('cms', 'Jesteś pewien, że chcesz usunąć użytkownika "%s"?', $this->Form->value('User.email'))); ?>
        <?php echo $this->Permissions->link(__d('cms', 'Lista użytkowników'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>



