<script>
    <?php if (empty($page)) {
        $page = 2; 
    } ?>
    var page = <?php echo $page; ?>;
    $('#more-products a').click(function() {
        if (page>=666) {    
            $('#more-products a').hide(); 
            return false;
        }
        <?php 
            if (empty($brand_id)) {
                $url = $this->Html->url(array('controller' => 'products', 'plugin' => 'static_product', 'action' => 'front_filter'));
            }
            else {
                $url = $this->Html->url(array('controller' => 'products', 'plugin' => 'static_product', 'action' => 'front', $brand_id));
            }
            if (!empty($filterData)) {
                $url .= '/filterData:'.$filterData;
            }
//            if (!empty($this->request->data)) {
//                $request_filter = json_encode($this->request->data);
//                $url = $this->Html->url(array('controller' => 'products', 'plugin' => 'static_product', 'action' => 'front_filter'));
//            }
        ?>
        $.ajax({
            url: '<?php echo $url; ?>/' + prod_filter + '/<?php if (!empty($category_id)) { echo $category_id; } else { echo 0;} ?>/<?php if (!empty($text_name)) { echo $text_name; } ?>/page:'+page,
            dataType: 'html',
            type: 'POST',
            data: {
                data: {
                    filter: prod_filter
                }
            },
            success: function(data) {
                page++;
                if (data.length < 90) {
                    page = 666;
                    $('#more-products a').hide();
                }
                $('#products').append(data);
                if ($('.hide_next_products').length > 0) {
                    $('#more-products a').hide();
                }
            },
            error: function(o1, o2, o3, o4) {

            }
        });
        return false;
    });  
    
    
    if ($('.no_products').length > 0 || $('.hide_next_products').length > 0) {
        $('#more-products a').hide();
    }
    else {
        $('#more-products a').show();
    }
</script>

