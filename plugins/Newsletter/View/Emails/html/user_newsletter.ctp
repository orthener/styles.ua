<?php echo $message['NewsletterMessage']['html_content']; ?>
<p>&nbsp;</p>

<p><small><?php echo  __d('front', 'Aby zrezygnować z newslettera należy kliknąć w poniższy link:'); ?></small></p>

<p><small><?php 
$link = $this->Html->url(array('admin' => false, 'controller'=>'newsletters','action'=>'delete',md5($email)),true);
echo $this->Html->link($link,$link);
?></small></p>