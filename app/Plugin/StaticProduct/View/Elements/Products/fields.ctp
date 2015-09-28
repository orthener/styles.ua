<?php $this->Html->script('jquery.febmultiple', array('inline' => false)); ?>
<fieldset>
    <legend><?php echo __d('cms', 'Product Data'); ?></legend>
    <?php App::uses('Order', 'Commerce.model'); ?>
    <?php //echo $this->Form->input('subiekt_id', array('type' => 'text', 'label' => __d('cms', 'ID z subiekta')));  // , 'disabled' => 'disabled', 'class' => 'readonly'?>
    <?php echo $this->Form->input('title', array('label' => __d('cms', 'Title'))); ?>
    <?php echo $this->Form->input('code', array('label' => __d('cms', 'Kod produktu'))); ?>
    <?php echo $this->Form->input('barcode', array('type' => 'text', 'label' => __d('cms', 'Kod kreskowy'))); ?>
    <?php echo $this->Form->input('producer', array('label' => __d('cms', 'Producent'))); ?>
    <?php echo $this->Form->input('brand_id', array('label'=>__d('cms','Brand'), 'options'=>$brands)); ?>
    <?php echo $this->Form->hidden('size', array('label' => __d('cms', 'Rozmiary produktu'), 'value' => '0'));?>
  
    <?php echo $this->Form->input('gender', array('label' => __d('cms', 'Kolekcja damska/męska'), 'option' => $genders, 'type' => 'select')); ?>
    <?php echo $this->Form->input('weight', array('label' => __d('cms', 'Waga'), 'after' => __d('cms', '[g] (wraz z opakowaniem)'))); ?>
    <?php //echo $this->Form->input('jm', array('label' => __d('cms', 'Jednostka miary'), 'default' => 'szt.')); ?>
    <?php echo $this->Form->input('execution_time', array('label' => __d('cms', 'Czas realizacji'), 'after' => __d('cms', ' dni'))); ?>
    <?php echo $this->Form->input('price', array('label' => __d('cms', 'Cena brutto'))); ?>
    <?php // echo $this->Form->input('tax', array('label' => __d('cms', 'Podatek'), 'default'=>'0.23', 'options' => Order::$taxRates)); ?>
    <?php echo $this->Form->input('tax', array('label' => __d('cms', 'Podatek'), 'default' => '0.0', 'options' => $tax)); ?>
    <?php echo $this->Form->input('promoted', array('label' => __d('cms', 'Promowany na stronie głównej'))); ?>
    <?php echo $this->Form->input('sale', array('label' => __d('cms', 'Wyprzedaż'))); ?>
    <?php //echo $this->Form->input('popular', array('label' => __d('cms', 'Popularne'))); ?>
    <?php //echo $this->Form->input('best_seler', array('label' => __d('cms', 'Best seler'))); ?>
    <?php echo $this->Form->input('on_blog', array('label' => __d('cms', 'Promowany na blogu'))); ?>
</fieldset>

