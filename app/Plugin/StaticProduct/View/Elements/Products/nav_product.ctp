<?php echo $this->Html->script('jquery-ui-1.8.14.custom.min', array('inline' => false)); ?>
<?php echo $this->Html->script('/static_product/js/jquery.dynatree', array('inline' => false)); ?>

<ul id="navProduct"></ul>

<script type="text/javascript">
    $(function(){
        $("#navProduct").dynatree({
            debugLevel: 0,
            fx: { height: "toggle", duration: 200 },
            autoCollapse: true,
            autoFocus: false,
            children: <?php echo json_encode($productCategories); ?>,
            clickFolderMode: 3,
            strings: {
                loading: "<?php echo __d('public', 'Ładowanie…'); ?>",
                loadError: "<?php echo __d('public', 'Błąd'); ?>"
            },
            onCreate: function(node, nodeSpan) {
                if (node.data.isActive) {
                    $(nodeSpan).addClass('active');
                }
                
            },
            onActivate: function(node) {
                if (!node.data.isFolder) {
                    document.location.href = '<?php echo $this->Html->url(array('action' => 'index')) ?>/'+node.data.slug;
                }
            }
        });
        var expendTimeOut = null;
        
        $("#navProduct a").hover(function(){
            var node = $.ui.dynatree.getNode(this);

            if (node) {
                clearTimeout(expendTimeOut);
                expendTimeOut = setTimeout(function(){
                    node.expand();
                }, 500);
            }
        });        

    });
</script>