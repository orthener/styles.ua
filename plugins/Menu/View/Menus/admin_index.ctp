<?php if (empty($is_ajax)) { ?>
    <p>
        <?php echo __d('cms', 'Sekcja'); ?>
    </p>
    <ul>
        <?php
        foreach ($modes as $k => $mode) {
            echo '<li>' . $this->Html->link($mode, array('action' => 'index', $k)) . '</li>';
        }
        ?>
    </ul>
    <div>
        <?php if ($treeMode == '') { ?>
            <?php echo $this->element('title'); ?>
        <?php } ?>
        <?php echo $this->element('indexsort', array('tree' => $tree)); ?>
    </div>
<?php } else { ?>
    <?php echo $this->element('indexsort', array('tree' => $tree)); ?>
<?php } ?>