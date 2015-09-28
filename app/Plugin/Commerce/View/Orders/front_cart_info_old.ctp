<?php
//    $info['price'] = 9999999; $info['items'] = '999 przedmiotów';
?>


<div class="koszyk <?php echo ($info['price'] == 0) ? 'koszykPusty' : ''; ?> fr">
    <?php if ($info['price'] != 0): ?>
        <?php $linkKoszyk = $this->Html->image('layouts/default/cart.png') . '
    <span class="przedmioty">' . $info['items'] . '</span>
        <span class="price">' . $this->Number->currency($info['price'], 'PLN') . '</span>'; ?>
        <?php echo $this->Html->link($linkKoszyk, array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'cart'), array('class' => 'kwota', 'escape' => false)); ?>
    <?php else: ?>
        <span class="kwota pusty">
            <?php echo $this->Html->image('layouts/default/cart.png'); ?>
            Twój koszyk jest pusty
        </span>
    <?php endif; ?>
</div>