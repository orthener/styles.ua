<?php if (!empty($permission)) { ?>
    <?php $linkParams = array('onClick' => 'return false;'); ?>
    <p><?php echo __d('cms', 'Podgląd uprawnienia:'); ?></p>
    <ul>
        <li><?php echo __d('cms', "ID uprawnienia: ").$this->Html->link($permission['Permission']['id'],'#', $linkParams); ?></li>
        <li><?php echo __d('cms', "Nazwa uprawnienia: ").$this->Html->link($permission['Permission']['name'],'#', $linkParams); ?></li>
        <li>
        <?php if (!empty($permissionCategories[$permission['PermissionGroup']['permission_category_id']])) { ?>
            <?php echo __d('cms', "Grupa uprawnienia: "). $this->Html->link($permissionCategories[$permission['PermissionGroup']['permission_category_id']], '#', $linkParams).' / '. $this->Html->link($permission['PermissionGroup']['name'], '#', $linkParams); ?>
        <?php } else { ?>
            <?php echo __d('cms', "Grupa uprawnienia: Uprawnienie nie powiazane") ?>
        <?php } ?>
        </li>
    </ul>
    <?php //debug($permission); ?>
    <?php //debug($permissionCategories); ?>
<?php
} else {
    echo __d('cms', 'Uprawnienie jeszcze nie istnieje, tym samym nie zostało powiązane do żadnej z grup. Podwójne kliknięcie powiąze je z aktywną grupą.');
} ?>