<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id', __d('cms', 'Id')); ?></th>
        <th><?php echo $this->Paginator->sort('product_id', __d('cms', 'Product Id')); ?></th>
        <th><?php echo $this->Paginator->sort('price', __d('cms', 'Cena')); ?></th>
        <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    <?php
    foreach ($productsPromotions as $productsPromotion):
        ?>
        <tr attrId="<?php echo $productsPromotion['ProductsPromotion']['id']; ?>">
            <td>
                <?php echo $productsPromotion['ProductsPromotion']['id']; ?>
            </td>
            <td><?php echo h($productsPromotion['ProductsPromotion']['product_id']); ?></td>
            <td><?php echo h($productsPromotion['ProductsPromotion']['price']); ?>&nbsp;</td>
            <td><?php echo $this->FebTime->niceShort($productsPromotion['ProductsPromotion']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($productsPromotion['ProductsPromotion']['modified']); ?></td>
            <td class="actions">
                <?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $productsPromotion['Product']['id'])); ?>
                <?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $productsPromotion['ProductsPromotion']['id'])); ?>
                <?php echo $this->Permissions->link(__('Delete'), array('action' => 'delete', $productsPromotion['ProductsPromotion']['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>