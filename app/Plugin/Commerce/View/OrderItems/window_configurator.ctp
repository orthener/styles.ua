<?php echo $this->Html->css('configurator', null, array('inline' => false)); ?>
<?php echo $this->Html->css('draw', null, array('inline' => false)); ?>
<?php
$product = json_decode($orderItem['OrderItem']['product'], true);
?>
<div  class="orders maxWidth">

    <h2 class="info"><?php echo __d('public', 'Skonfiguruj okno'); ?> <span></span></h2>
    <div class="borderContent">
        <?php echo $this->Form->create('OrderItem'); ?>

        <table border="0">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th><?php echo __d('public', 'Nazwa produktu'); ?></th>
                    <th><?php echo __d('public', 'Cena końcowa'); ?></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php
                        echo!empty($product['Photo']['img']) ? $this->Image->thumb('/files/photo/' . $product['Photo']['img'], array('width' => '135', 'height' => '100', 'frame' => '#fff')) : '';

                        echo!empty($product['WindowConfiguration']['id']) ? $this->element('Window.WindowConfigurations/draw', array(
                                    'windowConfiguration' => $product,
                                    'objectID' => 'mainDraw' . $product['WindowConfiguration']['id'],
                                    'destWidth' => 100,
                                    'destHeight' => 80,
                                )) : '';
                        echo!empty($product['FabricStyle']['id']) ? $this->Image->thumb('/files/fabricstyle/' . $product['FabricStyle']['img'], array('width' => '100', 'height' => '80', 'frame' => '#fff')) : '';
                        ?>
                        <?php
                        if (isSet($product['Product'])) {
                            echo $this->Image->thumb('/files/product/' . $product['Product']['img'], array('width' => 100, 'height' => 100));
                        } else if (isSet($product['Configuration'])) {
                            echo $this->Image->thumb('/img/layouts/default/default_bunch.png', array('width' => 100, 'height' => 100));
                        }
                        ?>
                    </td>
                    <td>
                        <h3><?php echo $orderItem['OrderItem']['name']; ?></h3>
                        <?php echo $this->element('Window.Commerce/OrderItemFullDescription', array('orderItem' => $orderItem['OrderItem'])); ?>
                    </td>
                    <td><?php echo CakeNumber::currency(Currency::exchange(($orderItem['OrderItem']['price_net']*1.23), 'PLN'), 'PLN'); ?></td>
                    <td><?php echo $this->Html->link('X', array('action' => 'delete_config'), array('class' => 'button')); ?></td>
                </tr>
            </tbody>
        </table>

        <?php echo $this->Form->input('OrderItem.desc', array('label' => false, 'before' => '<span>Dodaj opis okna</span>', 'div' => 'addDesc')); ?>
    </div>
    <?php // $usunConfLink = $this->Html->link(__d('public', 'Usuń i konfiguruj nowe okno'), array('action' => 'window_configurator', $orderItem['OrderItem']['id']), array('class' => 'greyButton')); ?>
    <?php echo $this->Form->submit(__d('public', 'Dodaj do listy okien'), array('class' => 'btnGradientBlue fontBold', /*'after' => $usunConfLink,*/ 'div' => 'clearfix submit')); ?>
    <?php echo $this->Form->end(); ?>