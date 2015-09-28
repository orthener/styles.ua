<?php echo $newsletterMessage['NewsletterMessage']['html_content']; ?>
<p>&nbsp;</p>

<p><small><?php echo  __d('cms', 'Aby zrezygnować z newslettera należy kliknąć w poniższy link:'); ?></small></p>

<p><small><?php 
echo $this->Html->link('::link wypisania z newslettera::','#', array('onclick'=>'return false;'));
?></small></p>