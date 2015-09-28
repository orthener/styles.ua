<?php
echo $this->Form->create('Search', array('url' => array('plugin' => 'static_product', 'controller' => 'products', 'action' => 'search', 'type' => 'shop'), 'class'=>'searcher'));
echo $this->Form->input('text', array('label' => false, 'placeholder' => __d('front', 'Szukaj'), 'class'=>'fl'));
echo $this->Form->submit(__d('front', 'Szukaj'));
echo $this->Form->end();
?>