<?php
$product = array();
foreach ($products as $prod) {
    $product[] = $prod;
}
?>

<?php if (!empty($products)): ?>
    <div class="productsInCategory fl">
        <div class="half clearfix">
            <div class="fl">
                <?php // echo $this->element('StaticProduct.Products/product', compact('product')); ?>
                <?php echo!empty($product[0]) ? $this->element('StaticProduct.Products/product', array('product' => $product[0])) : ''; ?>
            </div>
            <?php if (!empty($product[1])): ?>
                <div class="fl">
                    <?php // echo $this->element('StaticProduct.Products/product', compact('product')); ?>
                    <?php echo!empty($product[1]) ? $this->element('StaticProduct.Products/product', array('product' => $product[1])) : ''; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($product[2])): ?>
            <div class="full clearfix">
                <?php // echo $this->element('StaticProduct.Products/product', compact('product')); ?>
                <?php echo!empty($product[2]) ? $this->element('StaticProduct.Products/product', array('product' => $product[2])) : ''; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div class="categoryBanner fr">
    <?php
    if (!empty($category[0]['ProductsCategory']['img'])):
        echo $this->Html->link($this->Html->image('/files/productscategory/'.$category[0]['ProductsCategory']['img']), !(empty($category[0]['ProductsCategory']['link'])) ? $category[0]['ProductsCategory']['link'] : '#', array('escape' => false));
    else:
        echo $this->Html->link($this->Html->image('layouts/default/kontroluj-swoja-wage.jpg'), '#', array('escape' => false));
    endif;
    ?>
</div>