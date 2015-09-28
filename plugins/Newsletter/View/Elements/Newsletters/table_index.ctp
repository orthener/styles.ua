<h2><?php echo __d('cms', 'Odbiorcy mailingu'); ?></h2>
<table cellpadding="0" cellspacing="0">
    
    <?php // if(!isSet($paddingOff)): ?>
        <tr>
            <th><?php echo $this->Paginator->sort('email'); ?></th>
            <th><?php echo $this->Paginator->sort(__d('cms', 'Potwierdzony'), 'confirmed'); ?></th>
            <th><?php echo $this->Paginator->sort(__d('cms', 'Utworzono'), 'created'); ?></th>
            <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
        </tr>
    <?php
    $i = 0;
    foreach ($newsletters as $newsletter):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
        ?>
        <tr<?php echo $class; ?>>
            <td><?php echo $newsletter['Newsletter']['email']; ?>&nbsp;</td>
            <td><?php echo $newsletter['Newsletter']['confirmed']; ?>&nbsp;</td>
            <td><?php echo $newsletter['Newsletter']['created']; ?>&nbsp;</td>
            <td class="actions">
                <?php echo $this->Html->link(__d('cms', 'Usuń'), array('action' => 'delete', $newsletter['Newsletter']['id']), null, __d('cms', 'Na pewno usunąć wpis # %s?', $newsletter['Newsletter']['email'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>