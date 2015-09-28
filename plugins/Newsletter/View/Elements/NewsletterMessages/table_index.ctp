<h2><?php echo __d('cms', 'Lista wiadomości newslettera'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('title', __d('cms', 'Tytuł')); ?></th>
        <th><?php echo $this->Paginator->sort('content', __d('cms', 'Treść')); ?></th>
        <th><?php echo $this->Paginator->sort('sender_name', __d('cms', 'Nadawca')); ?> (<?php echo $this->Paginator->sort('e-mail', 'E-mail'); ?>)</th>
        <th><?php echo $this->Paginator->sort('recipients', __d('cms', 'Wysłano do')); ?></th>
        <th><?php echo $this->Paginator->sort('modified', __d('cms', 'Zmodyfikowano (wysłano)')); ?></th>
        <th class="actions"><?php echo __d('cms', 'Akcje'); ?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($newsletterMessages as $newsletterMessage):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
        ?>
        <tr<?php echo $class; ?>>
            <td><?php echo $newsletterMessage['NewsletterMessage']['title']; ?>&nbsp;</td>
            <td><?php echo $newsletterMessage['NewsletterMessage']['content']; ?>&nbsp;</td>
            <td><?php echo $newsletterMessage['NewsletterMessage']['sender_name']; ?>&nbsp;(<?php echo $newsletterMessage['NewsletterMessage']['sender_email']; ?>)&nbsp;</td>
            <td><?php echo ($newsletterMessage['NewsletterMessage']['recipients']) ? $newsletterMessage['NewsletterMessage']['recipients'] . " ".__d('cms', "odbiorców") : ''; ?>&nbsp;</td>
            <td><?php echo $newsletterMessage['NewsletterMessage']['modified']; ?>&nbsp;</td>
            <td class="actions">
                <?php echo $this->Html->link(__d('cms', 'Podgląd'), array('action' => 'view', $newsletterMessage['NewsletterMessage']['id'])); ?>
                <?php echo ($newsletterMessage['NewsletterMessage']['recipients']) ? '' : $this->Html->link(__d('cms', 'Edytuj'), array('controller' => 'newsletter_messages', 'action' => 'edit', $newsletterMessage['NewsletterMessage']['id'])); ?>
                <?php echo ($newsletterMessage['NewsletterMessage']['recipients']) ? '' : $this->Html->link(__d('cms', 'Usuń'), array('controller' => 'newsletter_messages', 'action' => 'delete', $newsletterMessage['NewsletterMessage']['id']), null, __d('cms', 'Na pewno usunąć "%s"?', $newsletterMessage['NewsletterMessage']['title'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>