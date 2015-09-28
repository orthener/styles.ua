<?php
echo $this->Form->create('Search', array('url' => array('plugin' => 'news', 'controller' => 'news', 'action' => 'search_blog', 'type' => 'blog'), 'class'=>'searcher')); 
echo $this->Form->input('text', array('label' => false, 'placeholder' => __d('front', 'Szukaj'), 'class'=>'fl'));
echo $this->Form->submit(__d('front', 'Szukaj'));
echo $this->Form->end();
?>