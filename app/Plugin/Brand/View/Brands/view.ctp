<?php $this->set('title_for_layout', $brand['Brand']['name']); ?>
<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb($brand['Brand']['name']); ?>
<?php 
$keywords = Configure::read('Meta.shop_key');
$keywords .= empty($brand['Brand']['metakey']) ? "" : " " . $brand['Brand']['metakey'];
$description = Configure::read('Meta.shop_desc');
$description .= empty($brand['Brand']['metadesc']) ? "" : " " . $brand['Brand']['metadesc'];

echo $this->Html->meta('keywords', $keywords, array('inline' => false));
echo $this->Html->meta('description', $description, array('inline' => false)); 
?>
<div id="product" class="product view index brand-view">
    <div class="row-fluid">
        <div class="breadcrump span8 my-span8 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="products-info row-fluid">
        <div class="span8 my-span8 bt-no-margin foto">
            <?php echo $this->Image->thumb('/files/brand/' . $brand['Brand']['img2'], array('width' => 780, 'height' => 360), array('valign' => 'middle')); ?>
        </div>
        <div class="span4 my-span4 bt-no-margin description">
<!--            <div class="brand">
                <?php echo $this->Image->thumb('/files/brand/' . $brand['Brand']['img'], array('width' => 100, 'height' => 100), array('valign' => 'middle')); ?>
            </div>-->
            <div class="text-social">
                <p>
                    <?php echo strip_tags($brand['Brand']['desc']); ?>
                </p>
                <!--+ encodeURIComponent(location.href)-->
                <div class="social-share">
                    <span><?php echo __d('front', 'Podziel się'); ?>: </span>     
                    <a href="#" class="twitter-button" onclick="window.open(
                                    'https://twitter.com/share?url=<?php echo $this->Html->url(null, true); ?>',
                                    'twitter-share-dialog',
                                    'width=626,height=436');
                            return false;">Tweet</a>
                    <a href="#" class="facebook-button" onclick="window.open(
                                    'https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->Html->url(null, true); ?>',
                                    'facebook-share-dialog',
                                    'width=626,height=436');
                            return false;">Facebook</a>
                    <a href="#"  class="vk-button" onclick="window.open(
                                    'http://vkontakte.ru/share.php?url=<?php echo $this->Html->url(null, true); ?>',
                                    'facebook-share-dialog',
                                    'width=626,height=436');
                            return false;">VK</a>
                </div>
            </div>
        </div>
    </div>
    <div class="brands-filter-background">
        <?php echo $this->element('StaticProduct.Products/front_filter'); ?>
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
            echo $this->Html->requestAction(array(
                'admin' => false,
                'plugin' => 'static_product',
                'controller' => 'products',
                'action' => 'front', $brand['Brand']['id']
            ));
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
                window.prod_filter = prod_filter.replace('filter-', '');
                window.page = 2;
                $(this).addClass('active');
                $.ajax({
                    url: '<?php echo $this->Html->url(array('admin' => false, 'controller' => 'products', 'plugin' => 'static_product', 'action' => 'front')); ?>',
                    dataType: 'html',
                    type: 'POST',
                    data: {
                        data: {
                            filter: window.prod_filter,
                            brand: <?php echo $brand['Brand']['id'] ?>
                        }
                    },
                    success: function(data) {
                        $('#products').html(data);
                        $('#more-products a').show();
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
    $(document).ready(function() {
<?php if (!empty($brand_filter)) : ?>
            $('html, body').animate({
                scrollTop: $("#sorts").offset().top
            }, 300);
<?php endif; ?>
//        $('.categoriesMenu').find('.categoriesList').show();
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
<?php echo $this->element('StaticProduct.Products/more_products', array('brand_id' => $brand['Brand']['id'], 'filterData' => serialize($filterData))); ?>