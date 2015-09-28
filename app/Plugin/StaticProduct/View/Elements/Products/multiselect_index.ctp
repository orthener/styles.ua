<?php if (!empty($products)): ?>
    <div id="table_select">
        <table class="similar_products" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo __d('cms', 'Title'); ?></th>
                    <th><?php echo __d('cms', 'Photo Id'); ?></th>
                    <th><?php echo __d('cms', 'Action'); ?></th>
                </tr>

            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr data-id="<?php echo $product['Product']['id']; ?>">
                        <td><?php echo $product['Product']['title']; ?></td>
                        <td>
                            <?php
                            if(!empty($product['Photo']['img'])) {
                                $photo_img = $product['Photo']['img'];
                                echo $this->Image->thumb('/files/photo/' . $photo_img, array('width' => 100, 'height' => 100));
                            } else if(!empty ($product['Photos'][0]['img'])) {
                                $photo_img = $product['Photos'][0]['img'];
                                echo $this->Image->thumb('/files/photo/' . $photo_img, array('width' => 100, 'height' => 100));
                            } else {
                                echo 'Brak obrazka';
                            }
                            ?>
                        </td>
                        <td><?php echo $this->Form->button('X'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>