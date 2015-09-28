<?php

$koszyk = !empty($koszyk);
echo $this->Form->create('OrderItem', array('type' => 'file', 'onsubmit' => "return AIM.submit(this, {'onStart' : startCallbackNew, 'onComplete' : completeCallbackNew})",
    'class' => 'sendFileForm', 'id' => 'uploadForm_' . $orderItem['id'],
    'url' => array('controller' => 'order_items', 'action' => 'upload_file', 'plugin' => 'commerce', $koszyk)));

echo $this->Form->hidden('OrderItem.id', array('value' => $orderItem['id']));

echo $this->Form->hidden('OrderItemFile.order_item_id', array('value' => $orderItem['id']));


echo $this->Form->input('OrderItemFile.name', array('onchange' => "jQuery('#uploadForm_" . $orderItem['id'] . "').submit();",
    'id' => 'inputfile_' . $orderItem['id'], 'type' => 'file', 'value' => '', 'size' => '1',
    'class' => 'inputfile', 'label' => false, 'div' => array('class' => 'input file')));

echo $this->Form->submit('Dodaj plik', array('escape' => false, 'class' => 'sendFile', 'div' => false));

echo $this->Form->end();
?>