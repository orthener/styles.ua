<div class="child clearfix">
    <div class="action">
        <?php $optionsFull = array('update' => '#tree', 'class' => 'button', 'before' => 'blockAll();', 'complete' => 'unblockAll();'); ?>
        <?php if (empty($value['Comment']['parent_id']) && empty($value['Comment']['active']) || !empty($value['Comment']['parent_id']) && empty($value['Comment']['active']) && !empty($acceptComments[ $value['Comment']['parent_id'] ])   ):?>
            <div class="button">
                <?php echo $this->Html->link(__d('cms', 'Akceptuj'), array('action' => 'accept', $value['Comment']['id'])); ?>
            </div>
        <?php endif; ?>
        <div class="button dodelete">
            <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $value['Comment']['id']), null, __d('cms', 'Czy chcesz usunąć # %s oraz wszystkie pozycje podrzędne?', $value['Comment']['name'])); ?>
        </div>
    </div>
    <span>
        <b><?php echo __d('cms', 'User: '); ?></b><?php echo $value['Comment']['name']; ?>
        <b><?php echo __d('cms', 'News: '); ?></b><?php echo $value['News']['title']; ?><br/>
        <?php if(!empty($value['Comment']['parent_id'])) :?>
            <b><?php echo __d('cms', 'Parent comments: '); ?></b><?php echo $this->Text->truncate($commentsDesc[ $value['Comment']['parent_id'] ], 100, array('html' => true)); ?><br/>
        <?php endif; ?>
        <b><?php echo __d('cms', 'Comments: '); ?></b><?php echo $this->Text->truncate($value['Comment']['desc'], 100, array('html' => true)); ?><br/>
        <?php
        $value['Link']['options']['target'] = '_blank';
        echo ($value['Link']['url'] == '#') ? '' : $this->Html->link('[»»]', $value['Link']['url'], $value['Link']['options']);
        ?>
    </span>
</div>