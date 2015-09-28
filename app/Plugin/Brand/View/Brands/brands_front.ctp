<?php
foreach ($brands as $brand) :
    $color = $this->Image->thumb('/files/brand/' . $brand['Brand']['img'], array('width' => 58, 'height' => 63), array('class' => 'color', 'valign'=>'middle'));
//    $grey = $this->Image->thumb('/files/brand/' . $brand['Brand']['img2'], array('width' => 108, 'height' => '85'), array('class' => 'grey'));
    echo $this->Html->link($color, array('plugin' => 'brand', 'controller' => 'brands', 'action' => 'view', $brand['Brand']['slug']), array('escape' => false, 'class' => 'brand-logo pull-left'));
endforeach;
