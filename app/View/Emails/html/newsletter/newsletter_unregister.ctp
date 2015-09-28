<p><?php echo  __d("front", "Witaj!"); ?></p>
<p>&nbsp;</p>

<p><?php echo  __d("front", "Aby usunąć się z listy newslettera należy kliknąć w poniższy link:"); ?></p>
<p>&nbsp;</p>

<p><?php 
$link = $this->Html->url(array('controller'=>'newsletters','action'=>'delete',md5($email)),true);
echo $this->Html->link($link,$link);
?></p>