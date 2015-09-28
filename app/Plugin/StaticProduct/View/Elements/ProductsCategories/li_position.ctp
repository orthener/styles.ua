<div class="child clearfix">
    <div class="action">
        <?php $optionsFull = array('update' => '#tree', 'class' => 'button', 'before' => 'blockAll();', 'complete' => 'unblockAll();'); ?>
        <div class="button"><?php echo __d('cms', 'Edit'); ?><br />
            <?php echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', array('url' => array_merge(array('action' => 'edit', $value['ProductsCategory']['id'])), 'active' => $value['translateDisplay'], 'title' => __d('cms', 'Edit')))); ?>
        </div>
        <?php echo $this->element('Translate.flags/trash', array('data' => $value, 'model' => 'ProductsCategory')); ?> 

    </div>
    <span>
        <?php echo $value['ProductsCategory']['name']; ?>
    </span>
</div>