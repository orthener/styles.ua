<?php
    echo json_encode(array(
        'success' => $success,
        'ids' => $ids,
        'data' => $this->data,
        'index' => $this->element('Products/multiselect_index', array('products' => $products))
    ));
?>