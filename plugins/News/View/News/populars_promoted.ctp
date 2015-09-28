<div id="products" class="blogProduct productPageFooter">
    <div class="see-more row-fluid">
        <div class="span12 my-span12 bt-no-margin">
            <h3 class="uppercase"><?php echo __d('front', 'Najpopularniejsze produkty'); ?>:</h3>
        </div>
    </div>
    <div class="clearfix row-fluid">
        <?php
        foreach ($popularProducts as $product) {
            echo $this->element('StaticProduct.Products/product', compact('product'));
        }
        ?>
         <?php
        foreach ($promotedOnBlog as $product) {
            echo $this->element('StaticProduct.Products/product', compact('product'));
        }
        ?>
    </div>
</div>
<!--<div id="products" class="blogProduct productPageFooter">

    <div class="clearfix row-fluid">
       
    </div>
</div>-->