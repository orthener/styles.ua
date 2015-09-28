<h2><?php echo __d('cms', 'Użytkownicy'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('name', __d('cms', 'Nazwa')); ?></th>
        <th><?php echo $this->Paginator->sort('email', __d('cms', 'Email')); ?></th>
        <th><?php echo $this->Paginator->sort('active', __d('cms', 'Aktywny')); ?></th>
        <th><?php echo __d('cms', 'Grupy'); ?></th>
        <th><?php echo $this->Paginator->sort('created', __d('cms', 'Utworzono')); ?></th>
        <th><?php echo $this->Paginator->sort('modified', __d('cms', 'Ostatnie logowanie')); ?></th>
        <th class="actions"><?php echo  __d('cms', 'Akcje'); ?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($users as $user):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
        ?>
        <tr<?php echo $class; ?>>
            <td><?php echo $user['User']['name']; ?>&nbsp;</td>
            <td><?php echo $user['User']['email']; ?>&nbsp;</td>
            <td><?php echo $user['User']['active']; ?>&nbsp;</td>
            <td><?php foreach($user['Group'] AS $group){ echo $group['name'].'<br />'; } ?>&nbsp;</td>
            <td><?php echo $user['User']['created']; ?>&nbsp;</td>
            <td><?php echo $user['User']['last_login']; ?>&nbsp;</td>
            <td class="actions">
                <?php foreach ($user['Group'] as $userGroup) :?>
                    <?php if($userGroup['alias'] == 'admins' || $userGroup['alias'] == 'superAdmins'  || $userGroup['alias'] == 'editors' ): ?>
                        <?php echo $this->Permissions->link(__d('cms', 'Zaloguj jako'), array('action' => 'login_like', $user['User']['id'])); ?>
                        <?php break;?>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php echo $this->Html->link(__d('cms', 'Szczegóły'), array('action' => 'view', $user['User']['id'])); ?>
                <?php echo $this->Permissions->link(__d('cms', 'Edytuj'), array('action' => 'edit', $user['User']['id'])); ?>
                <?php echo $this->Permissions->link(__d('cms', 'Usuń'), array('action' => 'delete', $user['User']['id']), null, __d('cms', 'Jesteś pewien, że chcesz usunąć użytkownika "%s"?', $user['User']['email'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>