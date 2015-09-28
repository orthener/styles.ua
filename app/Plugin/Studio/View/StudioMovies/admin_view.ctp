<div class="studioMovies view">
<h2><?php  echo __('Studio Movie');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($studioMovie['StudioMovie']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($studioMovie['StudioMovie']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Author'); ?></dt>
		<dd>
			<?php echo h($studioMovie['StudioMovie']['author']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Media Type'); ?></dt>
		<dd>
			<?php echo h($studioMovie['StudioMovie']['media_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'File'); ?></dt>
		<dd>
			<?php echo h($studioMovie['StudioMovie']['file']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Url'); ?></dt>
		<dd>
			<?php echo h($studioMovie['StudioMovie']['url']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Studio Movie'), array('action' => 'edit', $studioMovie['StudioMovie']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Studio Movie'), array('action' => 'delete', $studioMovie['StudioMovie']['id']), null, __('Are you sure you want to delete # %s?', $studioMovie['StudioMovie']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Studio Movies'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Studio Movie'), array('action' => 'add')); ?> </li>
	</ul>
</div>
