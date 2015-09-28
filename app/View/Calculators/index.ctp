<?php
$this->set('title_for_layout', $page['Page']['name']);
?>
<?php
$keywords = Configure::read('Meta.studio.key');
$keywords .= empty($page['Page']['keywords']) ? " " : " " . $page['Page']['keywords'];
$description = Configure::read('Meta.studio.desc');
$description .= empty($page['Page']['description']) ? " " : " " . $page['Page']['description'];
$this->Html->meta('description', $description, array('inline' => false));
$this->Html->meta('keywords', $keywords, array('inline' => false));
?>

<?php $this->Html->addCrumb(__d('cms', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb('Интернет магазины'); ?>

<div id="calculator_page" class="clearfix whiteBg">
    <div class="container">
        <div class="row-fluid">
            <div class="breadcrump span8 my-span8 bt-no-margin">
                <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
            </div>
        </div>
    </div>
    <div class="clearfix">
        <div class="calculatorPage row-fluid">
            <div class="page-container">
                <div class="calculatorPageContent span8 my-span8 bt-no-margin">
                    <div class="title clearfix">
                        <h1><?php echo $page['Page']['name']; ?></h1>
                    </div>
                    <?php echo $page['Page']['desc'];?>
                    <?php // echo $this->Html->requestAction(array('admin' => false, 'plugin' => 'brand', 'controller' => 'brands', 'action' => 'brands_front', 0, 50)); ?>
                </div>
                <div class="calculatorBox span4 bt-no-margin">
                    <?php echo $this->element('Calculators/calculator'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
(function($){
    $(document).ready(function(){
        var calculatorBox = $('.span8 > #calculator_page').find('.calculatorBox');
        var boxBlog = $('.boxBlog');
        if (calculatorBox.length == 1){
            $('.calculatorPageContent').removeClass('span8 my-span8').addClass('span12');
            calculatorBox.removeClass('span4').css('float', 'none');
            boxBlog.prepend(calculatorBox);
            calculatorBox.css({
                'background-color': '#fff', 
                'margin-top' : '-10px', 
                'padding-bottom' : '10px',
                'border' : '1px solid #00AEDA'
            });
            $('.page-container .calculatorBox').hide();
        }
    });
})(jQuery);
</script>