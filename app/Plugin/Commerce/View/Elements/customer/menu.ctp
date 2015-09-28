<ul class="clearfix">
    <li class="submenu"><?php echo $this->Html->link(__('ZAMÓWIENIA'), '#'); ?>
        <ul>
            <?php $order = $this->Html->requestAction(array('plugin' => 'commerce', 'controller'=>'orders', 'action'=>'mini_cart', 'admin'=>false, 'user' => false)); ?>
            <?php if (!empty($order)) {?>
            <li><?php echo $this->Html->link(__('Mój koszyk'), array('controller' => 'orders', 'action' => 'cart', 'plugin' => 'commerce')); ?></li>
            <?php } ?>
            <li><?php echo $this->Html->link(__('W trakcie realizacji'), array('controller' => 'customers', 'action' => 'my_orders_active', 'plugin' => 'commerce')); ?></li>
            <li><?php echo $this->Html->link(__('Zrealizowane'), array('controller' => 'customers', 'action' => 'my_orders_status_ended', 'plugin' => 'commerce')); ?></li>
        </ul>
    </li>
    <li><?php echo $this->Html->link(__('USTAWIENIA KONTA'), '#'); ?>
        <ul>
            <li><?php echo $this->Html->link(__('Dane kontaktowe'), array('controller' => 'customers', 'action' => 'my_settings', 'contact', 'plugin' => 'commerce')); ?></li>
            <li><?php echo $this->Html->link(__('Dane do faktury'), array('controller' => 'customers', 'action' => 'my_settings', 'invoice', 'plugin' => 'commerce')); ?></li>
            <li><?php echo $this->Html->link(__('Dane do logowania'), array('controller' => 'customers', 'action' => 'my_settings', 'login', 'plugin' => 'commerce')); ?></li>
<!--            <li><?php echo $this->Html->link(__('Zmiana Hasła'), array('controller' => 'customers', 'action' => 'my_settings', 'passchange', 'plugin' => 'commerce')); ?></li>-->
        </ul>
    </li>
    
<!--    <li><?php // echo $this->Html->link(__('PROGRAM PARTNERSKI'), array('controller' => 'customers', 'action' => 'my_discount', 'plugin' => 'commerce')); ?>
    </li>-->
    <?php /* ?>
    <li><?php echo $this->Html->link(__('FAKTURY'), array('controller' => 'customers', 'action' => '', 'plugin' => 'commerce')); ?></li>
    <?php */ ?>
</ul>