<fieldset id="fieldsetProductQuantity">
    <legend><?php echo __d('cms', 'Dostępna ilość produktów'); ?></legend>
    <?php echo $this->Form->input('sized', array('label' => __d('cms', 'Produkt rozmiarowy'))); ?>
   
    <table class="productQuantities" style="display:<?php echo (empty($this->data['Product']['sized'])) ? '' : 'none'?>;">
        <tr>
            <th><?php echo __d('cms', 'Dostępna ilość'); ?></th>
        </tr>
        <tr>  
            <td><?php echo $this->Form->input('quantity', array('label' => false)); ?></td>
        </tr>
    </table>
    <table class="productTypes" style="display:<?php echo (empty($this->data['Product']['sized'])) ? 'none' : ''?>;">
        <tr>
            <th><?php echo __d('cms', 'Rozmiar'); ?></th>
            <th><?php echo __d('cms', 'Ilość'); ?></th>
            <th>Opcje</th>
        </tr>
        <?php if (!empty($this->data['ProductsSize'])) { ?>
            <?php $n = count($this->data['ProductsSize']); ?>    
            <?php $i = 0; ?>
            <?php foreach ($this->data['ProductsSize'] AS $i => $productSize) { ?>
                <tr class="row">
                    <td>
                        <?php echo $this->Form->hidden("ProductsSize.$i.id"); ?>
                        <?php echo $this->Form->input("ProductsSize.$i.name", 
                                array('label' => false)); ?>
                        <?php echo $this->Form->input("ProductsSize.$i.delete", array('type' => 'hidden', 'value' => 0)); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->hidden("ProductsSize.$i.id"); ?>
                        <?php echo $this->Form->input("ProductsSize.$i.quantity", 
                                array('label' => false)); ?>
                        <?php echo $this->Form->input("ProductsSize.$i.delete", array('type' => 'hidden', 'value' => 0)); ?>
                    </td>
                    <td><?php echo $this->Html->link(__d('cms', 'Usuń'), '#', array('onclick' => 'return deleteProductType.apply(this);', 'class' => 'deleteLink')); ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <?php $i = 0; ?>
            <tr class="row newRow">
                <td>
                    <?php echo $this->Form->hidden("ProductsSize.$i.id"); ?>
                    <?php echo $this->Form->input("ProductsSize.$i.name", 
                            array('label' => false, 'class' => 'sizeName')); ?>
                    <?php echo $this->Form->input("ProductsSize.$i.delete", array('type' => 'hidden', 'value' => 0)); ?>
                </td>
                <td>
                    <?php echo $this->Form->hidden("ProductsSize.$i.id"); ?>
                    <?php echo $this->Form->input("ProductsSize.$i.quantity", 
                            array('label' => false)); ?>
                    <?php echo $this->Form->input("ProductsSize.$i.delete", array('type' => 'hidden', 'value' => 0)); ?>
                </td>
                <td><?php echo $this->Html->link(__d('cms', 'Cofnij'), '#', array('onclick' => 'return deleteProductType.apply(this);', 'class' => 'deleteLink', 'style' => 'display:none')); ?></td>
            </tr>
        <?php } ?>
    </table>
    <div class="addProductType" style="display:<?php echo (empty($this->data['Product']['sized'])) ? 'none' : ''?>;">
        <?php echo $this->Html->link(__d('cms', 'Dodaj'), '#', array('onclick' => 'return addProductTypePriceRow.apply(this);', 'class' => 'addLink')); ?>
    </div>
    <script type="text/javascript">
        $('#ProductSized').click(function(){
            if (this.checked) {
                $('.productTypes').show();
                $('.addProductType').show();
                $('.productQuantities').hide();
            }
            else {
                $('.productTypes').hide();
                $('.addProductType').hide();
                $('.productQuantities').css('display', '');
            }
        });
        
        
        var deleteProductType = function(){
            var isNew = $(this).parents('tr.row').hasClass('newRow');
            if(isNew){
                $(this).parents('tr.row').remove();
            }
            var state = $(this).parents('tr.row').find('input[name*=delete]').val();
            if(state != "1"){
                $(this).parents('tr.row').find('input[name*=delete]').val('1');
                $(this).text('Przywró\u0107');
                $(this).parents('tr.row').find('td, input, select').css('opacity', '0.5');
                $(this).parents('tr.row').find('input, select').css('text-decoration', 'line-through');
                $(this).parents('tr.row').find('input').attr('readonly', 'readonly');
                $(this).parents('tr.row').find('select').attr('disabled', 'disabled');
            } else {
                $(this).parents('tr.row').find('input[name*=delete]').val('0');
                $(this).text('Usu\u0144');
                $(this).parents('tr.row').find('td, input, select').css('opacity', '');
                $(this).parents('tr.row').find('input, select').css('text-decoration', '');
                $(this).parents('tr.row').find('input').attr('readonly', false);
                $(this).parents('tr.row').find('select').attr('disabled', false);
            }
            return false;
        }
        var addProductTypePriceRow = function(){
            var rowHTML = $('table.productTypes tr:last-child').html().replace(/\]\[([0-9]+)\]\[|(ProductsSize)([0-9]+)/g, function(all, a, b, c){
                if(a != ''){
                    return '][' + (parseInt(a)+1) +  '][';
                } else {
                    console.log(b + (parseInt(c)+1));
                    return b + (parseInt(c)+1);
                }
            });

            $('table.productTypes').append('<tr class="row newRow">'+rowHTML+'</tr>');
            $('table.productTypes tr:last-child input[name*=\\[id\\]]').remove();
            $('table.productTypes tr:last-child input[name*=\\[name\\]]').val('');
            $('table.productTypes tr:last-child input[name*=\\[quantity\\]]').val('');
            
            $('table.productTypes tr:last-child input[name*=delete]').val('0');
            $('table.productTypes tr:last-child input, select').css('text-decoration', '');
            $('table.productTypes tr:last-child td, input, select').css('opacity', '');
            $('table.productTypes tr:last-child input').attr('readonly', false);
            $('table.productTypes tr:last-child input').attr('disabled', false);
            
            $('table.productTypes tr:last-child .deleteLink').text('<?php echo __d('cms', 'Cofnij');?>');
            $('table.productTypes tr:last-child .deleteLink').show();
            
//            $('table.productTypes tr:last-child').find('input[name*=delete]').val('0');
//            $('table.productTypes tr:last-child').text('Usu\u0144');
//            $('table.productTypes tr:last-child').find('td, input, select').css('opacity', '');
//            $('table.productTypes tr:last-child').find('input, select').css('text-decoration', '');
//            $('table.productTypes tr:last-child').find('input').attr('readonly', false);
//            $('table.productTypes tr:last-child').find('select').attr('disabled', false);
//            
            
            return false;
        }
    </script>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Miniaturka');  ?></legend>
    <?php echo $this->FebForm->file('Product.thumb', array('type' => 'file')); ?>
</fieldset>


<fieldset>
    <legend><?php echo __d('cms', 'Content'); ?></legend>
    <?php echo $this->FebTinyMce4->input('Product.content', array('label' => false), 'full', array('width' => 718)); ?>
</fieldset>

<!--
<fieldset>
    <h2><span></span><?php echo __d('cms', 'Podobne produkty'); ?></h2>
    <?php //echo $this->Form->input('SimilarProduct.SimilarProduct', array('type' => 'select', 'id' => 'ProductSimilar', 'multiple' => true, 'label' => false)); ?>
</fieldset> -->
<!--
<fieldset>
    <h2><span></span><?php //echo __d('cms', 'Akcesoria'); ?></h2>
<?php //echo $this->Form->input('Accessory.Accessory', array('type' => 'select', 'id' => 'Accessory', 'multiple' => true, 'label' => false));  ?>
</fieldset>
-->
<fieldset class="multiple">
    <h2><span></span><?php echo __d('cms', 'Kategorie'); ?></h2>
<?php echo $this->Form->input('ProductsCategory.ProductsCategory', array('multiple' => 'checkbox', 'label' => false, 'options' => $productCategories)); ?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Ustawienia html');?></legend>
    <?php echo $this->Form->input('metakey', array('label' => __d('cms', 'Słowa kluczowe'), 'type' => 'textarea'));?>
    <?php echo $this->Form->input('metadesc', array('label' => __d('cms', 'Opis strony'), 'type' => 'textarea'));?>
</fieldset>



<script type="text/javascript">
    $(function() {
        $('#ProductSimilar').febMultiple({
            defaultHtml: '<?php echo __d('cms', 'Dodaj podobne produkty'); ?>',
            /**
             * Wymagana funkcja, wywołuje się po kliknięciu dodaj w dialogu, 
             * musi zaktualizować rejestr przed wywołaniem odswiezenia contentu inline
             */
            updateRegister: function() {
                //Dodaje do rejestru, nowych pól
                var $this = this;
                $('#SimilarProduct input[type="checkbox"]:checked').each(function() {
                    $this.febMultiple('add', parseInt($(this).attr('value')));
                });
            },
            afterAdd: function(content, response) {
                var $this = $(this);
                //Ustawiam button do usuwania
                content.find('.similar_products button').button();
                content.find('.similar_products button').click(function(e) {
                    var tr = $(this).parents('tr');
                    var tbody = tr.parents('tbody');
                    var similar_id = tr.attr('data-id');
                    var product_id = $('#ProductId').attr('value');
                    
                            $this.febMultiple('remove', tr.attr('data-id'));
                            tr.remove();
                            if (!tbody.find('tr').length) {
                                tbody.parent().remove();
                            }
                            e.preventDefault();
                    $.ajax({
                        type: "post",
                        url: '<?php echo $this->Html->url(array('admin' => 'admin', 'controller' => 'products', 'action' => 'ajax_multiselect_remove')); ?>',
                        dataType: 'json',
                        data: {data: {product_id: product_id, similar_id: similar_id}},
                        success: function(json) {
                            alert('+++');
                        }
                    });

                });
            },
            inlineEditUrl: '<?php echo $this->Html->url(array('action' => 'multiselect_index')); ?>.json',
            /**
             * Ajaxowa akcja contentu okienka wyboru
             */
            data: {
                url: '<?php echo $this->Html->url(array('action' => 'multiselect')); ?>',
                data: {
                    data: {
                        Product: {
                            id: <?php echo!empty($this->data['Product']['id']) ? $this->data['Product']['id'] : 'null'; ?>
                        }
                    }
                }
            },
            dialog: {
                title: '<?php echo __d('cms', 'Dodaj podobne produkty'); ?>'
            }
        });

<?php if (!empty($this->data['SimilarProduct']['SimilarProduct'])): ?>
            $('#ProductSimilar').febMultiple('create', <?php echo json_encode($this->data['SimilarProduct']['SimilarProduct']); ?>);
<?php endif; ?>

<?php if (!empty($this->data['SimilarProduct'][0])): ?>
            $('#ProductSimilar').febMultiple('create', <?php echo json_encode(array_values(Set::combine($this->data['SimilarProduct'], '{n}.id', '{n}.id'))); ?>);
<?php endif; ?>
        $("form").submit(function(e) {
            
            if (!$('input#ProductSized').is(':checked')) {
                return true;
            }
        
            var isValid = true;
            $("table.productTypes").find($("input.sizeName")).each(function() {
                $(this).css("border-color", "");
                $(this).css("background-color", "");
                if (!$(this).val()) {
                    $(this).css("border-color", "red");
                    $(this).css("background-color", "#ffdddd");
                    isValid = false;
                }
            });
            if (!isValid) {
                alert('<?php echo __d('cms', 'Nazwa rozmiaru nie może być pusta. Usuń lub wypełnij aby kontynuować.'); ?>');
         //       FEB.ui.flashMessage.setFlash("Nazwa rozmiaru nie może być pusta. Usuń lub wypełnij aby kontynuować.", 'error', 10000);
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });
        
        $('#Accessory').febMultiple({
            defaultHtml: '<?php echo __d('cms', 'Dodaj akcesoria'); ?>',
            /**
             * Wymagana funkcja, wywołuje się po kliknięciu dodaj w dialogu, 
             * musi zaktualizować rejestr przed wywołaniem odswiezenia contentu inline
             */
            updateRegister: function() {
                //Dodaje do rejestru, nowych pól
                var $this = this;
                $('#SimilarProduct input[type="checkbox"]:checked').each(function() {
                    $this.febMultiple('add', parseInt($(this).attr('value')));
                });
            },
            afterAdd: function(content, response) {
                var $this = $(this);
                //Ustawiam button do usuwania
                content.find('.similar_products button').button();
                content.find('.similar_products button').click(function(e) {
                    var tr = $(this).parents('tr');
                    var tbody = tr.parents('tbody');

                    $this.febMultiple('remove', tr.attr('data-id'));
                    tr.remove();
                    if (!tbody.find('tr').length) {
                        tbody.parent().remove();
                    }
                    e.preventDefault();
                });
            },
            inlineEditUrl: '<?php echo $this->Html->url(array('action' => 'multiselect_index')); ?>.json',
            /**
             * Ajaxowa akcja contentu okienka wyboru
             */
            data: {
                url: '<?php echo $this->Html->url(array('action' => 'multiselect')); ?>'
            },
            dialog: {
                title: 'Dodaj akcesoria'
            }
        });

<?php if (!empty($this->data['Accessory']['Accessory'])): ?>
            $('#Accessory').febMultiple('create', <?php echo json_encode($this->data['Accessory']['Accessory']); ?>);
<?php endif; ?>

<?php if (!empty($this->data['Accessory'][0])): ?>
            $('#Accessory').febMultiple('create', <?php echo json_encode(array_values(Set::combine($this->data['Accessory'], '{n}.id', '{n}.id'))); ?>);
<?php endif; ?>
    });

</script>