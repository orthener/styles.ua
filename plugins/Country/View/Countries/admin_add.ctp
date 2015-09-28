<div class="countries form">
    <?php echo $this->Form->create('Country'); ?>
    <?php echo $this->Element('Countries/fields', array('desc' => __d('cms', 'Admin Add Country'))); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Countries'), array('plugin' => false, 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
