        
<?php //debug($diffs)  ?>

<?php if (!empty($diffs)) { ?>            
    <fieldset>
        <legend><?php echo __d('cms', 'Historia Modyfikacji'); ?></legend>
        <?php foreach ($diffs as $changeArray) { ?>

            <?php if ($changeArray['Modification']['model'] == 'Order') { ?>

        <h3><?php echo __d('cms', 'Uaktualnione przez'); ?> <?php echo $changeArray['User']['name'] ?> <?php echo $this->FebTime->niceShort($changeArray['date']); ?></h3>
                <ul> 

                    <?php
                    foreach ($changeArray['diff'] as $klucz => $afterValue) {

                        if ($klucz == 'order_status_id') {
                            $afterValue = @$orderStatusFull[$afterValue];
                            if (isset($changeArray['before']) && isSet($changeArray['before'][$klucz]))
                                $changeArray['before'][$klucz] = @$orderStatusFull[$changeArray['before'][$klucz]];
                        } else if ($klucz == 'region_id') {
                            $afterValue = @$regions[$afterValue];
                            if (isset($changeArray['before'][$klucz]))
                                $changeArray['before'][$klucz] = @$regions[$changeArray['before'][$klucz]];
                        } else if ($klucz == 'shipment_method_id') {
                            $afterValue = @$shipmentMethods[$afterValue];
                            if (isset($changeArray['before'][$klucz]))
                                $changeArray['before'][$klucz] = @$shipmentMethods[$changeArray['before'][$klucz]];
                        } else if ($klucz == 'payment_type') {
                            $afterValue = @$paymentTypes[$afterValue];
                            if (isset($changeArray['before'][$klucz]))
                                $changeArray['before'][$klucz] = @$paymentTypes[$changeArray['before'][$klucz]];
                        }

                        if ($klucz == 'address') {
                            ?>

                            <h4><?php echo __d('cms', 'Modyfikacja danych wysyłki'); ?>:</h4>
                            <?php
                            foreach ($afterValue as $k => $v) {
                                if ($k == 'country_id') {
                                    $v = $countries[$v];
                                    if (isset($changeArray['before']['address'][$k]))
                                        $changeArray['before']['address'][$k] = $countries[$changeArray['before']['address'][$k]];
                                } else if ($k == 'region_id') {
                                    $v = $regions[$v];
                                    if (isset($changeArray['before']['address'][$k]))
                                        $changeArray['before']['address'][$k] = $regions[$changeArray['before']['address'][$k]];
                                }
                                ?>

                            <li><b><?php __d('commerce', $k) ?></b> <?php echo __d('cms', 'zmieniono z'); ?> <b><?php echo $changeArray['before']['address'][$k] ?></b> na <b><?php echo $v ?></b></li>
                            <?php } continue; ?>
                        <?php } ?>

                        <?php if ($klucz == 'invoice_identity') { ?>

                                <h4><?php echo __d('cms', 'Modyfikacja danych do faktury'); ?>:</h4>
                            <?php
                            foreach ($afterValue as $k => $v) {

                                if ($k == 'country_id') {
                                    $v = $countries[$v];
                                    if (is_array($changeArray['before']['invoice_identity'][$k]))
                                        $changeArray['before']['invoice_identity'][$k] = $countries[$changeArray['before']['invoice_identity'][$k]];
                                } else if ($k == 'region_id') {
                                    $v = $regions[$v];
                                    if (is_array($changeArray['before']['invoice_identity'][$k]))
                                        $changeArray['before']['invoice_identity'][$k] = $regions[$changeArray['before']['invoice_identity'][$k]];
                                } else if ($k == 'iscompany') {
                                    ?>
                                    <?php if ($v == 1) { ?>
                                        <li>Faktura dla <b>firmy</b></li>
                                    <?php } else { ?>
                                        <li>Faktura dla <b>osoby fizycznej</b></li>
                            <?php } continue; ?>
                            <?php }
                            ?>
                                <li><b><?php __d('commerce', $k) ?></b> <?php echo __d('cms', 'zmieniono z'); ?> <b><?php echo $changeArray['before']['invoice_identity'][$k] ?></b> na <b><?php echo $v ?></b></li>
                    <?php } continue; ?>
                    <?php } ?>

                        <li><b><?php __d('commerce', $klucz) ?></b> <?php echo __d('cms', 'zmieniono z'); ?> <b><?php echo $changeArray['before'][$klucz] ?></b> na <b><?php echo $afterValue ?></b></li>
            <?php } ?>
                </ul><br />
                <?php } else if ($changeArray['Modification']['model'] == 'Note') { ?>
                <?php } else if ($changeArray['Modification']['model'] == 'OrderItem') { ?>        
                <h3><?php echo __d('cms', 'Uaktualnione przez'); ?> <?php echo $changeArray['User']['name'] ?> <?php echo $this->FebTime->niceShort($changeArray['date']); ?></h3>
                <ul> 
                    <h4><?php echo __d('cms', 'Modyfikacja Produktów Zamówienia'); ?></h4>
            <?php foreach ($changeArray['diff'] as $key => $value) { ?>

                    <li><b><?php __d('commerce', $key) ?></b> <?php echo __d('cms', 'zmieniono z'); ?>' <b><?php echo $changeArray['before'][$key]; ?></b> <?php echo __d('cms', 'na'); ?> <b><?php echo $value; ?></b> dla <b><?php echo $changeArray['before']['name']; ?></b></li>
                <?php } ?>
                </ul><br />
        <?php } ?>

    <?php } ?>
    </fieldset>
<?php } ?>