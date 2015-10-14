<script>
    <?php $url = $this->Html->url(array('controller' => 'products', 'plugin' => 'static_product', 'action' => 'look_more')); ?>
    window.page = <?php echo $page = (empty($page)) ? 1 : $page ; ?>;

    $('#more-products a').click(function(e) {
        e.preventDefault();
        getLookMore();
    });
    
    
    if ($('.no_products').length > 0 || $('.hide_next_products').length > 0) {
        $('#more-products a').hide();
    }
    else {
        $('#more-products a').show();
    }
    
    function getLookMore() {
        if (window.page >= 666) {
            $('#more-products a').hide(); 
            return false;
        }
        $.ajax({
            url: '<?php echo $url; ?>/<?php echo $product['Product']['id']; ?>/'+page,
            dataType: 'html',
            type: 'POST',
            success: function(data) {
                window.page++;
                if (data.length < 90) {
                    window.page = 666;
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
    }
    
    $(document).ready(function() {
        getLookMore();
    });
</script>
