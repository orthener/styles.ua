<?php foreach($products as $product):?>    
    <div class="borderBottomBox">
        <div class="clearfix brandPrice">
            <?php $productlink = array('plugin' => 'static_product', 'controller' => 'products', 'action' => 'view', $product['Product']['slug']); ?>
            <?php echo $this->Image->thumb('/files/photo/' . $product['Photo']['img'], array('width' =>78, 'height' => 78 ,'frame'=>'#ffffff'), array('url'=> $productlink, 'class' => 'fl')); ?>
            <span><?php echo $this->FebNumber->currency($product['Product']['price'], ' ₴');?></span>
            <?php //echo $this->Html->image('tmp/brand.jpg', array('class' => 'fr')); ?>
        </div>
        <b><?php echo $this->Html->link($product['Product']['title'], $productlink); ?></b><br />
        <?php echo String::truncate(strip_tags($product['Product']['content']), 100); ?>
        <div class="textRight">
            <?php echo $this->Html->link(__d('front', 'Kaufen') . '&nbsp;»', array('plugin' => 'commerce', 'controller' => 'order_items', 'action' => 'add', $product['Product']['id']), array('escape' => false)); ?>
        </div>
    </div>  



<?php endforeach; ?>