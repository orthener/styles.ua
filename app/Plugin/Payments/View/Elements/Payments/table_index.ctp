<h2><?php echo __d('cms', 'Payments'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('user_plugin', __d('cms', 'User Plugin')); ?></th>
            <th><?php echo $this->Paginator->sort('user_model', __d('cms', 'User Model')); ?></th>
            <th><?php echo $this->Paginator->sort('user_row_id', __d('cms', 'User Row Id')); ?></th>
            <th><?php echo $this->Paginator->sort('related_plugin', __d('cms', 'Related Plugin')); ?></th>
            <th><?php echo $this->Paginator->sort('related_model', __d('cms', 'Related Model')); ?></th>
            <th><?php echo $this->Paginator->sort('related_row_id', __d('cms', 'Related Row Id')); ?></th>
            <th><?php echo $this->Paginator->sort('client_ip', __d('cms', 'Client Ip')); ?></th>
            <th><?php echo $this->Paginator->sort('payment_gate', __d('cms', 'Payment Gate')); ?></th>
            <th><?php echo $this->Paginator->sort('title', __d('cms', 'Title')); ?></th>
            <th><?php echo $this->Paginator->sort('amount', __d('cms', 'Amount')); ?></th>

            <th><?php echo $this->Paginator->sort('payment_date', __d('cms', 'Payment Date')); ?></th>
            <th><?php echo $this->Paginator->sort('status', __d('cms', 'Status')); ?></th>
            <th><?php echo $this->Paginator->sort('email_confirm', __d('cms', 'Email Confirm')); ?></th>
            <th><?php echo $this->Paginator->sort('platnosci_status', __d('cms', 'Platnosci Status')); ?></th>
            <th><?php echo $this->Paginator->sort('platnosci_pay_type', __d('cms', 'Platnosci Pay Type')); ?></th>
            <th><?php echo $this->Paginator->sort('platnosci_amount', __d('cms', 'Platnosci Amount')); ?></th>
            <th><?php echo $this->Paginator->sort('platnosci_desc', __d('cms', 'Platnosci Desc')); ?></th>
            <th><?php echo $this->Paginator->sort('platnosci_desc2', __d('cms', 'Platnosci Desc2')); ?></th>
            <th><?php echo $this->Paginator->sort('platnosci_firstname', __d('cms', 'Platnosci Firstname')); ?></th>
            <th><?php echo $this->Paginator->sort('platnosci_lastname', __d('cms', 'Platnosci Lastname')); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($payments as $payment):
            ?>
            <tr data-id="<?php echo $payment['Payment']['id']; ?>">
                <td><?php echo h($payment['Payment']['user_plugin']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['user_model']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['user_row_id']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['related_plugin']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['related_model']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['related_row_id']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['client_ip']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['payment_gate']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['title']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['amount']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['payment_date']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['status']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['email_confirm']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['platnosci_status']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['platnosci_pay_type']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['platnosci_amount']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['platnosci_desc']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['platnosci_desc2']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['platnosci_firstname']); ?>&nbsp;</td>
                <td><?php echo h($payment['Payment']['platnosci_lastname']); ?>&nbsp;</td>
                <td><?php echo $this->FebTime->niceShort($payment['Payment']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($payment['Payment']['modified']); ?></td>
                <td class="actions">
                    <?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $payment['Payment']['id'])); ?>
                    <?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $payment['Payment']['id'])); ?>
    <?php echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $payment['Payment']['id']), null, __('Are you sure you want to delete # %s?', $payment['Payment']['title'])); ?>
                </td>
            </tr>
<?php endforeach; ?>
    </tbody>
</table>