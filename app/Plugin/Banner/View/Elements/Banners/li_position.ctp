<div class="child clearfix">
    <div class="action">
        <?php $optionsFull = array('update' => '#tree', 'class' => 'button', 'before' => 'blockAll();', 'complete' => 'unblockAll();'); ?>
        <div class="button"><?php echo __d('cms', 'Edit'); ?><br />
            <?php echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', array('url' => array_merge(array('action' => 'edit', $value['Banner']['id'])), 'active' => $value['translateDisplay'], 'title' => __d('cms', 'Edit')))); ?>
        </div>
        <?php echo $this->element('Translate.flags/trash', array('data' => $value, 'model' => 'Banner')); ?> 
    </div>
    <span>
        <?php //debug('/files/banner/' . $value['Banner']['img']);?>
        <?php echo $this->Image->thumb('/files/banner/' . $value['Banner']['img'], array('width' => 50, 'height' => 50)); ?>
        <strong><?php echo $value['Banner']['name']; ?></strong>
        <?php echo $value['Banner']['link']; ?>
        <?php //debug($value); ?>
        <?php echo (!empty($value['Banner']['new_window']) && $value['Banner']['new_window'] == 1) ? '(w nowym oknie)' : ''; ?>
    </span>
</div>