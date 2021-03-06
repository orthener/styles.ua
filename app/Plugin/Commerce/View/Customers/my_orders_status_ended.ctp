<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php // $this->Html->addCrumb('Twoje zamówienia', array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'my_orders_active')); ?>
<?php $this->Html->addCrumb(__d('front', 'Twoje zamówienia')); ?>
<?php $this->Html->addCrumb(__d('front', 'Zrealizowane')); ?>

    <?php $title = __d('public', 'ZAMÓWIENIA ZREALIZOWANE'); ?>
<?php $this->set('title_for_layout', $title); ?>

<div id="my-account" class="clearfix users">
    <div class="row-fluid">
        <div class="breadcrump span12 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="border-page padding20">
                <h3><?php echo $title ?></h3>
                <div class="blueNav">
                    <?php echo $this->element('customer/menu'); ?>
                </div>
                <div id="my-account-content">

                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th><?php echo __d('front', 'NR ZAMÓWIENIA'); ?></th>
                            <th><?php echo __d('front', 'DATA'); ?></th>
                            <th><?php echo __d('front', 'WARTOŚĆ'); ?></th>
                            <th><?php echo __d('front', 'SZCZEGÓŁY'); ?></th>
                        </tr>
                        <?php
                        $key = 0;
                        foreach ($this->request->data['Order'] as $order):
                            $altrow = ($key % 2 == 0) ? 'altrow' : '';
                            ?>
                            <tr <?php echo $altrow ? 'class="' . $altrow . '"' : ''; ?>>
                                <td><b><?php echo $order['hash']; ?></b></td>
                                <td><?php echo $order['created']; ?></td>
                                <td><?php echo $order['total']; ?> zł</td>
                                <td><?php echo $this->Html->link('Szczegóły', array('action' => 'order_item', $order['id'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>