

<h2><span></span><?php echo __d('cms', 'Products'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id', __d('cms', "ID")); ?></th>
        <th><?php echo $this->Paginator->sort('photo_id', __d('cms', 'Photo')); ?></th>
        <th><?php echo $this->Paginator->sort('title', __d('cms', 'Title')); ?></th>
        <th><?php echo $this->Paginator->sort('product_category_id', __d('cms', 'Product Category')); ?></th>
        <th>
            <?php echo $this->Paginator->sort('barcode', __d('cms', 'Kod kreskowy')); ?>
            <span style="margin-left: 50%">&middot;</span><br/>
            <?php echo $this->Paginator->sort('code', __d('cms', 'Kod produktu')); ?>
        </th>
        <th><?php echo $this->Paginator->sort('producer', __d('cms', 'Producent')); ?>
            <br />
            <?php echo $this->Paginator->sort('producer', __d('cms', 'Marka')); ?></th>
        <th><?php echo $this->Paginator->sort('quantity', __d('cms', 'Ilość')); ?><br />
        <!-- <?php echo $this->Paginator->sort('size', __d('cms', 'Rozmiary produktu')); ?> --></th>
        <th><?php echo $this->Paginator->sort('gender', __d('cms', 'Kolekcja damska/męska')); ?></th>
        <th><?php echo $this->Paginator->sort('price', __d('cms', 'Cena brutto')); ?></th>
<!--        <th><?php //echo $this->Paginator->sort('gender', __d('cms', 'Płeć klienta')); ?></th>
        <th><?php //echo $this->Paginator->sort('size', __d('cms', 'Dostępne rozmiary')); ?></th>-->
<!--        <th><?php echo $this->Paginator->sort('execution_time', __d('cms', 'Czas realizacji')); ?></th>-->
        <th>
            <?php //echo $this->Paginator->sort('best_seler', __d('cms', 'Best seler')); ?>
            <?php echo $this->Paginator->sort('promoted', __d('cms', 'Promocja')); ?><br>
            <?php echo $this->Paginator->sort('sale', __d('cms', 'Wyprzedaż')); ?>
            <?php echo $this->Paginator->sort('on_blog', __d('cms', 'Na blogu')); ?>
        </th>
        <!--<th><?php //echo $this->Paginator->sort('tiny_content', __d('cms', 'Skrócony opis')); ?></th>-->
        <th>
            <?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&nbsp;&nbsp;&nbsp;
            <span style="margin-left: 50%">&middot;</span><br/>
            <?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?>
        </th>
        <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr attrId="<?php echo $product['Product']['id']; ?>">
            <td>
                <?php echo $product['Product']['id']; ?><br/><br/>
                <input type="checkbox" value="<?php echo $product['Product']['id']; ?>" name="data[Selection][]"/>
            </td>
            <td>
                <?php 
                if (!empty($product['Photo']['img'])) {
                    echo $this->Image->thumb('/files/photo/' . $product['Photo']['img'], array('width' => 100, 'height' => 100));
                } else if(!empty($product['Photos'][0]['img'])) {
                    echo $this->Image->thumb('/files/photo/' . $product['Photos'][0]['img'], array('width' => 100, 'height' => 100));
                } else {
                    echo "Brak obrazka";
                }
                ?>
            </td>
            <td><?php echo h($product['Product']['title']); ?>&nbsp;</td>
            <td>
                <?php
                $categories = array();
                foreach ($product['ProductsCategory'] as $category) {
                    $categories[] = $this->Permissions->link($productCategories[$category['id']], array('controller' => 'product_categories', 'action' => 'edit', $category['id']));
                }
                echo implode(', <br />', $categories);
                ?>
            </td>
            <td>
                <?php echo h($product['Product']['barcode']); ?>
                <div style="text-align: center">&middot;</div>
                <?php echo h($product['Product']['code']); ?>
            </td>
            <td><?php echo h($product['Product']['producer']); ?>&nbsp;<br /> 
                <?php echo empty($product['Product']['brand_id']) ? "" : h($brands[ $product['Product']['brand_id'] ]); ?>&nbsp;</td>
            <td>
                <?php if (empty($product['Product']['sized']) || empty($product['ProductsSize'])): ?>
                    <?php echo h($product['Product']['quantity']) . "&nbsp;" . h($product['Product']['jm']); ?>
                <?php else: ?>
                    <?php foreach($product['ProductsSize'] as $size) : ?>
                        <div style="white-space: nowrap;"><?php echo $size['name'] . ' - ' . $size['quantity'] . ' ' . $product['Product']['jm'];?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <!--<br />&nbsp;
            <?php echo h($product['Product']['size']);?> -->
            </td>
            <td>
                <?php 
                    if($product['Product']['gender'] == 'w') {
                        echo __d('cms', "Kolekcja&nbsp;damska");
                    } else if($product['Product']['gender'] == 'm') {
                        echo __d('cms', "Kolekcja&nbsp;męska");
                    }
                ?>
            </td>
            <td><?php echo $product['Product']['price']; ?></td>
<!--            <td><?php echo empty($product['Product']['execution_time']) ? "" : $product['Product']['execution_time'] . "&nbsp;" . __d('cms', 'dni'); ?></td>-->
            <td>
                <?php
                //echo $product['Product']['best_seler'] ? __d('cms', 'best seler') . "<br>" : "";
                echo $product['Product']['promoted'] ? __d('cms', 'promocja') . "<br>" : "";
                echo $product['Product']['sale'] ? __d('cms', 'wyprzedaż') . "<br>" : "";
                echo $product['Product']['on_blog'] ? __d('cms', 'na blogu') . "<br>" : "";
                ?>
            </td>
            <!--<td><?php //echo $product['Product']['tiny_content']; ?></td>-->
            <td>
                <?php echo $this->FebTime->niceShort($product['Product']['created']); ?><br/>
                <div style="text-align: center">&middot;</div>
                <?php echo $this->FebTime->niceShort($product['Product']['modified']); ?>
            </td>
            <td class="actions">
                <?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $product['Product']['id'])); ?>
                <?php echo $this->Permissions->link(__('Zdjęcia'), array('plugin' => 'photo', 'controller' => 'photos', 'action' => 'index', 'StaticProduct.Product', $product['Product']['id'])); ?>

                    <!--<div class="button"><?php //echo __d('cms', 'Edit');  ?><br />-->
                <?php //echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', array('url' => array_merge(array('action' => 'edit', $product['Product']['id'])), 'active' => $product['translateDisplay'], 'title' => __d('cms', 'Edit')))); ?>
                <!--</div>-->
                <?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $product['Product']['id'])); ?>
                <?php //echo $this->element('Translate.flags/trash', array('data' => $product, 'model' => 'Product')); ?>
                <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $product['Product']['id']), null, __('Are you sure you want to delete # %s?', $product['Product']['title'])); ?>

                <?php echo $this->Permissions->link(__('Promocje'), array('plugin' => 'static_product', 'controller' => 'products_promotions', 'action' => 'index', $product['Product']['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
