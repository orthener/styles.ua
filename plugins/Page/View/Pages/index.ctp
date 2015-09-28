<?php
echo $this->Html->script('jquery.cycle.all', array('inline' => false));
echo $this->Html->meta('keywords', Configure::read('Meta.shop.key'), array('inline' => false));
echo $this->Html->meta('description', Configure::read('Meta.shop.desc'), array('inline' => false));

if (Configure::read('Meta.shop.title')) {
    $this->set('title_for_layout', Configure::read('Meta.shop.title')); 
}
else {
    $this->set('title_for_layout', __d('cms', 'Strona główna')); 
}

$this->set('isFront', true);
?>
<div class="container">
    <div class="row-fluid">
        <?php echo $this->Html->requestAction(array('plugin'=>'slider', 'controller'=>'sliders','action'=>'front', 'admin'=>false)); ?>
        <div class="banner">
            <?php echo $this->Html->image('/img/layouts/default/banner-kalkulator.jpg', array('url' => array('plugin' => false, 'controller' => 'calculators', 'action' => 'index'))); ?>
        </div>
    </div>
</div>
<?php if (empty($disable_banners)): ?>
<div id="categories" class="clearfix">
    <div class="content">
        <div class="categoriesMenu">
            <?php echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'banner', 'controller' => 'banners', 'action' => 'front_list')); ?>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="brands-filter-background">
    <div id="main-brands" class="clearfix">
        <div class="container">
            <div class="main-brands row-fluid">
                <div class="span4 my-span4">
                    <h3><?php echo __d('front', 'Czołowe marki'); ?>:</h3>
                </div>
                <div class="span8 my-span8 bt-no-margin">
                    <?php echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'brand', 'controller' => 'brands', 'action' => 'brands_front', 8, 0)); ?>
                    <div class="fr other-brands">
                        <span><?php echo __d('front', 'inne'); ?><br/><?php echo __d('front', 'marki'); ?><br/><i class="icon-caret-down"></i></span>
                    </div>
                </div>
            </div>
            <div class="main-brands brands-slide  row bt-no-margin dn">
                <div class="span12 bt-no-margin">
                    <?php echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'brand', 'controller' => 'brands', 'action' => 'brands_front', 50, 8)); ?>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        //<![CDATA[
        jQuery('.other-brands').on('click', function() {
            jQuery(this).parent().parent().parent().toggleClass('active');
        });
        //]]>
    </script>
    <div id="products-filter">
        <div class="container">
            <div class="row-fluid">
                <a class="span4 bt-no-margin" id="filter-popular" href="#popular"><?php echo __d('front', 'Popularne'); ?></a>
                <a class="span4 bt-no-margin" id="filter-promoted" href="#new"><?php echo __d('front', 'Nowości'); ?></a>
                <a class="span4 bt-no-margin" id="filter-sale" href="#sale"><?php echo __d('front', 'Wyprzedaż'); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div id="products" class="clearfix">
        <?php // echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'static_product', 'controller' => 'products', 'action' => 'front')); ?>  
        <?php
        echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'static_product', 'controller' => 'products', 'action' => 'front', 'sort' => 'price', 'direction' => 'asc'));
        ?>
    </div>
    <script type="text/javascript">
        //<![CDATA[
        jQuery('#products .product').click(function() {
            window.location = jQuery(this).attr('href');
        });


        $('#products-filter a').click(function() {
            $('#products-filter a').removeClass('active');
            var prod_filter = $(this).attr('id');
            prod_filter = prod_filter.replace('filter-', '');
            $(this).addClass('active');
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'products', 'plugin' => 'static_product', 'action' => 'front_filter')); ?>/' + prod_filter,
                dataType: 'html',
                type: 'POST',
                data: {
                    data: {
                        filter: prod_filter
                    }
                },
                success: function(data) {
                    $('#products').html(data);
                },
                error: function(o1, o2, o3, o4) {

                }
            });
        });


        //]]>
    </script>
    <div id="more-products">
        <?php echo $this->Html->link('<span>'.  __d('front', 'Kolejne produkty').'</span> <i class="icon-caret-down"></i>', '#more', array('escape' => false)); ?>
        <?php //echo $this->Html->link('<span>Kolejne produkty</span> <i class="icon-caret-down"></i>', array('controller' => 'products', 'plugin' => 'static_product', 'action' => 'index'), array('escape' => false)); ?>
    </div>
</div>

<div class="container">
    <div id="last-on-blog">
        <div class="row-fluid">
            <div class="span4 my-span4 bt-no-margin title">
                <h3><?php echo __d('front', 'Ostatnio na blogu'); ?>:</h3>
            </div>
            <?php echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'news', 'controller' => 'news', 'action' => 'news_front')); ?>
        </div>
    </div>
</div>

<?php echo $this->element('StaticProduct.Products/more_products', array('page' => 2)); ?>



