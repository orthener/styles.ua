<?php

interface OrderItemProductModel {
    
    /**
     * 
     * @param type $id
     * 
     * Metoda powinna zwrócić tablicę pól, wymaganych przez @OrderItem
     * 
     *   return array(
     *       'product' => json_encode($product),
     *       'desc' => $product['Product']['content'],
     *       'name' => $product['Product']['title'],
     *       'price' => $product['Product']['price'],
     *       'tax_rate' => $product['Product']['tax_rate'],
     *       'tax_value' => $product['Product']['tax_value'],
     *       'weight' => $product['Product']['weight'],
     *   );
     * 
     * @return array 
     */
    public function orderItemFields($id);
    
}

?>