<?php
//echo $this->FebHtml->meta('description','',array('inline'=>false));
//echo $this->FebHtml->meta('keywords','',array('inline'=>false));
$this->set('title_for_layout', __d('public', 'Dane klienta', true));
?>
<?php echo $this->Html->css('/commerce/css/commerce', null, array('inline' => false)) ?>
<div class="orders view clearfix">
    <h1 class="orange"><?php echo __d('public', 'DANE KLIENTA'); ?></h1>
    <?php echo $this->element('Orders/steps', array('step' => 2), array('plugin' => 'commerce')); ?>

    <?php echo $this->element('Orders/form', array(), array('plugin' => 'commerce')); ?> 
</div>