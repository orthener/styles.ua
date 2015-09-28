<?php $this->set('title_for_layout', __d('cms', 'List') . ' &bull; ' . __d('cms', 'Blog')); ?><div class="news index">
    <div class="filtruj clearfix">
        <?php echo $this->Filter->formCreate($filtersSettings, array('legend' => __d('cms', 'Wyszukaj'), 'submit' => __d('cms', 'Wyszukaj'))); ?>
        <?php $this->Paginator->options(array('url' => $filtersParams)); ?>
    </div>
    <?php echo $this->Element('News/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'New News'), array('action' => 'add'), array('outter' => '<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Users'), array('plugin' => false, 'controller' => 'users', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New User'), array('plugin' => false, 'controller' => 'users', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>


<script type="text/javascript">
    $(function(){
        $('#NewsCreatedFrom, #NewsCreatedTo, #NewsDateFrom, #NewsDateTo').datepicker({ changeMonth: true, changeYear: true,
            dateFormat: 'yy-mm-dd'//'dd.mm.yy',
        });
    });
</script>