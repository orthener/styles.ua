<?php
    $modyfications = $this->element('Orders/modyfication');
    $items = $this->element('Orders/admin_order_items');
    echo json_encode(compact('items', 'modyfications'));
?>