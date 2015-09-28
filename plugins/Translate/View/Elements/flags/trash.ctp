<div class="button dodelete">
    <?php echo __d('cms', 'Usuń'); ?><br />
    <?php
    if (count($data['translateDisplay']) > 1) {
        echo $this->element('Translate.flags/flags', array('url' => array(
                'action' => 'delete',
                $data[$model]['id'],
                0
            ),
            'active' => $data['translateDisplay'],
            'title' => __d('cms', 'Usuń'),
            'addit' => array(
                'confirm' => __d('cms', 'Czy napewno chcesz usunąć tą wersje jezykową strony %s?', $data[$model]['id']),
            )
                )
        );
    }
    echo $this->Html->link(
            $this->Html->image('flag/trash.png', array(
                'alt' => __d('cms', 'Usuń Wszystkie'),
                'title' => __d('cms', 'Usuń Wszystkie')
                    )
            ), array('action' => 'delete', $data[$model]['id'], 1), array(
        'confirm' => __d('cms', 'Usunąć wszystkie wersje językowe?'),
        'escape' => false
            )
    );
    ?>
</div>