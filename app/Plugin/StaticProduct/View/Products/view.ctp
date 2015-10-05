<?php $this->set('title_for_layout', $product['Product']['title']); ?>
<?php echo $this->Html->script('jquery.cycle.all', array('inline' => false)); ?>
<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php
if (!empty($productCategories['ProductsCategory'])) :
    $productCatUrl = array('plugin' => "static_product", "controller" => "products_categories", "action" => "view", $productCategories['ProductsCategory']['slug']);
    $this->Html->addCrumb($productCategories['ProductsCategory']['name'], $productCatUrl);
endif;
$this->Html->addCrumb($product['Brand']['name'], array('plugin' => 'brand', 'controller' => 'brands', 'action' => 'view', $product['Brand']['slug']));
?>
<?php $this->Html->addCrumb($product['Product']['title']); ?>
<?php
$keywords = Configure::read('Meta.shop_key');
$keywords .= empty($product['ProductsCategory'][0]['metakey']) ? "" : " " . $product['ProductsCategory'][0]['metakey'];
$keywords .= empty($product['Brand']['metakey']) ? "" : " " . $product['Brand']['metakey'];
$keywords .= empty($product['Product']['metakey']) ? "" : " " . $product['Product']['metakey'];
$description = Configure::read('Meta.shop_desc');
$description .= empty($product['ProductsCategory'][0]['metadesc']) ? "" : " " . $product['ProductsCategory'][0]['metadesc'];
$description .= empty($product['Brand']['metadesc']) ? "" : " " . $product['Brand']['metadesc'];
$description .= empty($product['Product']['metadesc']) ? "" : " " . $product['Product']['metadesc'];

echo $this->Html->meta('keywords', $keywords, array('inline' => false));
echo $this->Html->meta('description', $description, array('inline' => false));
?>

