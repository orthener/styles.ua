Witajm

<?php echo "W serwisie ".$this->Html->link('hedom.pl', 'http://hedom.pl')." złożono nowe zamówienie,"; ?> 
więcej informacji znajduje się na poniższym adresie URL:

<?php echo $link = $this->Html->url(array('admin' => 'admin','plugin' => 'commerce','controller'=>'orders','action'=>'edit', $id)); ?>