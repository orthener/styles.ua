        <table style="font-size:8pt">
            <tr style="font-weight:bold;">
                <th> </th>
                <th style="text-align: right;"><?php echo __d('commerce', 'netto', true); ?></th>
                <th style="text-align: right;"><?php echo __d('commerce', 'VAT', true); ?></th>
                <th style="text-align: right;"><?php echo __d('commerce', 'brutto', true); ?></th>
            </tr>
        <?php foreach($invoice['Invoice']['taxes'] AS $i => $tax){ ?>
            <tr>
                <td><?php echo sprintf(__d('commerce', 'Stawka %d%%', true), $tax['tax']*100); ?></td>
                <td style="text-align: right;"><?php echo $febNumber->priceFormat($tax['price_net']); ?></td>
                <td style="text-align: right;"><?php echo $febNumber->priceFormat($tax['tax_value']); ?></td>
                <td style="text-align: right;"><?php echo $febNumber->priceFormat($tax['price_gross']); ?></td>
            </tr>
        <?php } ?>
            <tr>
                <td style="text-align: right;"><?php echo sprintf(__d('commerce', 'Razem:', true), $tax['tax']*100); ?></td>
                <td style="text-align: right;"><?php echo $febNumber->priceFormat($invoice['Invoice']['total_net']); ?></td>
                <td style="text-align: right;"><?php echo $febNumber->priceFormat($invoice['Invoice']['total_tax']); ?></td>
                <td style="text-align: right;"><?php echo $febNumber->priceFormat($invoice['Invoice']['total_gross']);?></td>
            </tr> 
        </table>
