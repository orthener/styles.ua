<div class="categories index">
    <h2><?php echo __d('cms', 'Wybierz pozycję'); ?></h2>
    <table>
        <tr>
            <th>
                <?php //echo $paginator->sort(__d('cms', 'Nazwa'), $displayField); ?>
                <?php echo __d('cms', 'Nazwa'); ?>
            </th>
            <th>
                <?php echo __d('cms', 'Dodatkowe informacje'); ?>
            </th>
            <th>
                Opcje
            </th>
        </tr>
        <?php foreach ($relatedData as $row): ?>
            <tr>
                <td id="<?php echo $model . '_' . $row[$model]['id']; ?>"><?php echo $row[$model][$displayField]; ?> </td>
                <td>
                    <?php echo $this->Html->div('clearfix', 
                    $this->element('Translate.flags/flags', 
                    array(
                    'url' => '', 
                    'active' => $row['translateDisplay'], 
                    'title' => ''
                    ))); ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('cms', 'Wybierz'), '#', array('onclick' => "selectModelElement('{$model}', '{$row[$model]['id']}'); return false;")); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __d('cms', 'Strona %page% z %pages%, pokazano %current% rekordów z %count% wszystkich, zaczynając od %start%, a kończąc na %end%')
        ));
        ?>	</p>
    <?php
    $idTab = (isset($this->params['pass']['1']) and $this->params['pass']['1'] == 'podstrony') ? 1 : 2;
    $this->Paginator->options(array(
        'update' => '#ui-tabs-' . $idTab,
        //'url'=>array('plugin' => 'tree', 'admin' => false, 'controller' => 'tree', 'action'=>'relatedindex', 'Page','galerie'),
        'evalScripts' => true
    ));
    echo $this->element('default/paginator');
    echo $this->Js->writeBuffer();
    ?>
</div>