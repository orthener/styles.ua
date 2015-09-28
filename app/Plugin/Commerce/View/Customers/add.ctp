<?php $this->set('title_for_layout',__d('public','Dane klienta',true)); ?>
<div class="orders view clearfix">
    <h1 class="orange"><?php  __d('public','DANE KLIENTA');?></h1>
    <?php echo $this->element('Orders/steps', array('plugin'=>'commerce','step'=>2)); ?>
    <?php echo $this->Form->create('Customer');?>
    	<?php echo $this->element('Orders/form'); ?> 
    <?php echo $this->Form->end();?>
</div>
