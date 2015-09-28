<?php $this->Html->addCrumb('Strona główna', '/'); ?>
<?php // $this->Html->addCrumb('Twoje zamówienia', array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'my_orders_active')); ?>
<?php $this->Html->addCrumb('Twoje zamówienia'); ?>


<?php
/* @var $this View */
/* @var $this->Html-> HtmlHelper */
/* @var $js JavascriptHelper */
/* @var $febNumber FebNumberHelper */
?>


<?php $title = __d('public', 'MOJE KONTO'); ?>
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
                <h3><?php echo $title ?></h3>
                <div class="blueNav">
                    <?php echo $this->element('customer/menu'); ?>
                </div>
                <div id="my-account-content">
                    <?php //debug($this->Html->['Order']); ?>
                    <table id="firstTable" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>NR ZAMÓWIENIA</th>
                            <th>DATA</th>
                            <th>STATUS</th>
                            <th>WARTOŚĆ</th>
                            <th>ZAPŁACONO</th>
                            <th>SZCZEGÓŁY</th>
                        </tr>
                        <?php
                        $key = 0;


                        foreach ($this->request->data['Order'] as $order):
//            debug($order);
                            $altrow = ($key % 2 == 0) ? 'altrow' : '';
                            if ($key == 5) {
                                echo '</table>';
                                echo '<table style="display:none;" id="moreTable" cellpadding="0" cellspacing="0">';
                            }
                            ?>
                            <tr <?php echo $altrow ? 'class="' . $altrow . '"' : ''; ?>>
                                <td><?php echo $order['hash']; ?></td>
                                <td>
                                    <?php
                                    $created = strtotime($order['created']);
                                    echo date('d.m.Y', $created);
                                    ?>
                                </td>
                                <td><?php echo @$orderStatuses[$order['order_status_id']]; ?></td>
                                <td><?php echo $febNumber->priceFormat($order['total']); ?></td>
                                <td><?php echo $febNumber->priceFormat($order['paymentTotal']); ?></td>
                                <td>


                                    <?php echo isset($order['Invoice']['id']) ? $this->Html->link('F. Vat', array('prefix' => 'admin', 'admin' => 'admin', 'plugin' => 'payments', 'controller' => 'invoices', 'action' => 'getpdf', $order['Invoice']['id'])) . '&nbsp;&nbsp;&nbsp;&nbsp;' : ''; ?>
                                <td>
                                    <?php if ($order['paymentTotal'] < $order['total']) { ?>
                                        <?php echo $this->Html->link('Zapłać', array('controller' => 'orders', 'plugin' => 'commerce', 'action' => 'add_payment', $order['id'])); ?> || 
                                    <?php } ?>
                                    <?php echo $this->Html->link('Szczegóły', array('action' => 'order_item', $order['id'])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <div class="clearfix orders">
                        <?php echo ($key > 5) ? $this->Html->link('więcej&nbsp;»', '#', array('escape' => false, 'class' => 'fr blueButton', 'id' => 'more')) : ''; ?>
                    </div>
                    <div id="my-account-chart">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery('a#more').click(function() {
        $('#firstTable tr:last').after($('#moreTable tr').html());
        $(this).css('display', 'none');
    })


</script>
