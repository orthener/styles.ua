<?php //$this->Html->script(array('feb.form'), array('inline' => false));  ?>
<?php $this->set('title_for_layout', __d('cms', 'Edycja') . ' &bull; ' . __d('cms', 'Products')); ?>
<h2><?php echo __d('cms', 'Edycja wielu produktów'); ?></h2>

<div class="product form">
    <div class="clearfix">
        <?php echo $this->Form->create('Products', array('type' => 'file')); ?>
        <?php echo $this->Form->hidden('Ids.ids', array('value' => $to_send)); ?>
        <fieldset>
            <legend><?php echo __d('cms', 'Dane produktów'); ?></legend>
            <table>
                <tr>
                    <th></th>
                    <th><?php echo __d('front', 'Zaznacz jeśli chcesz zmienić'); ?></th>
                </tr>
                <?php //foreach ($products as $product): ?>
                <tr>
                    <td>
                        <?php
                        if ($equal_value['price']) {
                            echo $this->Form->input('price', array('label' => __d('cms', 'Cena'), 'value' => $product_tpl['Product']['price']));
                        } else {
                            echo $this->Form->input('price', array('label' => __d('cms', 'Cena'), 'disabled' => 'disabled', 'value' => 'różne wartości'));
                        }
                        ?>         
                    </td>
                    <td>
                        <?php
                        if ($equal_value['price']) {
                            echo $this->Form->input('Selected.price', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb', 'checked' => 'checked'));
                        } else {
                            echo $this->Form->input('Selected.price', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb'));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($equal_value['tax']) {
                            echo $this->Form->input('tax', array('label' => __d('cms', 'Podatek'), 'options' => $tax, 'type' => 'select', 'default' => $product_tpl['Product']['tax']));
                        } else {
                            echo $this->Form->input('tax', array('label' => __d('cms', 'Podatek'), 'options' => $tax, 'type' => 'select', 'disabled' => 'disabled', 'value' => 'różne wartości'));
                        }
                        ?>      
                    </td>
                    <td>
                        <?php
                        if ($equal_value['tax']) {
                            echo $this->Form->input('Selected.tax', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb', 'checked' => 'checked'));
                        } else {
                            echo $this->Form->input('Selected.tax', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb'));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($equal_value['producer']) {
                            echo $this->Form->input('producer', array('label' => __d('cms', 'Producer'), 'value' => $product_tpl['Product']['producer']));
                        } else {
                            echo $this->Form->input('producer', array('label' => __d('cms', 'Producer'), 'disabled' => 'disabled', 'value' => 'różne wartości'));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($equal_value['producer']) {
                            echo $this->Form->input('Selected.producer', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb', 'checked' => 'checked'));
                        } else {
                            echo $this->Form->input('Selected.producer', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb'));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($equal_value['brand_id']) {
                            //echo $this->Form->input('brand_id', array('label' => __d('cms', 'Brand'), 'value' => $product_tpl['Product']['brand_id']));
                            echo $this->Form->input('brand_id', array('label' => __d('cms', 'Marka'), 'options' => $brands));
                        } else {
                            //echo $this->Form->input('brand_id', array('label' => __d('cms', 'Brand'), 'disabled' => 'disabled', 'value' => 'różne wartości'));
                            echo $this->Form->input('brand_id', array('label' => __d('cms', 'Marka'), 'disabled' => 'disabled', 'options' => $brands, 'empty' => 'rozne wartości'));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($equal_value['brand_id']) {
                            echo $this->Form->input('Selected.brandid', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb', 'checked' => 'checked'));
                        } else {
                            echo $this->Form->input('Selected.brandid', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb'));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($equal_value['execution_time']) {
                            echo $this->Form->input('execution_time', array('label' => __d('cms', 'Czas realizacji'), 'value' => $product_tpl['Product']['execution_time']));
                        } else {
                            echo $this->Form->input('execution_time', array('label' => __d('cms', 'Czas realizacji'), 'disabled' => 'disabled', 'value' => 'różne wartości'));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($equal_value['execution_time']) {
                            echo $this->Form->input('Selected.execution_time', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb', 'checked' => 'checked'));
                        } else {
                            echo $this->Form->input('Selected.execution_time', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb'));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($equal_value['quantity']) {
                            echo $this->Form->input('quantity', array('label' => __d('cms', 'Ilość szt.'), 'value' => $product_tpl['Product']['quantity']));
                        } else {
                            echo $this->Form->input('quantity', array('label' => __d('cms', 'Ilość szt.'), 'disabled' => 'disabled', 'value' => 'różne wartości'));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($equal_value['quantity']) {
                            echo $this->Form->input('Selected.quantity', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb', 'checked' => 'checked'));
                        } else {
                            echo $this->Form->input('Selected.quantity', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb'));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($equal_value['on_blog']) {
                            $value = $product_tpl['Product']['on_blog'] == true ? 1 : 0;
                            echo $this->Form->input('on_blog', array('label' => __d('cms', 'Promowany na blogu'), 'type' => 'checkbox', 'default' => $value));
                        } else {
                            echo $this->Form->input('on_blog', array('label' => __d('cms', 'Promowany na blogu'), 'type' => 'checkbox', 'disabled' => 'disabled', 'value' => 'różne wartości'));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($equal_value['on_blog']) {
                            echo $this->Form->input('Selected.on_blog', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb', 'checked' => 'checked'));
                        } else {
                            echo $this->Form->input('Selected.on_blog', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb'));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($equal_value['promoted']) {
                            $value = $product_tpl['Product']['promoted'] == true ? 1 : 0;
                            echo $this->Form->input('promoted', array('label' => __d('cms', 'Promowany na stronie głównej'), 'type' => 'checkbox', 'default' => $value));
                        } else {
                            echo $this->Form->input('promoted', array('label' => __d('cms', 'Promowany na stronie głównej'), 'type' => 'checkbox', 'disabled' => 'disabled', 'value' => 'różne wartości'));
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($equal_value['promoted']) {
                            echo $this->Form->input('Selected.promoted', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb', 'checked' => 'checked'));
                        } else {
                            echo $this->Form->input('Selected.promoted', array('type' => 'checkbox', 'label' => '', 'value' => 1, 'id' => false, 'class' => 'tim_cb'));
                        }
                        ?>
                    </td>
                </tr>
    
                <?php //endforeach; ?>
            </table>
        </fieldset>
        <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
    </div>
</div>
<script>
    $(function() {
        $('#InvAddFv').click(function() {
            $('fieldset.invoice').toggle();
        });

        $.each($('fieldset.invoice input'), function(i, o) {
            if ($(o).attr('value') != '') {
                $('fieldset.invoice').show();
                $('#InvAddFv').attr('checked', 'checked');
            }
        });
    });

    $('.tim_cb').click(function() {
        if ($(this).is(':checked')) {
            $(this).parent().parent().siblings().find('div input').attr('disabled', false);
            $(this).parent().parent().siblings().find('div input').attr('value', '');
            $(this).parent().parent().siblings().find('div select').attr('disabled', false);
            var selectText = $(this).parent().parent().siblings().find('div select option:selected').text();
            if (selectText == 'różne wartości') {
                $(this).parent().parent().siblings().find('div select option:selected').text('');
            }
            $(this).parent().parent().siblings().find('div textarea').attr('disabled', false);
            $(this).parent().parent().siblings().find('div textarea').attr('value', '');
        } else {
            $(this).parent().parent().siblings().find('div input').attr('disabled', true);
            $(this).parent().parent().siblings().find('div select').attr('disabled', true);
            $(this).parent().parent().siblings().find('div textarea').attr('disabled', true);
        }
    })
</script>