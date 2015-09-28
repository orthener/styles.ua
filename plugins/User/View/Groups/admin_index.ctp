<div class="groups index">
    <h2><?php echo __d('cms','Grupy Użytkowników'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
    <!--        <th><?php //echo $this->Paginator->sort(__d('cms','Kolejność'), 'order'); ?></th> -->
            <th><?php echo $this->Paginator->sort(__d('cms','Nazwa'), 'name'); ?></th>
            <th><?php echo $this->Paginator->sort(__d('cms','Alias'), 'alias'); ?></th>
            <th><?php echo $this->Paginator->sort(__d('cms','Utworzono'), 'created'); ?></th>
            <th><?php echo $this->Paginator->sort(__d('cms','Zmodyfikowano'), 'modified'); ?></th>
            <th class="actions"><?php echo __d('cms','Akcje'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($groups as $group):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $group['Group']['id']; ?>&nbsp;</td>
        <!--        <td><?php //echo $group['Group']['order'];  ?>&nbsp;</td> -->
                <td><?php echo $group['Group']['name']; ?>&nbsp;</td>
                <td><?php echo $group['Group']['alias']; ?>&nbsp;</td>
                <td><?php echo $group['Group']['created']; ?>&nbsp;</td>
                <td><?php echo $group['Group']['modified']; ?>&nbsp;</td>
                <td class="actions">
                    <?php // echo $this->Html->link(__d('cms','Szczegóły'), array('action' => 'view', $group['Group']['id'])); ?>
                    <?php echo $this->Html->link(__d('cms','Edytuj'), array('action' => 'edit', $group['Group']['id'])); ?>
                    <?php echo $this->Html->link(__d('cms','Usuń'), array('action' => 'delete', $group['Group']['id']), null, __d('cms','Jesteś pewien, że chcesz usunąć grupę "%s"?', $group['Group']['name'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php echo $this->element('cms/paginator'); ?>
</div>
<div class="actions" style="padding-top: 10px">
    <ul>
        <li><?php echo $this->Html->link(__d('cms','Dodaj %s', ''), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__d('cms','Lista użytkowników'), array('controller' => 'users', 'action' => 'index')); ?> </li>
        <!--<li><?php // echo $this->Html->link(__d('cms','Uprawnienia %s', 'grup'), array('controller' => 'permissions', 'action' => 'groups')); ?> </li>-->
    </ul>
</div>