<?php echo $this->Html->css('/banner/css/staticProduct', null, array('inline' => false)); ?>
<?php echo $this->Html->css('/banner/css/skin/ui.dynatree', null, array('inline' => false)); ?>
<?php echo $this->Html->script('/banner/js/jquery.cookie', array('inline' => false)); ?>
<?php echo $this->Html->script('/banner/js/jquery.dynatree', array('inline' => false)); ?>

<?php $this->set('title_for_layout', __d('cms', 'List') . ' &bull; ' . __d('cms', 'Banners')); ?>

<div class="clearfix">
    <div class="banners index">
        <h2><span></span><?php echo __d('cms', 'Banners'); ?></h2>
        <div id="BannerTree">

        </div>
    </div>
    <div id="Banners" class="banners index">     
        <?php //echo $this->Element('Products/table_index'); ?> 
    </div>
</div>

<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'New Banner'), array('action' => 'add'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
<script type="text/javascript">
    $("#BannerTree").dynatree({
        persist: true,
        autoCollapse: false,
        initAjax: {
            url: "<?php echo $this->Html->url(array('controller' => 'banners', 'action' => 'reload')); ?>"
        },
        onActivate: function(node) {    
        },
        onCreate: function(node, span){
        }
    });
</script>