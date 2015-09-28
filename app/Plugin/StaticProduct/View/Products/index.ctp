<?php $this->set('title_for_layout', !empty($categoryName) ? $categoryName : $categoryName = __d('front', 'Produkty')); ?>
<?php $this->Html->addCrumb(__d('front', 'Strona główna'), '/'); ?>
<?php if (!empty($this->request->data['Search']['text'])): ?>
    <?php $this->Html->addCrumb(__d('front', 'Wyszukiwarka')); ?>
    <?php $this->Html->addCrumb($this->request->data['Search']['text']); ?>
    <?php
else:
    $this->request->data['Search']['text'] = 0;
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
            <?php if (empty($products)) : ?>
                <h3 style="text-align: center; margin: 30px;"><?php echo __d('front', 'Nie znaleziono produktów spełniających kryteria wyszukiwania.'); ?></h3>
            <?php endif;?>
            <?php if (!empty($products) && count($products) < 12) : ?>
                <span class="hide_next_products" style="display:none;"></span>
            <?php else: ?>
                <?php if (!empty($products[12])) { unset($products[12]); }?>
            <?php endif;?>
            <?php
            if (empty($products)) {
                $products = array();
            }
            foreach ($products as $product):
                echo $this->element('StaticProduct.Products/product', compact('product', 'type'));
            endforeach; 
//            echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'static_product', 'controller' => 'products', 'action' => 'front', 'filterData' => serialize($filterData), 'sort' => (!empty($sorts['sort']) ? $sorts['sort'] : 'title'), 'direction' => (!empty($sorts['direction']) ? $sorts['direction'] : 'asc')));
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
                    url: '<?php echo $this->Html->url(array('controller' => 'products', 'plugin' => 'static_product', 'action' => 'front_filter')); ?>/' + prod_filter + '/',
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
            <?php echo $this->Html->link('<span>'.__d('front', 'Kolejne produkty').'</span> <i class="icon-caret-down"></i>', '#more', array('escape' => false)); ?>
        </div>
    </div>

</div>


<script>
    $(document).ready(function() {

    });

</script>

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

<?php echo $this->element('StaticProduct.Products/more_products', array('filterData' => serialize($filterData), 'text_name' => $this->request->data['Search']['text'])); ?>
<?php // echo $this->element('StaticProduct.Products/more_products', array('filterData' => serialize($filterData))); ?>
