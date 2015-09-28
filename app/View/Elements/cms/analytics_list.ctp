<?php

    $tables = $this->requestAction(array('admin' => 'admin','prefix'=>'admin', 'controller' => 'panel', 'action' => 'ga_tableslist'));

    if(!empty($tables)):
?>
<h2><span>Wybierz tabelę do raportów (nie będzie możliwości zmiany wyboru)</span></h2>
<ul>
<?php
        foreach($tables AS $table):
?>
  <li><?php echo $this->Html->link($table['Account']['title'], array('admin' => 'admin', 'controller' => 'panel', 'action' => 'ga_tableslist', $table['Account']['tableId'])); ?></li>
<?php
        endforeach;
?>
</ul>    
<?php    
    endif;

