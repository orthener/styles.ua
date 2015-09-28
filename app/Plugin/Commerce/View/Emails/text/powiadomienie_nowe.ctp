<p><?php __d('public', "Witaj!"); ?></p>
<p>&nbsp;</p>
<p><?php echo "W serwisie " . $this->Html->link('Street Style Shop', $this->Html->url('/', true)) ." złożono nowe zamówienie, <br />więcej informacji znajduje się na poniższym adresie URL:"; ?></p>
<p><?php 
$link = $this->Html->url(array('admin' => 'admin','plugin' => 'commerce','controller'=>'orders','action'=>'edit', $id),true);
echo $this->Html->link($link,$link);
?></p>
