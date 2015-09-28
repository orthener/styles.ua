<?php echo  __d("front", "Witaj!"); ?>


<?php echo  __d("front", "Aby zapisać się do newslettera, kliknij w poniższy link:"); ?>


<?php 
$link = $this->Html->url(array('controller'=>'newsletters','action'=>'activate',md5($email)),true);
echo $link;
?>


<?php echo  __d("front", "Jeśli nie zapisywałeś się do newslettera, zignoruj tę wiadomość."); ?>


<?php echo  __d("front", "Aby całkowicie usunąć email z listy należy kliknąć w poniższy link:"); ?>


<?php 
$link = $this->Html->url(array('controller'=>'newsletters','action'=>'delete',md5($email)),true);
echo $link;
?>