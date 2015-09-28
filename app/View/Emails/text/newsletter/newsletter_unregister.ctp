<?php echo  __d("front", "Witaj!"); ?>


<?php echo  __d("front", "Aby usunąć się z listy newslettera należy kliknąć w poniższy link:"); ?>


<?php 
$link = $this->Html->url(array('controller'=>'newsletters','action'=>'delete',md5($email)),true);
echo $link;
?>