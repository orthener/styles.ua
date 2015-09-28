<?php if (empty($products) && empty($this->params['named']['page'])) : ?>
    <h3 class="no_products" style="text-align: center; margin: 30px;"><?php echo __d('front', 'Nie znaleziono produktów spełniających kryteria wyszukiwania.'); ?></h3>
<?php endif;?>
<?php if (count($products) < 12 && ($this->params['paging']['Product']['page'] >= $this->params['paging']['Product']['pageCount'])) : ?>
    <span class="hide_next_products" style="display:none;">11</span>
<?php endif;?>
    
<?php
//debug($products);
//$type = $type;
foreach ($products as $product):
    echo $this->element('StaticProduct.Products/product', compact('product','type'));
endforeach;


?> 

    
    