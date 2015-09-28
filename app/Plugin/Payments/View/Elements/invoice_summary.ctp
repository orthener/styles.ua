<table style="border-bottom:0.1mm solid #000000">
    <tr style="font-weight:bold;font-size: 12pt;background-color: #DDDDDD;">
        <th style="text-align: left;"><?php echo __d('commerce', 'Razem', true); ?></th>
        <th style="text-align: right;"><?php echo $febNumber->priceFormat($invoice['Invoice']['total_gross']); ?></th>
    </tr>
    <tr style="font-weight:normal;font-size: 10pt;font-style:italic;">
        <th style="text-align: left;"></th>
        <th style="text-align: right;"><?php echo $febNumber->priceInWords($invoice['Invoice']['total_gross']); ?></th>
    </tr>
    <tr style="font-weight:normal;font-size: 10pt;">
        <th style="text-align: left;">
            <?php echo __d('commerce', 'Zapłacono: ', true); ?> 
            <?php echo $febNumber->priceFormat($invoice['Invoice']['total_paid']); ?>
        </th>
        <th style="text-align: right;">
            <?php echo __d('commerce', 'Pozostaje: ', true); ?> 
            <?php echo $febNumber->priceFormat($invoice['Invoice']['total_gross']-$invoice['Invoice']['total_paid']); ?>
        </th>
    </tr>
</table>
<br /><br /><br />
<table>
    <tr style="font-size: 8pt;">
        <th style="text-align: center;width:70mm;border-top:0.1mm solid #000000;"><?php echo __d('commerce', 'Podpis osoby uprawnionej do wystawienia faktury', true); ?></th>
        <th style="text-align: center;width:7mm"></th>
        <th style="text-align: center;width:36mm;border-top:0.1mm solid #000000;"><?php echo __d('commerce', 'Data odbioru', true); ?></th>
        <th style="text-align: center;width:7mm"></th>
        <th style="text-align: center;width:70mm;border-top:0.1mm solid #000000;"><?php echo __d('commerce', 'Podpis osoby uprawnionej do odbioru faktury', true); ?></th>
    </tr>
</table>

