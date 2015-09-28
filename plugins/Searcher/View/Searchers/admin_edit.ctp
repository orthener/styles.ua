<div class="searchers form">
    <?php echo $this->Form->create('Searcher'); ?>
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Element('Searchers/fields', array('desc' => __d('cms', 'Edycja'))); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Usuń'), array('plugin' => false, 'action' => 'delete', $this->Form->value('Searcher.id')), array('outter' => '<li>%s</li>'), __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('Searcher.id'))); ?>    
        <?php echo $this->Permissions->link(__d('cms', 'Lista'), array('plugin' => false, 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>     
    </ul>
</div>
