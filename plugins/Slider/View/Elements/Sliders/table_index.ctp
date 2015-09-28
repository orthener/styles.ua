	<h2><?php echo __d('cms', 'Sliders'); ?></h2>
	<table cellpadding="0" cellspacing="0">
    <thead>
	<tr>
	            <th><?php echo $this->Paginator->sort('active', __d('cms', 'Active'));?></th>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('tiny_name', __d('cms', 'Tiny Name'));?></th>
	            <th><?php echo $this->Paginator->sort('text_color', __d('cms', 'Text Color'));?></th>
	            <th><?php echo $this->Paginator->sort('button_text', __d('cms', 'Button Text'));?></th>
	            <th><?php echo $this->Paginator->sort('button_link', __d('cms', 'Button Link'));?></th>
	            <th><?php echo $this->Paginator->sort('img', __d('cms', 'Img'));?></th>
	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
	            			<th class="actions"><?php echo __d('cms', 'Actions');?></th>
	</tr>
    </thead>
     <tbody>
	<?php
	$i = 0;
	foreach ($sliders as $slider): ?>
	<tr data-id="<?php echo $slider['Slider']['id']; ?>">
            <td style="text-align: center;"><?php echo $slider['Slider']['active'] ? __d('cms', 'TAK') : __d('cms', 'NIE'); ?>&nbsp;</td>
		<td><?php echo h($slider['Slider']['name']); ?>&nbsp;</td>
		<td><?php echo h($slider['Slider']['tiny_name']); ?>&nbsp;</td>
		<td><?php echo h($slider['Slider']['text_color']); ?>&nbsp;</td>
		<td><?php echo h($slider['Slider']['button_text']); ?>&nbsp;</td>
		<td><?php echo h($slider['Slider']['button_link']); ?>&nbsp;</td>
		<!--<td><?php // echo h($slider['Slider']['img']); ?>&nbsp;</td>-->
                <td>
                    <?php echo $this->Image->thumb('/files/slider/'.$slider['Slider']['img'], array('width'=>100,'height'=>100)); ?>
                </td>
		<td><?php echo $this->FebTime->niceShort($slider['Slider']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($slider['Slider']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__d('cms', 'View'), array('action' => 'view', $slider['Slider']['id'])); ?>
			<?php echo $this->Permissions->link(__d('cms', 'Edit'), array('action' => 'edit', $slider['Slider']['id'])); ?>
			<?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $slider['Slider']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $slider['Slider']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
     </tbody>
	</table>