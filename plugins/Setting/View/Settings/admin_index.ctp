<div class="settings index">
    <h2><?php echo $title_for_layout; ?></h2>
    <table cellpadding="0" cellspacing="0">
        <?php
        $tableHeaders = $this->Html->tableHeaders(array(
            $this->Paginator->sort('id'),
            $this->Paginator->sort('key', __d('cms', 'Klucz')),
            $this->Paginator->sort('value', __d('cms', 'Wartość')),
            $this->Paginator->sort('editable', __d('cms', 'Możliwość edycji')),
            __d('cms', 'Actions'),
                ));
        echo $tableHeaders;

        $rows = array();
        foreach ($settings AS $setting) {
            $actions = ' ' . $this->Html->link(__d('cms', 'Edit'), array('controller' => 'settings', 'action' => 'edit', $setting['Setting']['id']), array('class' => 'button'));
            $actions .= ' ' . $this->Html->link(__d('cms', 'Delete'), array(
                        'controller' => 'settings',
                        'action' => 'delete',
                        $setting['Setting']['id'],
                            ), array('class' => 'button'), __d('cms', 'Are you sure?'));

            $actions .= ' ' . $this->Html->link(__d('cms', '▼'), array('controller' => 'settings', 'action' => 'movedown', $setting['Setting']['id']), array('class' => 'button'));
            $actions .= $this->Html->link(__d('cms', '▲'), array('controller' => 'settings', 'action' => 'moveup', $setting['Setting']['id']), array('class' => 'button'));
            $key = $setting['Setting']['key'];
            $keyE = explode('.', $key);
            $keyPrefix = $keyE['0'];
            if (isset($keyE['1'])) {
                $keyTitle = '.' . $keyE['1'];
            } else {
                $keyTitle = '';
            }

            $rows[] = array(
                $setting['Setting']['id'],
                $this->Html->link($keyPrefix, array('controller' => 'settings', 'action' => 'index', 'p' => $keyPrefix)) . $keyTitle,
                $this->Text->truncate($setting['Setting']['value'], 20),
                $setting['Setting']['editable'],
                $actions,
            );
        }

        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
        ?>
    </table>
</div>


<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'Dodaj ustawienie'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__d('cms', 'Import/Export'), array('action' => 'import')); ?></li>
    </ul>
</div>


<?php echo $this->element('cms/paginator'); ?>