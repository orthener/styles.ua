<?php $order = $this->Html->requestAction(array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'mini_cart', 'admin' => false, 'user' => false)); ?>
<?php $parseUrl = Router::parse($_SERVER['REQUEST_URI']); ?>
<div class="mini-cart-top row-fluid">
    <div class="fl">
        <?php echo $this->Html->image('layouts/default/cart.png'); ?>
    </div>
    <div class="fr">
        <span class="products-count"><?php echo $info['items']; ?></span>&nbsp;&nbsp;<span class="products-total"><?php echo $info['price'] . ' ₴'; ?></span>
    </div>
</div>
<?php if ($parseUrl['plugin'] != 'commerce'): ?>
    <div class="mini-cart-content">
        <?php
        if (!empty($order)):
            foreach ($order['OrderItem'] as $orderItem) {
                $tmpPrice = Commerce::calculateByPriceType($orderItem['price'], $orderItem['tax_rate'], $orderItem['quantity'], $orderItem['discount']);
                ?>
        
                <div class="productItem row">
                    <?php $product = json_decode($orderItem['product'], true); ?>
                    <span class="foto"><?php echo!empty($products[$orderItem['product_id']][0]['Photo']['img']) ? $this->Image->thumb('/files/photo/' . $products[$orderItem['product_id']][0]['Photo']['img'], array('width' => 60, 'height' => 60, 'crop' => true)) : ''; ?></span>
                    <div class="productItemData">
                        <div class="name"><?php echo $orderItem['name']; ?></div>
                        <div class="productItemSubData">
                            <span class="size">
                            <?php if (!empty($orderItem['size'])): ?>
                                <?php echo __d('front', 'rozmiar'); ?>: <?php echo $orderItem['size']; /*$new_sizes[$orderItem['size']];*/ ?>
                            <?php endif; ?>
                            </span>
                            <span class="quantity">x<?php echo ($orderItem['quantity']) ?> <?php __d('front', 'sztuki'); ?></span>
                            <span class="price"><?php echo CakeNumber::currency(Currency::exchange($tmpPrice['final_price_gross'], 'PLN'), '₴'); ?></span>
                            <span class="deleteLink">
                                <?php echo $this->Html->link('<span>x</span>', array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'delete', $orderItem['id']), array('class' => 'deleteFile', 'escape' => false)) ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php // if (($parseUrl['action'] != 'cart') && ($parseUrl['action'] != 'order_checkout')): ?>
<?php if (($parseUrl['action'] != 'cart')): ?>

    <div class="mini-cart-bottom row-fluid">
        <div class="fl">
            <?php if (!empty($order)): ?>
                <?php if ($parseUrl['plugin'] != 'commerce'): ?>
            <span class="open-mini-cart"><?php echo __d('front', 'rozwiń'); ?> <i class="icon-angle-down"></i></span>
            <span class="close-mini-cart dn"><?php echo __d('front', 'zwiń'); ?> <i class="icon-angle-up"></i></span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="fr">
            <?php echo $this->Html->link(__d('front', 'Przejdź do koszyka'), array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'cart'), array('class' => 'button white radius')); ?>
        </div>
    </div>
<?php endif; ?>

<?php if ($parseUrl['plugin'] != 'commerce'): ?>
    <script type="text/javascript">
        //<![CDATA[
        jQuery('.open-mini-cart').click(function() {
            jQuery('.mini-cart-content').css('display', 'block');
            jQuery('.open-mini-cart').css('display', 'none');
            jQuery('.close-mini-cart').css('display', 'block');
        });
        jQuery('.close-mini-cart').click(function() {
            jQuery('.mini-cart-content').css('display', 'none');
            jQuery('.open-mini-cart').css('display', 'block');
            jQuery('.close-mini-cart').css('display', 'none');
        });
        //]]>
    </script>
<?php endif; ?>