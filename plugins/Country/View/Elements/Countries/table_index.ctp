<h2><?php echo __d('cms', 'Countries'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name')); ?></th>
        <th><?php echo $this->Paginator->sort('printable_name_en', __d('cms', 'Printable Name En')); ?></th>
        <th><?php echo $this->Paginator->sort('printable_name', __d('cms', 'Printable Name')); ?></th>
        <th><?php echo $this->Paginator->sort('iso3', __d('cms', 'Iso3')); ?></th>
        <th><?php echo $this->Paginator->sort('numcode', __d('cms', 'Numcode')); ?></th>
        <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
    </tr>
    <?php
    $i = 0;
    foreach ($countries as $country):
        ?>
        <tr attrId="<?php echo $country['Country']['id']; ?>">
            <td><?php echo h($country['Country']['name']); ?>&nbsp;</td>
            <td><?php echo h($country['Country']['printable_name_en']); ?>&nbsp;</td>
            <td><?php echo h($country['Country']['printable_name']); ?>&nbsp;</td>
            <td><?php echo h($country['Country']['iso3']); ?>&nbsp;</td>
            <td><?php echo h($country['Country']['numcode']); ?>&nbsp;</td>
            <td class="actions">
                <?php //echo $this->Permissions->link(__d('cms', 'View'), array('action' => 'view', $country['Country']['id'])); ?>
                <?php echo $this->Permissions->link(__d('cms', 'Edit'), array('action' => 'edit', $country['Country']['id'])); ?>
    <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $country['Country']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $country['Country']['name'])); ?>
            </td>
        </tr>
<?php endforeach; ?>
</table>