<?php echo  __d('cms', "Witaj!"); ?>


<?php echo  __d('cms', "Aby usunąć się z listy newslettera należy kliknąć w poniższy link:"); ?>


<?php 
$link = $this->Html->url(array('controller'=>'newsletters','action'=>'delete',md5($email)),true);
echo $link;
?>