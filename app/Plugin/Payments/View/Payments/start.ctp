<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb(__d('front', 'Koszyk'), array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'cart')); ?>
<?php $this->Html->addCrumb(__d('front', 'Płatność')); ?>

<div id="payments" class="clearfix payment start">
    <div class="row-fluid">
        <div class="breadcrump span12 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="border-page padding20">
                <div class="title">
                    <h3><?php echo __d('front', 'Płatność'); ?></h3>
                </div>
                <form id="payformID" action="<?php echo $payment_params['post']['url']; ?>" enctype="multipart/form-data" method="post" name="payform">
                    <?php foreach ($payment_params['post']['data'] AS $key => $value) { ?>
                        <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
                    <?php } ?>
                    <input type="hidden" name="js" value="0" />

                    <?php
                    switch ($payment_params['payment_gate']) {
                        case 'platnosci.pl':
                            echo '<input class="submit" type="submit" value="'.  __d('front', 'Zapłać poprzez PayU').'" />';
                            break;
                    }
                    ?>
                </form>

                <script type="text/javascript">
                    //<![CDATA[

                    document.forms['payform'].js.value = 1;

                    function submitGo() {
                        //wysłanie formularza
                        $('#payformID')[0].submit();
                        $('#payformID .submit').attr('disabled', 'disabled');
                    }
                    submitGo();
                    //]]>
                </script>

            </div>
        </div>
    </div>
</div>

