<table style="width: 100%">
    <tbody>
        <tr>
            <td style="width:40%"></td>
            <td style="width: 30%"></td>
            <td style="width: 30%"><?php echo __('Wartość produktów bez rabatu: '); ?>
                <b>
                    <span id="razem-bez-wysylki">
                        <?php
                        $price = 0;
                        foreach ($order['OrderItem'] as $orderItem) {
                            $price += $orderItem['price_gross'] * $orderItem['quantity'];
                        }
                        echo $this->FebNumber->currency($price, ' ₴');
                        ?>
                    </span>
                </b>
            </td>
        </tr>
        <?php
        if ((empty($order['PromotionCode']['value']) && !empty($order['Customer']['discount'])) ||
                (!empty($order['PromotionCode']['value']) && !empty($order['Customer']['discount']) && $order['PromotionCode']['value'] < $order['Customer']['discount'])):
            ?>
            <tr id="customer_discount">
                <td><?php echo __('Rabat osobisty aktywny - wartość rabatu:'); ?><span> <?php echo $order['Customer']['discount']; ?></span>%</td>
                <td></td>
                <td><?php echo __('Wartość z rabatem osobistym: '); ?>
                    <?php //$customerDiscountValue = $order['Order']['total'] - $order['Order']['total'] * ($order['Customer']['discount'] / 100); ?>
                    <?php $customerDiscountValue = $price - $price * ($order['Customer']['discount'] / 100); ?>
                    <b><span id="customer_discount_value" total="<?php echo $customerDiscountValue; ?>"><?php echo $this->FebNumber->currency($customerDiscountValue, ' ₴'); ?></span></b>
                </td>
            </tr>
        <?php endif; ?>
        
        <tr>
            <td>
                <?php echo $this->Form->input('promotionCode', array('type' => 'checkbox', 'label' => __('Posiadam kupon rabatowy'), 'default' => (!empty($order['PromotionCode']['id'])) ? 1 : 0)); ?>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr id="promotion_code_insert" class="dn">
            <td>
                <?php $code_value = empty($order['PromotionCode']['code']) ? '' : $order['PromotionCode']['code']; ?>
                <?php echo $this->Form->input('PromotionCode.code', array('label' => __('Podaj kod promocyjny:'), 'value' => $code_value)); ?>
                <?php echo $this->Form->input('PromotionCode.code_id', array('label' => false, 'type' => 'hidden')); ?>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr id="promotion_code_info" class="dn">
            <td><?php echo __('Kod promocyjny aktywny - wartość rabatu:'); ?><span id="activeCode"> <?php echo $order['PromotionCode']['value']; ?></span>%</td>
            <td></td>
            <td>
                <?php echo __('Wartość z kodem promocyjnym: '); ?>
                <?php $pricePromotionCodeValue = $price - $price * ($order['PromotionCode']['value'] / 100); ?>
                <b><span id="price-after-promo" bonus="<?php echo $pricePromotionCodeValue; ?>"><?php echo $this->FebNumber->currency($pricePromotionCodeValue, ' ₴'); ?></span></b>
            </td>
        </tr>
        <tr id="promotion_code_delete" class="dn">
            <td>
                <?php echo $this->Html->link(__('Usuń kod'), '#', array('onclick' => 'return false;')); ?><br/>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo __('Jeśli rabat osobisty jest większy niż kupon rabatowy to zostanie naliczony rabat osobisty'); ?></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>

