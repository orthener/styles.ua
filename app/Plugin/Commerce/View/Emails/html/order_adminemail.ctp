<p><?php __d('public', "Witaj!"); ?></p>
<p><?php echo "W serwisie " . $this->Html->link('hedom.pl', 'http://hedom.pl') . " złożono nowe zamówienie, <br />więcej informacji znajduje się na poniższym adresie URL:"; ?></p>
<p><?php
$link = $this->Html->url(array('admin' => 'admin', 'plugin' => 'commerce', 'controller' => 'orders', 'action' => 'edit', $id));
echo $this->Html->link($link, $link);
?></p>

