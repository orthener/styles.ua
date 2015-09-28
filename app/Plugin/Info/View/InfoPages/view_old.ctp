<div class="infoPages view">
    <h2><?php echo __('Info Page'); ?></h2>
    <dl>
        <dt><?php echo __d('cms', 'Id'); ?></dt>
        <dd>
            <?php echo h($infoPage['InfoPage']['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('cms', 'Name'); ?></dt>
        <dd>
            <?php echo h($infoPage['InfoPage']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('cms', 'Title'); ?></dt>
        <dd>
            <?php echo h($infoPage['InfoPage']['title']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('cms', 'Slug'); ?></dt>
        <dd>
            <?php echo h($infoPage['InfoPage']['slug']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('cms', 'Content'); ?></dt>
        <dd>
            <?php echo h($infoPage['InfoPage']['content']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('cms', 'Tags'); ?></dt>
        <dd>
            <?php echo h($infoPage['InfoPage']['tags']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('cms', 'Modified'); ?></dt>
        <dd>
            <?php echo h($infoPage['InfoPage']['modified']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __d('cms', 'Created'); ?></dt>
        <dd>
            <?php echo h($infoPage['InfoPage']['created']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Info Page'), array('action' => 'edit', $infoPage['InfoPage']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Info Page'), array('action' => 'delete', $infoPage['InfoPage']['id']), null, __('Are you sure you want to delete # %s?', $infoPage['InfoPage']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Info Pages'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Info Page'), array('action' => 'add')); ?> </li>
    </ul>
</div>
