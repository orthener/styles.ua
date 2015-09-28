<div class="users view">
    <h2><?php echo __d('cms', 'Konto użytkownika'); ?>: <?php echo $user['User']['email']; ?> (<?php echo $user['User']['name']; ?>)</h2>
    <dl><?php
        $i = 0;
        $class = ' class="altrow"';
    ?>
        <dt<?php if ($i % 2 == 0) echo $class; ?>><?php echo __d('cms', 'Aktywne'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
            <?php echo $user['User']['active']; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class; ?>><?php echo __d('cms', 'Data utworzenia (modyfikacji)'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class; ?>>
            <?php echo $user['User']['created'] . ' (' . $user['User']['modified'] . ')'; ?>
            &nbsp;
        </dd>
    </dl>

    <h2><?php echo __d('cms', 'Użytkownik należy do grup'); ?></h2>
    <?php if (!empty($user['Group'])): ?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                <th><?php echo __d('cms', 'Id'); ?></th>
                <th><?php echo __d('cms', 'Nazwa'); ?></th>
                <th><?php echo __d('cms', 'Alias'); ?></th>
                <th><?php echo __d('cms', 'Utworzono'); ?></th>
                <th><?php echo __d('cms', 'Zmodyfikowano'); ?></th>
                <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($user['Group'] as $group):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>
                    <td><?php echo $group['id']; ?></td>
                    <td><?php echo $group['name']; ?></td>
                    <td><?php echo $group['alias']; ?></td>
                    <td><?php echo $group['created']; ?></td>
                    <td><?php echo $group['modified']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__d('cms', 'Szczegóły grupy'), array('controller' => 'groups', 'action' => 'edit', $group['id'])); ?>
                        <?php //echo $this->Html->link(__d('cms', 'Usuń powiązanie'), array('controller' => 'groups', 'action' => 'unrelate', $user['User']['id'], $group['id']), null, __d('cms', 'Jesteś pewien, że chcesz usunąć użytkownika z tej grupy?', $group['id']));    ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

<h2><?php // echo __d('cms', 'Uprawnienia %s', 'Użytkownika'); ?></h2>
<?php if (!empty($user['Permission'])): ?>
    <table cellpadding = "0" cellspacing = "0">
        <tr>
            <th><?php echo __d('cms', 'Id'); ?></th>
            <th><?php echo __d('cms', 'Nazwa'); ?></th>
            <th><?php echo __d('cms', 'Utworzono'); ?></th>
            <th><?php echo __d('cms', 'Zmodyfikowano'); ?></th>
            <th class="actions"><?php echo __d('cms', 'Akcje'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($user['Permission'] as $permission):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $permission['id']; ?></td>
                <td><?php echo $permission['name']; ?></td>
                <td><?php echo $permission['created']; ?></td>
                <td><?php echo $permission['modified']; ?></td>
                <td class="actions">
                    <?php
                    echo $this->Html->link(__d('cms', 'Usuń powiązanie'), array(
                        'controller' => 'permissions',
                        'action' => 'delete_rp',
                        'User',
                        $user['User']['id'],
                        $permission['id']
                            ), null, __d('cms', 'Jesteś pewnien, że chcesz usunąć uprawnienie użytkownika "%s" do zasobu "%s"?', $user['User']['email'], $permission['name'])
                    );
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</div>

<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'Edytuj użytkownika'), array('action' => 'edit', $user['User']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__d('cms', 'Usuń użytkownika'), array('action' => 'delete', $user['User']['id']), null, __d('cms', 'Jesteś pewien, że chcesz usunąć użytkownika "%s"?', $user['User']['email'])); ?> </li>
        <li><?php echo $this->Html->link(__d('cms', 'Lista użytkowników'), array('action' => 'index')); ?> </li>
    </ul>
</div>


<!--<div class="actions">
    <ul>
        <li><?php // echo $this->Html->link(__d('cms', 'Dodaj %s', 'uprawnienie'), array('controller' => 'permissions', 'action' => 'add_rp', 'User', $user['User']['id'])); ?> </li>
    </ul>
</div>-->
