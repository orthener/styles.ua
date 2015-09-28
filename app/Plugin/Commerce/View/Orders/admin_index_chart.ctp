<div class="orders index">
    <h2><?php echo __('Zamówienia w Koszykach'); ?></h2>
    <ul class="desc">
        <li>Wszystkich koszyków: <span id="chart-count"><?php echo $this->Paginator->params['paging']['Order']['count']; ?></span></li>
        <li>Nieużywanych dłużej niż <?php echo $coockieTimeLife; ?> dni: <span id="chart-count"><?php echo $oldOrders; ?></span><?php echo $this->Html->link(__('Usuń'), array('action' => 'index_chart', 'delete'), array('style' => 'float: none','class' => 'link button'), __d('cms', 'Jesteś pewny usunięcia wszystkich koszyków starszych niż %s dni?', $coockieTimeLife)); ?></li>
    </ul>
    <?php echo $this->Element('Orders/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link('Lista zamówień w trakcie realizacji', array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'orders', 'action' => 'index', 1)) ?></li>
        <li><?php echo $this->Html->link('Lista zamówień zrealizowanych', array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'orders', 'action' => 'index', 2)) ?></li>
        <li><?php echo $this->Html->link(__('Lista zamówień - anulowane'), array('action' => 'index_cancel', 'plugin' => 'commerce', 'controller' => 'orders')); ?></li>
    </ul>
</div>