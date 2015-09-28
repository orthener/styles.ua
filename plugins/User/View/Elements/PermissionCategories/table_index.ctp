<h2><?php echo __d('cms', 'Permission Categories'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name')); ?></th>
            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
            <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($permissionCategories as $permissionCategory):
            ?>
            <tr data-id="<?php echo $permissionCategory['PermissionCategory']['id']; ?>">
                <td><?php echo h($permissionCategory['PermissionCategory']['name']); ?>&nbsp;</td>
                <td><?php echo $this->FebTime->niceShort($permissionCategory['PermissionCategory']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($permissionCategory['PermissionCategory']['modified']); ?></td>
                <td class="actions">
                    <?php //echo $this->Permissions->link(__d('cms', 'View'), array('action' => 'view', $permissionCategory['PermissionCategory']['id'])); ?>
                    <?php echo $this->Permissions->link(__d('cms', 'Edit'), array('action' => 'edit', $permissionCategory['PermissionCategory']['id'])); ?>
                    <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $permissionCategory['PermissionCategory']['id']), null, __d('cms', 'Usuwanie kategorii uprawnień wiaże się z licznymi powiązaniami masz świadomość tego, że trzeba przeładować ręcznie tabelę uprawnień?', $permissionCategory['PermissionCategory']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>