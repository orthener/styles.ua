<?php $this->set('title_for_layout', !empty($categoryName) ? $categoryName : $categoryName = 'Produkty'); ?>
<?php $this->Html->addCrumb('Strona główna', '/'); ?>
<?php if (!empty($this->request->data['Search']['text'])): ?>
    <?php $this->Html->addCrumb('Wyszukiwarka'); ?>
    <?php $this->Html->addCrumb($this->request->data['Search']['text']); ?>
    <?php
else:
    $this->Html->addCrumb('Produkty');
endif;
?>
<div id="product" class="product search view index">
    <div class="row-fluid">
        <div class="breadcrump span8 my-span8 bt-no-margin">
            <span class="navi">NAVIGATION:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="brands-filter-background">
        <div id="sorts" class="clearfix">
            <div class="container">
                <div class="sorts row-fluid">
                    <?php // debug($sorts);  ?>
                    <?php
//                    debug($sorts);
                    if (empty($sorts)):
                        $sorts['sort'] = 'name';
                        $sorts['direction'] = 'asc';
                    endif;
                    ?>
                    <div class="span4 my-span4">
                        <h3><?php echo __d('front', 'Sortowanie'); ?>:</h3>
                    </div>
                    <div class="span8 my-span8 bt-no-margin">
                        <div id="sort-gender" class="fr sorter sort-one <?php echo ($sorts['sort'] == 'gender') ? 'active ' . $sorts['direction'] : ''; ?>">
                            <span><br/><?php echo __d('front', 'Płeć'); ?><br/><i class="icon-caret-<?php echo (($sorts['sort'] == 'gender') AND ($sorts['direction'] == 'asc')) ? 'up' : 'down'; ?>"></i></span>
                        </div>
                        <div id="sort-size" class="fr sorter sort-one <?php echo ($sorts['sort'] == 'size') ? 'active ' . $sorts['direction'] : ''; ?>">
                            <span><br/><?php echo __d('front', 'Rozmiar'); ?><br/><i class="icon-caret-<?php echo (($sorts['sort'] == 'size') AND ($sorts['direction'] == 'asc')) ? 'up' : 'down'; ?>"></i></span>
                        </div>
                        <div id="sort-price" class="fr sorter sort-one <?php echo ($sorts['sort'] == 'price') ? 'active ' . $sorts['direction'] : ''; ?>">
                            <span><br/><?php echo __d('front', 'Cena'); ?><br/><i class="icon-caret-<?php echo (($sorts['sort'] == 'price') AND ($sorts['direction'] == 'asc')) ? 'up' : 'down'; ?>"></i></span>
                        </div>
                        <div id="sort-color" class="fr sorter sort-one <?php echo ($sorts['sort'] == 'color') ? 'active ' . $sorts['direction'] : ''; ?>">
                            <span><br/><?php echo __d('front', 'Kolor'); ?><br/><i class="icon-caret-<?php echo (($sorts['sort'] == 'color') AND ($sorts['direction'] == 'asc')) ? 'up' : 'down'; ?>"></i></span>
                        </div>
                        <div class="fr sort-one other-brands">
                            <span><?php echo __d('front', 'inne'); ?><br/><?php echo __d('front', 'marki'); ?><br/><i class="icon-caret-down"></i></span>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    //<![CDATA[
                    $('.sorter').click(function() {
                        var sort = 'name';
                        var dir = 'asc';
                        sort = $(this).attr('id');
                        sort = sort.replace('sort-', '');
                        if ($(this).hasClass('desc')) {
//                            $(this).removeClass('active');
//                            $(this).find('i').addClass('icon-caret-down').removeClass('icon-caret-up');
                            window.location.href = "<?php echo $this->Html->url('view/'.$thisCategorySlug.'/' . (!empty($this->request->data['Search']['text']) ? '/' . $this->request->data['Search']['text'] : ''), true); ?>/sort:" + sort + "/direction:" + dir;
                        }
                        else {
//                            $(this).addClass('active');
//                            $(this).find('i').removeClass('icon-caret-down').addClass('icon-caret-up');
                            dir = 'desc';
                            window.location.href = "<?php echo $this->Html->url('view/'.$thisCategorySlug.'/' . (!empty($this->request->data['Search']['text']) ? '/' . $this->request->data['Search']['text'] : ''), true); ?>/sort:" + sort + "/direction:" + dir;
                        }
                    });
                    //]]>
                </script>
                <div class="sorts sorts-slide row bt-no-margin dn">
                    <div class="span12 bt-no-margin">
                        <?php echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'brand', 'controller' => 'brands', 'action' => 'brands_front', 0, 50)); ?>
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

            $('#products-filter a').click(function() {
                $('#products-filter a').removeClass('active');
                var prod_filter = $(this).attr('id');
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