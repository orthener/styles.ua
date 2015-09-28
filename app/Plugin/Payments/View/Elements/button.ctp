<?php  echo $this->Form->create('Payment', array('url'=>array('controller'=>'payments','action'=>'add','plugin'=>'payments' ,'admin'=>true,'prefix'=>'admin'))); ?>
<?php
    echo $this->Form->hidden('user_plugin', array('value'=>$configure['user_plugin']));
    echo $this->Form->hidden('user_model', array('value'=>$configure['user_model']));
    echo $this->Form->hidden('user_row_id', array('value'=>$configure['user_row_id']));
    echo $this->Form->hidden('related_plugin', array('value'=>$configure['related_plugin']));
    echo $this->Form->hidden('related_model', array('value'=>$configure['related_model']));
    echo $this->Form->hidden('related_row_id', array('value'=>$configure['related_row_id']));
    $configure['redirect'] = empty($configure['redirect'])?$this->Html->url(null,true):$configure['redirect'];
    echo $this->Form->hidden('redirect', array('value'=>$configure['redirect']));
?>
<?php echo $this->Form->submit(__d('cms', 'Dodaj płatność'), array('title' => __d('cms', 'Dodaj płatność'), 'id' => 'payment_button', 'div' => false));  ?>
<?php echo $this->Form->end();  ?>
