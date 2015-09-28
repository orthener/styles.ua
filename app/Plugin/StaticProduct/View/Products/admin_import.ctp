<?php $this->set('title_for_layout', __d('cms', 'Import csv z subiekta')); ?>
<h2><?php echo __d('cms', 'Import pliku csv z subiekta'); ?></h2>
<?php if (empty($systemProducts)): ?>

    <div class="windowsSizes form">
        <?php echo $this->Form->create('ProductCsv', array('type' => 'file')); ?>
        <fieldset>
            <legend><?php echo __d('cms', 'Wyślij plik (zgodny z formatem)'); ?></legend>
            <?php echo $this->Form->input('csv', array('type' => 'file')); ?>
        </fieldset>
        <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
    </div>
<?php else: ?>

    <h3><?php echo __d('public', 'Produkty do aktualizacji:'); ?></h3>
    <?php echo $this->Form->create('Product'); ?>

    <table>
        <thead>
            <tr>
                <th><?php echo __d('cms', 'ID z subiekta'); ?></th>
                <th><?php echo __d('cms', 'Title'); ?></th>
                <th><?php echo __d('cms', 'Dostępna ilość'); ?></th>
                <th><?php echo __d('cms', 'Jednostka miary'); ?></th>
                <th><?php echo __d('cms', 'Podatek'); ?></th>
                <th><?php echo __d('cms', 'Kod kreskowy'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($systemProducts AS $subiekt_id => $product): ?>
                <tr class="altrow">
                    <td rowspan="2">
                        <?php echo $subiekt_id; ?>
                        <?php
                        echo $this->Form->input('Product.' . $subiekt_id . '.id', array('type' => 'checkbox',
                            'label' => false,
                            'div' => false,
                            'checked' => 'checked',
                            'value' => $systemProducts[$subiekt_id]['id']));
                        ?>
                    </td>
                    <td><?php echo $systemProducts[$subiekt_id]['title']; ?></td>
                    <td><?php echo $systemProducts[$subiekt_id]['quantity']; ?></td>
                    <td><?php echo $systemProducts[$subiekt_id]['jm']; ?></td>
                    <td><?php echo $systemProducts[$subiekt_id]['tax']; ?></td>
                    <td><?php echo $systemProducts[$subiekt_id]['barcode']; ?></td>
                </tr>
                <tr>
                    <td><?php echo $subiektProducts[$subiekt_id][1]; ?></td>
                    <td>
                        <?php echo $this->Form->input('Product.' . $subiekt_id . '.quantity', array('value' => $subiektProducts[$subiekt_id][3], 'div' => false, 'label' => false)); ?>
                    </td>
                    <td><?php echo $subiektProducts[$subiekt_id][4]; ?></td>
                    <td><?php echo $subiektProducts[$subiekt_id][5]; ?></td>
                    <td><?php echo $subiektProducts[$subiekt_id][6]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $this->Form->end(__d('cms', 'Aktualizuj ilość')); ?>

    <h3><?php echo __d('public', 'Pozostałe produkty:'); ?></h3>
    <table>
        <thead>
            <tr>
                <th><?php echo __d('cms', 'ID z subiekta'); ?></th>
                <th><?php echo __d('cms', 'Title'); ?></th>
                <th><?php echo __d('cms', 'Dostępna ilość'); ?></th>
                <th><?php echo __d('cms', 'Jednostka miary'); ?></th>
                <th><?php echo __d('cms', 'Podatek'); ?></th>
                <th><?php echo __d('cms', 'Kod kreskowy'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subiektProducts AS $subiekt_id => $product): ?>
                <?php if (empty($systemProducts[$subiekt_id])): ?>
                    <tr>
                        <td><?php echo $subiektProducts[$subiekt_id][0]; ?></td>
                        <td><?php echo $subiektProducts[$subiekt_id][1]; ?></td>
                        <td><?php echo $subiektProducts[$subiekt_id][3]; ?></td>
                        <td><?php echo $subiektProducts[$subiekt_id][4]; ?></td>
                        <td><?php echo $subiektProducts[$subiekt_id][5]; ?></td>
                        <td><?php echo $subiektProducts[$subiekt_id][6]; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

