<h2><?php echo __d('cms', 'Studio Movies'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name')); ?></th>
            <th><?php echo $this->Paginator->sort('author', __d('cms', 'Author')); ?></th>
            <th><?php echo $this->Paginator->sort('is_active', __d('cms', 'Czy aktywny?')); ?></th>
            <th><?php echo $this->Paginator->sort('media_type', __d('cms', 'Media Type')); ?></th>
            <th><?php echo $this->Paginator->sort('file', __d('cms', 'File')); ?></th>
            <th><?php echo $this->Paginator->sort('url', __d('cms', 'Url')); ?></th>
            <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        <?php foreach ($studioMovies as $studioMovie): ?>
            <tr data-id="<?php echo $studioMovie['StudioMovie']['id']; ?>">
                <td><?php echo h($studioMovie['StudioMovie']['name']); ?>&nbsp;</td>
                <td><?php echo h($studioMovie['StudioMovie']['author']); ?>&nbsp;</td>
                <td>
                    <?php if (empty($studioMovie['StudioMovie']['is_active']) || $studioMovie['StudioMovie']['is_active'] == 0): ?>
                        <?php echo __d('cms', 'NIE'); ?> &nbsp;
                    <?php else: ?>
                        <?php echo __d('cms', 'TAK'); ?> &nbsp;
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (empty($studioMovie['StudioMovie']['file']) && empty($studioMovie['StudioMovie']['url'])): ?>
                        <?php echo __d('cms', 'brak'); ?>&nbsp;
                    <?php else: ?>
                        <?php echo $studioMovie['StudioMovie']['media_type'] ? __d('cms', 'pliki') : __d('cms', 'youtube'); ?>&nbsp;
                    <?php endif; ?>
                </td>
                <td>
                    <?php $bufor = $studioMovie['StudioMovie']['file']; ?>
                    <?php echo $studioMovie['StudioMovie']['media_type'] ? '<b>' . $bufor . '</b>' : '<i>' . $bufor . '</i>'; ?>&nbsp;
                </td>
                <td>
                    <?php $bufor = $studioMovie['StudioMovie']['url']; ?>
                    <?php echo $studioMovie['StudioMovie']['media_type'] ? '<i>' . $bufor . '</i>' : '<b>' . $bufor . '</b>'; ?>&nbsp;
                </td>
                <td class="actions">
                    <?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $studioMovie['StudioMovie']['id'])); ?>
                    <?php // echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $studioMovie['StudioMovie']['id'])); ?>
                    <?php //echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $studioMovie['StudioMovie']['id']), null, __('Are you sure you want to delete # %s?', $studioMovie['StudioMovie']['name']));  ?>

                    <div class="button"><?php echo __d('cms', 'Edytuj'); ?><br /> 			
                        <?php $opts = array('url' => array_merge(array('action' => 'edit', $studioMovie['StudioMovie']['id'])), 'active' => $studioMovie['translateDisplay'], 'title' => __d('cms', 'Edit')); ?>
                        <?php echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', $opts)); ?>
                    </div>
                    <?php echo $this->element('Translate.flags/trash', array('data' => $studioMovie, 'model' => 'StudioMovie')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>