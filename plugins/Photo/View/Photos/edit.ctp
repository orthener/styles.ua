<div class="photos form">

</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('plugin' => false, 'action' => 'delete', $this->Form->value('Photo.id')), array('outter'=>'<li>%s</li>'), __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('Photo.title'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Photos'), array('plugin' => false, 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
    </ul>
</div>
