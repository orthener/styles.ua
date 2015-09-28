<h1 class="red"><?php echo __d('front', 'Rezygnuję z newslettera'); ?></h1>
<p><?php echo __d('front', 'Twój adres email to '); ?><?php echo $newsletter['Newsletter']['email']; ?></p>
<p><?php echo __d('front', 'Czy jesteś pewien ze chcesz usunąć go z listy newslettera?'); ?></p>
<?php 
echo $this->Form->create('Newsletter', array('url'=>$this->here));
echo $this->Form->hidden('Newsletter.email');
echo $this->Form->end(__d('front', 'Usuń'));
 ?>