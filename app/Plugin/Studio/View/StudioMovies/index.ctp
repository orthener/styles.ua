<?php $this->set('title_for_layout', __d('cms', 'List').' &bull; '.__d('cms', 'Studio Movies')); ?><div class="studioMovies index">
     
    <?php echo $this->Element('StudioMovies/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php echo $this->Permissions->link(__d('cms', 'New Studio Movie'), array('action' => 'add'), array('outter'=>'<li>%s</li>')); ?>
        	</ul>
</div>
