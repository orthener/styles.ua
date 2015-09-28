
<div>
    <p>
        <?php __d('public', 'Zamówienie zostało zapisane'); ?>
    </p>
    <p>
        <?php __d('public', 'Za kilka sekund nastąpi przekierowanie do serwisu PayPal'); ?>
    </p>
</div>

<div style="display:none;" >

    <form id="paypal" action="https://www<?php echo PP_SANDBOX; ?>.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="charset" value="utf-8" />
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="business" value="<?php echo PP_USER; ?>" />
        <input type="hidden" name="amount" value="<?php echo $order['Order']['total']; ?>" />
        <input type="hidden" name="currency_code" value="EUR" /> 
        <!--<input type="hidden" name="tax_rate" value="<?php // echo Configure::read('Settings.vat') * 100; ?>" />-->
        <input type="hidden" name="return" value="<?php echo Router::url(array('plugin' => 'payments' ,'controller' => 'payments', 'action' => 'paypal_status', 'ok', $order['Order']['id']), true); ?>" />
        <input type="hidden" name="cancel_return" value="<?php echo Router::url(array('plugin' => 'payments', 'controller' => 'payments', 'action' => 'paypal_status', 'nok', $order['Order']['id']), true); ?>" />
        <input type="hidden" name="item_name" value="<?php echo 'TopFenster zamówienie nr #' . $order['Order']['hash']; ?>" />
        <input type="image" src="https://www.paypal.com/de_DE/DE/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="Ladowanie" />
        <img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1" />
    </form>

</div>

<script type="text/javascript">
    <!--
    //<![CDATA[ 

    $(document).ready(function(){
        setTimeout(function(){ 
            $('#paypal').submit(); 
        }, 1000);
    });

    //]]> -->
</script>


