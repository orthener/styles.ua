<?php 
$discount = false; 
$name_col_style = 'width:100mm';
foreach($invoice['Invoice']['items'] AS $i => $item){
    if(!empty($item['discount']) AND $item['discount'] > 0){
        $discount = true;
        $name_col_style = 'width:80mm';
        break;
    }
}
?>

<table style="font-size:8pt">
    <tr style="font-weight:bold;">
        <th style="width:10mm">L.p.</th>
        <th style="<?php echo $name_col_style; ?>">Nazwa towaru / usługi</th>
        <th style="width:20mm"><?php echo ($invoice['Invoice']['price_type'])?__d('commerce', 'Cena brutto', true):__d('commerce', 'Cena netto', true); ?></th>
        <th style="width:15mm">Ilość</th>
        <th style="width:15mm">J. m.</th>
        <?php if($discount){ ?>
            <th style="width:20mm">Rabat</th>
        <?php } ?>
        <th style="width:25mm; text-align: right;"><?php echo ($invoice['Invoice']['price_type'])?__d('commerce', 'Wartość brutto', true):__d('commerce', 'Wartość netto', true); ?></th>
    </tr>
<?php foreach($invoice['Invoice']['items'] AS $i => $item){ ?>
    <tr>
        <td><?php echo $i+1; ?></td>
        <td><?php echo $item['name']; ?></td>
        <td style="text-align: right;"><?php echo ($invoice['Invoice']['price_type'])? $febNumber->priceFormat($item['price_gross']):$febNumber->priceFormat($item['price_net']); ?></td>
        <td><?php echo $item['quantity']; ?></td>
        <td><?php echo $item['unit']; ?></td>
        <?php if($discount){ ?>
            <td><?php echo $item['discount']; ?>%</td>
        <?php } ?>
        <td style="text-align: right;"><?php echo ($invoice['Invoice']['price_type'])?$febNumber->priceFormat($item['final_amount_gross']):$febNumber->priceFormat($item['final_amount_net']); ?></td>
    </tr>
<?php } ?>
</table>
