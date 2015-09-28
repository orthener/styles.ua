<h2><?php echo __d('cms', 'Blog'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('photo_id', __d('cms', 'Photo Id')); ?></th>
            <th><?php echo $this->Paginator->sort('news_category_id', __d('cms', 'Kategoria')); ?></th>
            <th><?php echo $this->Paginator->sort('title', __d('cms', 'News Title')); ?></th>
            <th><?php echo $this->Paginator->sort('main', __d('cms', 'Main')); ?></th>
            <th><?php echo $this->Paginator->sort('is_published', __d('cms', 'Czy opublikować')); ?></th>
            <!--<th><?php // echo $this->Paginator->sort('blog', __d('cms', 'Typ'));  ?></th>-->
            <th><?php echo $this->Paginator->sort('user_id', __d('cms', 'User Id')); ?></th>
            <th><?php echo $this->Paginator->sort('date', __d('cms', 'Date')); ?></th>
            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
            <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        <?php foreach ($news as $news): ?>
            <tr data-id="<?php echo $news['News']['id']; ?>">
                <td>
                    <?php echo $this->Image->thumb('/files/photo/' . $news['Photo']['img'], array('width' => 100, 'height' => 100)); ?>
                </td>
                <td><?php echo empty($news_categories[ $news['News']['news_category_id'] ]) ? '' : $news_categories[ $news['News']['news_category_id'] ]; ?></td>
                <td><?php echo h($news['News']['title']); ?>&nbsp;</td>
                <td><?php echo $news['News']['main'] ? __d('cms', 'TAK') : __d('cms', 'NIE'); ?>&nbsp;</td>
                <td><?php echo $news['News']['is_published'] ? __d('cms', 'TAK') : __d('cms', 'NIE'); ?>&nbsp;</td>
                <!--<td><?php // echo h($news['News']['blog'] ? __d('cms', 'Blog') : __d('cms', 'Aktualność'));  ?>&nbsp;</td>-->
                <td><?php echo $news['User']['name']; ?></td>
                <td><?php echo $this->FebTime->niceShort($news['News']['date']); ?></td>
                <td><?php echo $this->FebTime->niceShort($news['News']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($news['News']['modified']); ?></td>
                <td class="actions">
                    <?php //echo $this->Permissions->link(__d('cms', 'View'), array('action' => 'view', $news['News']['id'])); ?>
                    <?php echo $this->Permissions->link(__d('cms', 'Zdjęcia'), array('plugin' => 'photo', 'controller' => 'photos', 'action' => 'index', 'News.News', $news['News']['id'])); ?>


                    <!--<div class="button"> Edytuj<br />-->
                        <?php 
                        //echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', array('url' => array_merge(array('action' => 'edit', $news['News']['id'])), 'active' => $news['translateDisplay'], 'title' => __d('cms', 'Edytuj')))); 
                        // echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', array('url' => array_merge(array('action' => 'edit', $news['News']['id'])), 'title' => __d('cms', 'Edytuj')))); 
                        ?>
                    <!--</div>-->
                    <?php //echo $this->element('Translate.flags/trash', array('data' => $news, 'model' => 'News')); ?> 
                    <?php echo $this->Permissions->link(__d('cms', 'Edytuj'), array('action' => 'edit', $news['News']['id']), array()); ?>
                    <?php echo $this->Permissions->link(__d('cms', 'Usuń'), array('action' => 'delete', $news['News']['id']), array()); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>