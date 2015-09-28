<?php 
    $taxTypes = array();
    foreach($invoices as $invoice){
        foreach($invoice['Invoice']['taxes'] as $tax){
            $taxTypes[$tax['taxType']] = $tax['tax'];
        }
    } 
?>



<div class="sub_index page-break-div">
<h2><?php echo Configure::read('Commerce.company_name'); ?></h2>
<h3><?php 
    echo Configure::read('Commerce.company_address').', '.
        Configure::read('Commerce.company_post_code').' '.
        Configure::read('Commerce.company_city').', NIP:'.
        Configure::read('Commerce.company_nip'); 
    ?></h3>

<div>
<h3>Zestawienie faktur nr <?php echo $number; ?> (<?php echo ucfirst(strftime("%B %Y", $month_begin_timestamp)); ?>) </h3>
</div>
<table>
<tr>
<th rowspan="2" class="idColumn">Nr</th>
<th rowspan="2" ><strong>Numer faktury</strong> 
<?php if($invoices[0]['Invoice']['buyer_is_company']){ ?>
    <br />NIP
<?php } ?>
</th>
<th rowspan="2" >Kontrahent</th>
<th rowspan="2" >Data wystaw. i sprzedaży</th>
<th rowspan="2" >Wartość netto</th>
<th colspan="<?php echo count($taxTypes)+1; ?>" >Wartość VAT</th>
<th rowspan="2" >Wartość brutto</th>
<?php 
    $suma_netto = 0;
    $suma_brutto = 0;

    $suma_vat_array = array_fill_keys(array_keys($taxTypes), 0);

    $suma_vat = 0;


?>
</tr>
<tr>
<?php foreach($taxTypes AS $key => $value){ ?>
<th><?php echo $key; ?></th>
<?php } ?>
<th>Razem VAT</th>
</tr>

<?php $i = 0; foreach($invoices as $invoice): ?>
<tr>
<td><?php echo ++$i; ?></td>
<td><strong><?php echo $invoice['Invoice']['number'] ?></strong><br />
<?php if($invoice['Invoice']['buyer_is_company']){ ?>
    <?php echo $invoice['Invoice']['buyer']['nip']; ?>
<?php } ?>
</td>
<td>
    <strong><?php echo $invoice['Invoice']['buyer']['name'] ?></strong>
    <br /><?php echo $invoice['Invoice']['buyer']['address'] ?>, <?php echo $invoice['Invoice']['buyer']['post_code'] ?> <?php echo $invoice['Invoice']['buyer']['city'] ?>
</td>
<td><?php echo date('Y-m-d', strtotime($invoice['Invoice']['invoice_date'])); ?></td>
<td><?php echo $febNumber->priceFormat($invoice['Invoice']['total_net']);
$suma_netto += $invoice['Invoice']['total_net'];  ?></td>

<?php foreach($taxTypes AS $key => $value){ ?>
<td><?php 
        foreach($invoice['Invoice']['taxes'] AS $tax){
            if($tax['taxType'] == $key){
                echo $febNumber->priceFormat($tax['final_tax_value']);
                $suma_vat_array[$key] += $tax['final_tax_value'];
            }
        }
 ?></td>
<?php } ?>

<td><?php echo $febNumber->priceFormat($invoice['Invoice']['total_tax']);
$suma_vat += $invoice['Invoice']['total_tax'];  ?></td>
<td><?php echo $febNumber->priceFormat($invoice['Invoice']['total_gross']);
$suma_brutto += $invoice['Invoice']['total_gross'];  ?></td>

</tr>
<?php endforeach; ?>

<tr>
<td colspan="4" style="text-align:right;">
<strong>RAZEM:</strong>
</td>
<td><?php echo $febNumber->priceFormat($suma_netto); ?></td>
<td><?php echo $febNumber->priceFormat($suma_vat); ?></td>
<?php foreach($taxTypes AS $key => $value){ ?>
    <td><?php echo $febNumber->priceFormat($suma_vat_array[$key]); ?></td>
<?php } ?>
<td><?php echo $febNumber->priceFormat($suma_brutto); ?></td>
</tr>
<?php 
$this->month_suma_netto += $suma_netto;
$this->month_suma_vat += $suma_vat;
$this->month_suma_brutto += $suma_brutto;


?>
</table>
<div>
<h3 style="margin-top: 0;"><?php echo $info; ?></h3>
</div>

</div>

