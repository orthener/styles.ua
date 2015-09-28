<div class="countries index">
     
    <?php echo $this->Element('Country.Countries/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
	<h3><?php echo __d('cms', 'Actions'); ?></h3>
	<ul>
		<?php echo $this->Permissions->link(__d('cms', 'New Country'), array('action' => 'add'), array('outter'=>'<li>%s</li>')); ?>
        	</ul>
</div>
