<?php echo $this->Html->css('/static_product/css/staticProduct', null, array('inline' => false)); ?>
<?php echo $this->Html->css('/static_product/css/skin/ui.dynatree', null, array('inline' => false)); ?>
<?php echo $this->Html->script('/static_product/js/jquery.cookie', array('inline' => false)); ?>
<?php echo $this->Html->script('/static_product/js/jquery.dynatree', array('inline' => false)); ?>

<?php $this->set('title_for_layout', __d('cms', 'List') . ' &bull; ' . __d('cms', 'Product Categories')); ?>

<div class="clearfix">
    <div class="productCategories index">
        <h2><span></span><?php echo __d('cms', 'Product Categories'); ?></h2>
        <div id="ProductsCategoryTree">

        </div>
    </div>
    <div id="Products" class="products index">     
        <?php //echo $this->Element('Products/table_index'); ?> 
    </div>
</div>

<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'New Product Category'), array('action' => 'add'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
<script type="text/javascript">
    $("#ProductsCategoryTree").dynatree({
        persist: true,
        autoCollapse: false,
        initAjax: {
            url: "<?php echo $this->Html->url(array('controller' => 'product_categories', 'action' => 'reload')); ?>"
        },
        onActivate: function(node) {    
        },
        onCreate: function(node, span){
        }
    });
</script>