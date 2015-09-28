<div class="orderItemDetails clearfix">
<?php
$product_prices = Commerce::calculateByPriceType($orderItem['price'], $orderItem['tax_rate'], 1, $orderItem['discount']);
$row_prices = Commerce::calculateByPriceType($orderItem['price'], $orderItem['tax_rate'], $orderItem['quantity'], $orderItem['discount']);
?>

<table class="pricesTable" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo __d('public', 'Produkt'); ?></th>
            <th><?php echo __d('public', 'Cena netto'); ?></th>
            <th><?php echo __d('public', 'Ilość'); ?></th>
            <th><?php echo __d('public', 'Wartość netto'); ?></th>
            <th><?php echo __d('public', 'Cena brutto'); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $orderItem['name']; ?></td>
            <td><?php echo $this->Number->currency($product_prices['final_price_net'], 'EUR'); ?></td>
            <td><?php echo $orderItem['quantity']; ?></td>
            <td><?php echo $this->Number->currency($row_prices['final_price_net'], 'EUR'); ?></td>
            <td><?php echo $this->Number->currency($row_prices['final_price_gross'], 'EUR'); ?></td>
        </tr>
    </tbody>
</table>
<div class="clearfix">
    <div class="thumb">
<?php

$product = json_decode($orderItem['product'], true);

echo !empty($product['Photo']['img']) ? $this->Image->thumb('/files/photo/'.$product['Photo']['img'], array('width' => '135', 'height' => '100','frame'=>'#fff')) : '&nbsp;';
?>
    </div>

    <div class="details" style="float: left; width:60%">
    </div>
</div>
</div>
