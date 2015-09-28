<script>
    $(document).ready(function() {   

    });
</script>
<fieldset>
    <legend><?php echo __d('cms', 'Płatności'); ?>:</legend>
<ul>
    <?php foreach($payments as $k => $payment) { ?>
    <?php 
    if (!empty($paymentGates[$payment['payment_gate']])) {
        $paymentGate = $paymentGates[$payment['payment_gate']];
    } 
    else {
        $paymentGate = $payment['payment_gate'];
    }
    ?>
    <li><?php echo $paymentGate; ?> - <?php echo $this->Number->currency($payment['amount'], 'PLN'); ?> <b>(<?php echo $statuses[$payment['status']]; ?>)</b> <?php echo $payment['payment_date']; ?></li>
<?php } ?>
</ul>
</fieldset>