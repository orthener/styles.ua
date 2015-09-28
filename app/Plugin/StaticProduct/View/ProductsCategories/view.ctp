<?php $this->set('title_for_layout', !empty($categoryName) ? $categoryName : $categoryName = __d('front', 'Produkty')); ?>
<?php
$keywords = Configure::read('Meta.shop_key');
$keywords .= empty($thisCat[0]['ProductsCategory']['metakey']) ? "" : " " . $thisCat[0]['ProductsCategory']['metakey'];
$description = Configure::read('Meta.shop_desc');
$description .= empty($thisCat[0]['ProductsCategory']['metadesc']) ? "" : " " . $thisCat[0]['ProductsCategory']['metadesc'];
echo $this->Html->meta('keywords', $keywords, array('inline' => false));
echo $this->Html->meta('description', $description, array('inline' => false));
?>
<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php if (!empty($this->request->data['Search']['text'])): ?>
    <?php $this->Html->addCrumb(__d('front', 'Wyszukiwarka')); ?>
    <?php $this->Html->addCrumb($this->request->data['Search']['text']); ?>
    <?php
else:
    $this->Html->addCrumb(__d('front', 'Produkty'));
endif;
?>
<div id="product" class="product search view index">
    <div class="row-fluid">
        <div class="breadcrump span8 my-span8 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="brands-filter-background">
        <?php echo $this->element('Products/front_filter'); ?>
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
            <?php if (empty($productCategory)) : ?>
                <h3 style="text-align: center; margin: 30px;"><?php echo __d('front', 'Nie znaleziono produktów spełniających kryteria wyszukiwania.'); ?></h3>
            <?php endif;?>
            <?php if (count($productCategory) <= 12) : ?>
                <span class="hide_next_products" style="display:none;"></span>
            <?php else: ?>
                <?php if (!empty($productCategory[12])) { unset($productCategory[12]); }?>
            <?php endif;?>
            <?php
            foreach ($productCategory as $product):
                echo $this->element('StaticProduct.Products/product', compact('product', 'type'));
            endforeach;
            ?>  
        </div>
        <script type="text/javascript">
            //<![CDATA[
            jQuery('#products .product').click(function() {
                window.location = jQuery(this).attr('href');
            });
            var prod_filter = 'null';
            $('#products-filter a').click(function() {
                $('#products-filter a').removeClass('active');
                prod_filter = $(this).attr('id');
                prod_filter = prod_filter.replace('filter-', '');
                $(this).addClass('active');
                $.ajax({
                    url: '<?php echo $this->Html->url(array('controller' => 'products', 'plugin' => 'static_product', 'action' => 'front_filter')); ?>/' + prod_filter + '/<?php echo $category_id; ?>',
                    dataType: 'html',
                    type: 'POST',
                    data: {
                        data: {
                            filter: prod_filter
                        }
                    },
                    success: function(data) {
                        page = 2;
                        $('#more-products a').show();
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
</div>
<script>
    /**
     * Zeruje tekst do wyszukiwania kiedy chcemy wyszukać bez tego parametru
     * np: po konkretnym producencie
     */
    $('#ProductSearchForm').submit(function() {
        var searchText = $('#SearchText').val();
        if (searchText == "") {
            $('#search_text').val('');
        }
    });
</script>

<?php echo $this->element('StaticProduct.Products/more_products', array('category_id' => $category_id, 'filterData' => serialize($filterData))); ?>