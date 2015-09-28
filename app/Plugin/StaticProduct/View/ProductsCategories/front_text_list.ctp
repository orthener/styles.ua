<?php foreach ($productCategories as $productCategory): ?>
    <li><?php echo $this->Html->link($productCategory['ProductsCategory']['name'], array('plugin' => 'static_product', 'controller' => 'products_categories', 'action' => 'view', $productCategory['ProductsCategory']['slug']), array('id' => $productCategory['ProductsCategory']['id'], 'escape' => false));
    ?></li>
<?php endforeach; ?>
