<div id="sorts" class="clearfix">
    <?php echo $this->Form->create('Product'); ?>
    <div class="container">
        <div class="sorts row-fluid">
            <?php
            if (empty($sorts)):
                $sorts['sort'] = 'name';
                $sorts['direction'] = 'asc';
            endif;
            ?>

                        <div class="span4 my-span4">
                            <h3><?php echo __d('front', 'Filtrowanie'); ?>:</h3>
                        </div>            
            <?php if (!empty($this->request->data['Search']['text'])) : ?>
                 <input style="display:none;" type="hidden" value="<?php echo $this->request->data['Search']['text'];?>" id="SearchText" name="data[Search][text]"/> 
            <?php endif;?>
            <div class="span8 my-span8 bt-no-margin">               
<!--                <div class="fr sort-one submit_form">
                    <span><br/>Filtruj<br/><i class="icon-caret-down"></i></span>
                </div>-->
                <div class="fr sort-one filter-gender">
                    <span><br/><?php echo __d('front', 'Płeć'); ?><br/><i class="icon-caret-down"></i></span>
                </div>
                <div class="fr sort-one filter-size">
                    <span><br/><?php echo __d('front', 'Rozmiar'); ?><br/><i class="icon-caret-down"></i></span>
                </div>
                <div class="fr sort-one filter-price">
                    <span><br/><?php echo __d('front', 'Cena'); ?><br/><i class="icon-caret-down"></i></span>
                </div>
                <div class="fr sort-one other-brands">
                    <span><br /><?php echo __d('front', 'inne marki'); ?><br/><i class="icon-caret-down"></i></span>
                </div>
            </div>
        </div>
        <div id="filter-brands" class="sorts sorts-slide row bt-no-margin dn">
            <div class="span12 bt-no-margin">
                <?php echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'brand', 'controller' => 'brands', 'action' => 'brands_front', 0, 50)); ?>
            </div>
        </div>
        <div id="filter-price" class="sorts sorts-slide row bt-no-margin dn">
            <div class="span12 bt-no-margin">
                <div class="priceControl">
                    <input type="text" id="price_from" name="price_from" value='<?php
                    if (!empty($this->request->data['price_from'])) {
                        echo $this->request->data['price_from'];
                    }
                    ?>'>
                    <input type="text" id="price_to" name="price_to" value='<?php
                    if (!empty($this->request->data['price_to'])) {
                        echo $this->request->data['price_to'];
                    }
                    ?>'>
                </div>
                <div class="fr mr">
                    <h5><?php echo __d('front', 'Cena'); ?>:</h5>
                    <div class="priceSlider">
                        <input type="text" id="sliderPrice" />
                    </div>
                    <button type="button" class="showFiltr" id="submit_form_price" style="margin-top: 27px"><?php echo __d('front', 'pokaż'); ?></button>
                    <script type="text/javascript">
                        
                        $(document).ready(function() {
                            $("#sliderPrice").ionRangeSlider({
                                min: 0,
                                max: <?php echo $price_max; ?>,
                                from: 0,
                                to: 0,
                                type: 'double',
                                step: 10,
                                postfix: " ₴ ",
                                prettify: true,
                                hasGrid: false,
                                hideMinMax: true,
                                hideFromTo: true
                            });                            
                        });
                    </script>
                </div>
                
            </div>
        </div>
        <div id="filter-size" class="sorts sorts-slide row bt-no-margin dn">
            <div class="span12 bt-no-margin">
                <div class="fr mr">
                    <h5><?php echo __d('front', 'Wybierz rozmiar'); ?>:</h5>                    
                    <?php foreach ($sizes as $size) :?>
                        <div class="input checkbox <?php if (!empty($this->request->data['Product']['size'][$size])) echo 'checked'; ?>">
                            <?php echo $size;?>                            
                            <input <?php if (!empty($this->request->data['Product']['size'][$size])) echo 'checked'; ?> class="sizeInput" type="checkbox" name="data[Product][size][<?php echo $size; ?>]" value="<?php echo $size;?>" name="<?php echo $size;?>" <?php
                            if (!empty($this->request->data[$size])) {
                                echo "CHECKED";
                            }
                            ?>> 
                        </div> 
                    <?php endforeach; ?>
                    
                
                    <button type="button" class="showFiltr"><?php echo __d('front', 'pokaż'); ?></button>
                </div>
                <!--                <div class="input text">
                                    <label for="size">Rozmiar:</label>
                                    <input type="text" id="size" name="size" value='<?php
                if (!empty($this->request->data['size'])) {
                    echo $this->request->data['size'];
                }
                ?>'>
                                </div>-->
            </div>
        </div>
        <div id="filter-gender" class="sorts sorts-slide row bt-no-margin dn">
            <div class="span12 bt-no-margin">
                <div class="fr mr gender_filter">
                    <h5><?php echo __d('front', 'Płeć'); ?>:</h5>
                    <div class="input checkbox <?php if (!empty($this->request->data['woman'])) echo 'checked'; ?>">
                        <?php echo __d('front', 'Kobieta'); ?>
                        <input type="checkbox" value="w" id="woman" name="woman" <?php
                        if (!empty($this->request->data['woman'])) {
                            echo "CHECKED";
                        }
                        ?>> 
                    </div>
                    <div class="input checkbox <?php if (!empty($this->request->data['man'])) echo 'checked'; ?>">
                        <?php echo __d('front', 'Mężczyzna'); ?>
                        <input type="checkbox" value="m" id="man" name="man" <?php
                        if (!empty($this->request->data['man'])) {
                            echo "CHECKED";
                        }
                        ?>>
                    </div>
                    <div class="input checkbox <?php if (!empty($this->request->data['all'])) echo 'checked'; ?>">
                        <?php echo __d('front', 'Wszystkie'); ?>
                        <input type="checkbox" value="u" id="all" name="all" <?php
                        if (!empty($this->request->data['all'])) {
                            echo "CHECKED";
                        }
                        ?>>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="submit" style='display:none' tabindex="-1"/>
    <?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
    var price = false;
    //<![CDATA[
    jQuery('.sizeInput').on('click', function() {        
        if ($(this).is(':checked')) {
            $(this).parent().addClass('checked');
        }
        else {
            $(this).parent().removeClass('checked');
        }
        
    });


    jQuery('.other-brands').on('click', function() {
        $('div#filter-price').removeClass('active');
        $('div#filter-size').removeClass('active');
        $('div#filter-gender').removeClass('active');
        $('div#filter-brands').toggleClass('active');
    });
    jQuery('.filter-price').on('click', function() {
        $('div#filter-brands').removeClass('active');
        $('div#filter-size').removeClass('active');
        $('div#filter-gender').removeClass('active');
        $('div#filter-price').toggleClass('active');
        
        if (!price) {                         
            $("#sliderPrice").ionRangeSlider("update", {
                from: <?php echo $price_from; ?>, 
                to: <?php echo $price_to; ?>,  
            });      
            price = true;
        }
        
    });
    jQuery('.filter-size').on('click', function() {
        $('div#filter-price').removeClass('active');
        $('div#filter-brands').removeClass('active');
        $('div#filter-gender').removeClass('active');
        $('div#filter-size').toggleClass('active');
    });
    jQuery('.filter-gender').on('click', function() {
        $('div#filter-price').removeClass('active');
        $('div#filter-size').removeClass('active');
        $('div#filter-brands').removeClass('active');
        $('div#filter-gender').toggleClass('active');
    });
    
    jQuery('.brand-logo').on('click', function() {    
        $('div#sorts > form').attr('action', $(this).attr('href'));
        $('div#sorts > form').get(0).setAttribute('action', $(this).attr('href'));
    
        $('div#sorts > form').submit();
        return false;
    });
       
    jQuery('.submit_form').on('click', function() {
        $('div#sorts > form').submit();
    });
    jQuery('.showFiltr').on('click', function() {
        $('div#sorts > form').submit();
    });
    jQuery('div.gender_filter input').on('click', function() {
        if ($(this).attr('name') == 'all') {
            $('input#man').attr('checked', false);
            $('input#woman').attr('checked', false);
            $(this).attr('checked', true);  
        }
        else if ($(this).attr('name') == 'woman') {
            $('input#all').attr('checked', false);
            $('input#man').attr('checked', false);
            $(this).attr('checked', true);  
        }
        else {  
            $('input#all').attr('checked', false);
            $('input#woman').attr('checked', false);
            $(this).attr('checked', true);  
        }
        $('div#sorts > form').submit();
    });
    //]]>
</script>