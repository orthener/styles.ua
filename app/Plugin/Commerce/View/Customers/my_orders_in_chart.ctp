<?php $this->Html->addCrumb('Strona główna', '/'); ?>
<?php // $this->Html->addCrumb('Twoje zamówienia', array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'my_orders_active')); ?>
<?php $this->Html->addCrumb('Twoje zamówienia'); ?>

    <?php $title = __d('public', 'W Koszyku'); ?>
<?php $this->set('title_for_layout', $title); ?>

<div id="my-account" class="clearfix users">
    <div class="row-fluid">
        <div class="breadcrump span12 bt-no-margin">
            <span class="navi">NAVIGATION:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="border-page padding20">
                <?php echo $this->element('customer/menu'); ?>
                <div id="my-account-content">
                    <h3><?php echo $title ?></h3>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Wartość</th>
                            <th>Zapłacono</th>
                            <th>Szczegóły</th>
                        </tr>
                        <?php foreach ($this->request->data['Order'] as $order): ?>
                            <tr>
                                <td><?php echo $order['created']; ?></td>
                                <td><?php //echo $orderStatuses[$order['order_status_id']];  ?></td>
                                <td><?php echo $order['total']; ?> zł</td>
                                <td><?php //echo $order['paymentTotal'];  ?> zł</td>
                                <td>Szczegóły</td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>