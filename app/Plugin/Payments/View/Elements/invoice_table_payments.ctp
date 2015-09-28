        <table style="font-size:8pt">
            <tr style="font-weight:bold;">
                <th><?php echo __d('commerce', 'Forma płatności', true); ?></th>
                <th><?php echo __d('commerce', 'Termin', true); ?></th>
                <th style="text-align: right;"><?php echo __d('commerce', 'Kwota', true); ?></th>
            </tr>
        <?php foreach($invoice['Invoice']['payments'] AS $i => $payment){ ?>
            <tr>
                <td><?php echo $payment['payment_gate']; ?></td>
                <td><?php echo date('j.m.Y \r', strtotime($payment['payment_date'])); ?></td>
                <td style="text-align: right;"><?php echo $febNumber->priceFormat($payment['amount']); ?></td>
            </tr>
        <?php } ?>
        </table>
