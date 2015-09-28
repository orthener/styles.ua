<?php
$productLink = array('plugin' => 'static_product', 'controller' => 'products', 'action' => 'view', $product['Product']['slug']);
if (!isset($type)) {
    $type = null;
}
?>

<?php 
if (!empty($product['Product']['sized']) && !empty($product['ProductsSize'])) {
    $productSizes = array();
    foreach($product['ProductsSize'] as $size) {
        if ($size['quantity'] > 0 && !in_array($size['name'], $productSizes)) {
            $productSizes[] = $size['name'];
        }
    }
//    debug($product['ProductsSize']);
    $productSizes = array_unique($productSizes);
//    $productSizes = array_reverse($productSizes);
    $productSizes = implode('; ', $productSizes);
}
else {
    $productSizes = '';
}
?>
<?php //debug($product['Product']['id']);?>
<div name="<?php echo $product['Product']['id'];?>" class="product span2 bt-no-margin" href="<?php echo $this->Html->url($productLink); ?>">
    <a href="<?php echo $this->Html->url($productLink); ?>" title="" class="alinkContainer"></a>
    <div class="green-field">
        <div class="green-info">
            <h5 class="productBrandName"><?php echo $product['Brand']['name']; ?></h5>
            <h4 class="productName"><?php echo $this->Html->link($product['Product']['title'], $productLink); ?></h4>
            
            <div class="productSizes">
                <?php //echo str_replace('|', '; ', $product['Product']['size']); ?>
                <?php echo $productSizes; ?>
            </div>
            
            <span class="actualPrice">

                <?php if (empty($product['ProductsPromotion']['price'])): ?>
                    <?php echo $this->FebNumber->currency($product['Product']['price'], ' ₴');?>
                <?php else: ?>
                    <span style='text-decoration: line-through'><?php echo $this->FebNumber->currency($product['Product']['price'], ' ₴');?></span>&nbsp;&nbsp;
                    <span><?php echo $this->FebNumber->currency($product['ProductsPromotion']['price'], ' ₴');?></span>
                <?php endif; ?>
            </span>

            <?php // echo $product['Product']['price'] * (1 + $product['Product']['tax']); ?>
            <?php // echo $this->Html->link('KUP', $productLink, array('class' => 'buyLink')); ?>
            <!--<i class="icon-strzalka"></i>-->
        </div>
    </div>
    <?php
//    debug($product);
    if (!empty($product['Product']['thumb'])):
        echo $this->Image->thumb('/files/product/' . $product['Product']['thumb'], array('width' => 195, 'height' => 270, 'crop' => false));
    elseif (!empty($product['Photo']['img'])):
        echo $this->Image->thumb('/files/photo/' . $product['Photo']['img'], array('width' => 195, 'height' => 270, 'crop' => false));
    else:
        echo $this->Image->thumb('/img/layouts/default/blank.png', array('width' => 195, 'height' => 270, 'crop' => false, 'frame' => 'fff'));
    endif;
    ?>
</div>

<?php // if (!empty($product['ProductsPromotion']['price'])): ?>
<!--            <div class="price">
                <span class="oldPrice"><?php // echo $product['ProductsPromotion']['price'] ? $product['Product']['price'] * (1 + $product['Product']['tax']) . ' zł' : '';      ?></span>
                <span class="actualPrice promotionPrice"><?php // echo $product['ProductsPromotion']['price'] ? $product['ProductsPromotion']['price'] * (1 + $product['Product']['tax']) : $product['Product']['price'] * (1 + $product['Product']['tax'])      ?>  zł</span>
            </div>-->
<?php // else: ?>
<!--            <div class="price">
                <span class="actualPrice"><?php // echo $product['Product']['price'] * (1 + $product['Product']['tax']);      ?> zł</span>
            </div>-->
<?php // endif; ?>


<?php
// endif; ?>