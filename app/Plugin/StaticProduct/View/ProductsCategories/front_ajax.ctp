<div class="half clearfix">
<?php
foreach ($products as $product):
    echo $this->element('StaticProduct.Products/product', compact('product', 'type'));
endforeach;
?>
</div>