<div id="product" class="product view">
    <div class="row-fluid">
        <div class="breadcrump span8 my-span8 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="productPage clearfix" itemtype="http://schema.org/Product" itemscope="">
        <div class="productPageTop row-fluid">
            <div class="span8 my-span8 bt-no-margin">
                <div id="mainImg"  class="gallery dn">
                    <?php
                    if (!empty($product['Photo']['img']) && isset($product['Photo']['img'])) {
                        echo $this->Html->link(
//                                $this->Image->thumb('/files/photo/' . $product['Photo']['img'], array('width' => 780, 'height' => 650, 'frame' => '000')), '/files/photo/' . $product['Photo']['img'], array('rel' => 'galeria', 'escape' => false));
                                $this->Image->thumb('/files/photo/' . $product['Photo']['img'], array('width' => 590, 'height' => 700)), '/files/photo/' . $product['Photo']['img'], array('rel' => 'galeria', 'escape' => false));
                    } elseif (!empty($product['Photos'][0]['img']) && isset($product['Photos'][0]['img'])) {
                        echo $this->Html->div('fl', $this->Html->link(
//                                        $this->Image->thumb('/files/photo/' . $product['Photos'][0]['img'], array('width' => 780, 'height' => 650, 'frame' => '#000')), '/files/photo/' . $product['Photos'][0]['img'], array('rel' => 'galeria', 'escape' => false)), array('escape' => false));
                                        $this->Image->thumb('/files/photo/' . $product['Photos'][0]['img'], array('width' => 590, 'height' => 700)), '/files/photo/' . $product['Photos'][0]['img'], array('rel' => 'galeria', 'escape' => false)), array('escape' => false));
                    } else {
                        echo $this->Image->thumb('/img/layouts/default/blank.png', array('width' => 780, 'height' => 650, 'frame' => '#000'));
                    }
                    ?>
                </div>
                <div id="imgPager" class="minis  clearfix">
                    <?php // debug(count($product['Photos']));  ?>
                    <div class="galleryThumbs clearfix">
                        <?php
                        if (!empty($product['Photos'])):
                            foreach ($product['Photos'] as $item) {
                                if (!empty($item['img'])):
                                    echo $this->Html->div('fl thumbImg galImgCount', $this->Html->link(
//                                                    $this->Image->thumb('/files/photo/' . $item['img'], array('width' => 780, 'height' => 650, 'frame' => '#000'), array('itemprop' => 'image')), '/files/photo/' . $item['img'], array('class' => '', 'escape' => false)));
                                                    $this->Image->thumb('/files/photo/' . $item['img'], array('width' => 590, 'height' => 700), array('itemprop' => 'image')), '/files/photo/' . $item['img'], array('class' => '', 'escape' => false)));
                                endif;
                            }
                        endif;
                        ?>
                    </div>
                    <div id="PagerNavi">
                        <span class="leftNavi"></span>
                        <span class="descNavi"><?php echo __d('front', 'Kliknij w strzałki lub zdjęcie aby zobaczyć więcej!'); ?></span>
                        <span class="rightNavi"></span>
                    </div>
                </div>
            </div>
            <div class="productDescription span4 my-span4 bt-no-margin">
                <?php
                $productBuy = array('controller' => 'order_items', 'plugin' => 'commerce', 'action' => 'add');
                echo $this->Form->create('OrderItem', array('url' => $productBuy));
                ?>
                <div class="product-info clearfix">
                    <div class="logoProduct">
                        <?php // $img = $this->Image->thumb('/files/brand/' . $product['Brand']['img'], array('width' => 100, 'height' => 100, 'frame' => '#000'), array('valign' => 'middle')); ?>
                        <?php $img = $this->Html->Image('/files/brand/' . $product['Brand']['img'], array('valign' => 'middle')); ?>

                        <?php echo $this->Html->link($img, array('plugin' => 'brand', 'controller' => 'brands', 'action' => 'view', $product['Brand']['slug'])); ?>
                    </div>
                    <h3 class="uppercase" itemprop="name"><?php echo $product['Product']['title']; ?></h3>
                    <!--                    <div class="brand">
                    <?php // $img = $this->Image->thumb('/files/brand/' . $product['Brand']['img'], array('width' => 60, 'height' => 60), array('valign' => 'middle'));  ?>
                    
                    <?php // echo $this->Html->link($img, array('plugin' => 'brand', 'controller' => 'brands', 'action' => 'view', $product['Brand']['slug']));  ?>
                                        </div>-->
                    <div id="less">
                        <?php echo $this->Text->truncate($product['Product']['content'], 150); ?>
                    </div>
                </div>
                <script type="text/javascript">
                    var elem = $('#less');
                    // Configure/customize these variables.
                    var ellipsestext = "...";
                    var moretext = '&nbsp;&nbsp;<a class="full-description-off"><?php echo __d('front', 'Zwiń opis'); ?> <i class="icon-caret-up"></i></a>';
                    var lesstext = '&nbsp;&nbsp;<a class="full-description"><?php echo __d('front', 'Pełny opis'); ?> <i class="icon-caret-down"></i></a>';

                    var less_content = elem.html();
                    var full_content = '<?php echo $product['Product']['content']; ?>';

                    if(full_content.length > less_content.length) {
                        elem.children().append(lesstext);
                    }

                    jQuery(document).ready(function($) {
                        $('#less').on('click', '.full-description', function(e){
                            e.preventDefault();
                            elem.html(full_content + moretext);
                        });
                        $('#less').on('click', '.full-description-off', function(e){
                            e.preventDefault();
                            elem.html(less_content).children().append(lesstext);
                        });
                    });
                </script>
                <div class="product-more-info clearfix">
                    <?php echo $product['Product']['producer']; ?><br/>
                    <?php echo __d('front', 'Art no. '); ?><?php echo $product['Product']['code']; ?><br/>
                    <?php echo __d('front', 'Czas realizacji'); ?>: <?php echo $product['Product']['execution_time']; ?>
                    <br/><br/>
                    <?php // echo $product['Product']['color']; ?>
                    <?php
                    echo $this->Form->hidden('product_model', array('value' => 'Product'));
                    echo $this->Form->hidden('product_id', array('value' => $product['Product']['id']));
                    echo $this->Form->input('quantity', array('label' => __d('front', 'Ilość') . ':', 'default' => 1));

                    // Jeśli produkt jest rozmiarowy
                    if (!empty($product['Product']['sized'])) {
                        $sizes = empty($sizes) ? array(0) : $sizes;
                        if (!is_array($sizes)) {
                            $sizes = array(0);
                        }
                        echo $this->Form->input('sizes', array('label' => __d('front', 'Rozmiar') . ':', 'options' => $sizes));
                        echo $this->Form->hidden('size', array('type' => 'text', 'value' => reset($sizes)));
                        echo '<div style="display:none;">' . $this->Form->input('sizes_quantity', array('label' => 'Ilości', 'options' => $sizes_quantity)) . '</div>';
//                        debug($sizes_quantity);
                    }
                    // Jeśli nie jest rozmiarowy
                    else {
                        echo $this->Form->hidden('max_quantity', array('label' => __d('front', 'Ilość') . ':', 'value' => $product['Product']['quantity']));
                        echo $this->Form->hidden('size', array('type' => 'text', 'value' => 0));
                    }
                    ?>
                    <script type="text/javascript">
                        //<![CDATA[
                        jQuery(document).ready(function() {
                            jQuery('.product-more-info select').select2({
                                minimumResultsForSearch: 50
                            });

                            $('#OrderItemSizes').change(function() {
                                $('#OrderItemSize').val($('#OrderItemSizes option:selected').text());
                                checkQuantitySize();
                            });
                            $('#OrderItemQuantity').change(function() {
                                checkQuantitySize();
                            });

                            function checkQuantitySize() {
                                if ($('#OrderItemSizes').length > 0) {
                                    max_quantity = parseInt($('#OrderItemSizesQuantity option[value="' + $('#OrderItemSizes').val() + '"]').text());
                                    if (parseInt($('#OrderItemQuantity').val()) > max_quantity) {
                                        FEB.ui.flashMessage.setFlash('<?php echo __d('front', 'Maksymalna ilość produktów w tym rozmiarze wynosi '); ?>' + max_quantity, 'error', 3000);
                                        $('#OrderItemQuantity').val(max_quantity);
                                    }
                                }
                                else {
                                    if (parseInt($('#OrderItemQuantity').val()) > parseInt($('#OrderItemMaxQuantity').val())) {
                                        FEB.ui.flashMessage.setFlash('<?php echo __d('front', 'Maksymalna ilość produktów w tym rozmiarze wynosi '); ?>' + $('#OrderItemMaxQuantity').val(), 'error', 3000);
                                        $('#OrderItemQuantity').val($('#OrderItemMaxQuantity').val());
                                    }
                                }
                            }
                        });
                        //]]>
                    </script> 
                </div>
                <div class="product-price-and-add clearfix">
                    <?php if (empty($product['ProductsPromotion']['price'])): ?>
                        <span class="price uppercase fl"><?php echo __d('front', 'Cena') . ':' ?>
                            <span class="cena"><?php echo $this->FebNumber->currency($product['Product']['price'], ' ₴'); ?></span>
                        </span>
                    <?php else: ?>
                        <span class="price uppercase fl">
                            <?php echo __d('front', 'Cena') . ':' ?>
                            <span class="cena" style='text-decoration: line-through; color: #999999'>
                                <?php echo $this->FebNumber->currency($product['Product']['price'], ' ₴'); ?>
                            </span>
                            <span style="margin-left: 20px;" class="cena"><?php echo $this->FebNumber->currency($product['ProductsPromotion']['price'], ' ₴'); ?></span>
                        </span>
                    <?php endif; ?>
                    <?php echo $this->Form->submit(__d('front', 'Dodaj do koszyka'), array('class' => 'button white radius')); ?>
                </div>
                <div class='size-problem'>
                    <strong><?php echo __d('front', 'Problem z rozmiarem?'); ?></strong>
                    <p>
                        <?php echo __d('front', 'Masz problem z wyborem rozmiaru?'); ?><br />
                        <?php echo __d('front', 'Sprawdź jak mierzymy nasze'); ?> <br />
                        <?php echo __d('front', 'produkty klikając po prawej'); ?>
                    </p>
                    <?php // echo $this->Html->link($this->Html->image('layouts/default/size.png'), array('plugin' => 'page', 'controller' => 'pages', 'action' => 'view_ajax', 'rozmiary'), array('class' => 'rozmiary')); ?>
                    <?php // echo $this->Html->link($this->Html->image('layouts/default/size.png'), array('plugin' => 'page', 'controller' => 'pages', 'action' => 'view', 'tablica-razmerov'), array('class' => 'rozmiary')); ?>
                    <?php echo $this->Html->link($this->Html->image('layouts/default/size.png'), array('plugin' => 'page', 'controller' => 'pages', 'action' => 'view', 'tablica-razmerov'), array('class' => 'rozmiary')); ?>
                    <?php
                    $this->Fancybox->init('$(".rozmiary")', array('type' => 'ajax'), true);
                    ?>
                </div>
                <div class="shimpent-info">
                    <strong><?php echo __d('front', 'Informacje o wysyłce'); ?>:</strong>
                    <p>
                        <?php echo __d('front', 'Delivery inside Europe within 1-3 Days with UPS!'); ?><br/>
                        <?php echo __d('front', 'VISA/MC or Paypal secure payments.'); ?>
                    </p>
                </div>
                
                <!-- Put this div tag to the place, where the Like block will be -->
                <div id="vk_like"></div>
                <script type="text/javascript">
                    VK.Widgets.Like("vk_like", {type: "mini", verb: 1});
                </script>
                <?php echo $this->Form->end(); ?>
            </div>
            <?php //debug($product); // $product['ProductsPromotion']['price'] = 11.99;     ?>
            <div class="fr">
                <!--<div class="staraCena"><?php // echo $product['ProductsPromotion']['price'] ? 'stara cena: <span itemprop="price">' . $product['Product']['price'] * (1 + $product['Product']['tax']) . ' zł</span>' : '&nbsp;';                                   ?></div>-->
                <!--<div class="nowaCena"><?php // echo!empty($product['ProductsPromotion']['price']) ? 'nowa ' : '';                              ?>cena: <span itemprop="price"><?php // echo $product['ProductsPromotion']['price'] ? $product['ProductsPromotion']['price'] * (1 + $product['Product']['tax']) : $product['Product']['price'] * (1 + $product['Product']['tax'])                              ?>  zł</span></div>-->
                <!--<span class="dn" itemprop="currency">PLN</span>-->
            </div>
        </div>
    </div>  
    <?php if (!empty($simiarProducts)): ?>
        <div id="products" class="productPageFooter">
            <div class="see-more row-fluid">
                <div class="span4 my-span4 bt-no-margin">
                    <h3 class="uppercase"><?php echo __d('front', 'Zobacz także'); ?>:</h3>
                </div>
                <div class="span8 my-span8 bt-no-margin">
                </div>
            </div>
            <!--<div class="clearfix row-fluid">-->
            <?php
            foreach ($simiarProducts as $product) {
                echo $this->element('StaticProduct.Products/product', compact('product'));
            }
            ?>
            <!--</div>-->
        </div>
        <script type="text/javascript">
            //<![CDATA[
            jQuery('#products .product').click(function() {
                window.location = jQuery(this).attr('href');
            });
            //]]>
        </script>
    <?php endif; ?>

</div>
<div id="more-products">
    <?php if ($category_id) : ?>
        <?php echo $this->Html->link('<span>' . __d('front', 'Kolejne produkty') . '</span> <i class="icon-caret-down"></i>', '#more', array('escape' => false)); ?>
        <?php // echo $this->Html->link('<span>Kolejne produkty</span> <i class="icon-caret-down"></i>', array('controller' => 'products_categories', 'action' => 'view', $category_id), array('escape' => false)); ?>
    <?php endif; ?>
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
<?php
$this->Fancybox->init('jQuery(".gallery a")');
?>
<?php echo $this->element('StaticProduct.Products/more_products', array('category_id' => $category_id_int, 'page' => 2)); ?>