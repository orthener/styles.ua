<?php
foreach ($photos as $photo){
    
    $photo = &$photo['Photo'];
    echo $this->Html->div('gallery',
        '<b>'.$photo['title'].'</b><br />'.
        $this->Html->link(
            $this->Image->thumb(
                '/files/photo/'.$photo['img'], 
                array('width'=>150,'height'=>150)
                ),
            '/files/photo/'.$photo['img'],
            array('rel'=>'galeria','escape'=>false)
            ),
            array('escape'=>false)
    );
} 
?>