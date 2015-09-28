<?php echo $this->Form->create('Product') ?>
<?php echo $this->element('Products/product_select', array('categories' => $categories)); ?>
<?php echo $this->Form->end(__d('front', 'Szukaj')); ?>

<script type="text/javascript">
    $(function(){
        $('#ProductSelectionId').change(function(){
            $.ajax({
                url: '<?php echo $this->Html->url(array('action' => 'ctg_by_selection')); ?>',
                dataType: 'html',
                type: 'POST',
                data: {
                    data: {
                        ProductsCategory: {
                            selection_id: $(this).val()
                        }
                    }
                },
                success: function(html) {
                    $('#ProductsCategoryId').parent('div').replaceWith(html);
                }
            });
            return true;
        });
    });
    
    $('#ProductAdminMultiselectForm').submit(function(e){
        $.ajax({
            url: '/<?php echo $this->request->url; ?>',
            dataType: 'html',
            data: $(this).serialize(),
            type: 'POST',
            success: function(data) {
                $('.ui-dialog-content').html(data);
            }
        });
        
        e.preventDefault();
    });
    
</script>

<h2><span></span><?php echo __d('cms', 'Products'); ?></h2>
<?php echo $this->Form->create('Product', array('id' => 'SimilarProduct', 'url' => array('action' => 'multiselect_index')));  ?>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo __d('cms', 'Title'); ?></th>
        <th><?php echo __d('cms', 'Photo Id'); ?></th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr attrId="<?php echo $product['Product']['id']; ?>">
            <td><?php echo $this->Form->input('Product.ids.'.$product['Product']['id'], array('value' => $product['Product']['id'],'type' => 'checkbox', 'label' => $product['Product']['title']));  ?></td>
            <td><?php echo $this->Image->thumb('/files/photo/' . $product['Photo']['img'], array('width' => 100, 'height' => 100)) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Form->end();  ?>