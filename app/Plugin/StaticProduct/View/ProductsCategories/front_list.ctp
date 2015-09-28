<?php 
foreach ($productCategories as $productCategory): ?>
    <?php $img = '<span class="green-flag"></span>'.$this->Html->image('/files/productscategory/' . $productCategory['ProductsCategory']['img']); ?>
    <?php echo $this->Html->link($img, array('plugin' => 'static_product', 'controller' => 'products_categories', 'action' => 'view', $productCategory['ProductsCategory']['slug']), 
    	array('id' => $productCategory['ProductsCategory']['id'], 'escape' => false));
    ?>
<?php endforeach; ?>
