<h2><?php
if (!empty($this->params['realizacje'])):
    $this->set('title_for_layout', __d('cms', 'Lista pozycji » Realizacje'));
    echo __d('cms', 'Realizacje');
else:
    $this->set('title_for_layout', __d('cms', 'Lista pozycji » Podstrony'));
    echo __d('cms', 'Podstrony');
endif;
?></h2>
<table>
    <tr>
        <th>
            <?php //echo $paginator->sort('Tytuł','name'); ?>
        </th>
        <th>
            <?php //echo $paginator->sort('Podgląd','slug'); ?>
        </th>
        <th>
            Opcje
        </th>
    </tr>
    <?php foreach ($pages as $page): ?>
        <tr>
            <td><?php echo $page['Page']['name']; ?> 
            </td>
            <td><?php echo $this->Html->link($page['Page']['slug'], array('admin' => false, 'controller' => 'pages', 'action' => 'view', $page['Page']['slug'])); ?> 
            </td>
            <td class="actions">
                <?php //echo $this->Html->link(__d('cms', 'Edytuj'), array('action'=>'edit', $page['Page']['id']),array(),null,false); ?>
                <?php //echo $this->Html->link(__d('cms', 'Klonuj'), array('action'=>'add',$page['Page']['id']),array(),null,false);  ?>
                <?php //echo $this->Html->link(__d('cms','Usuń'), array('action'=>'delete', $page['Page']['id']), null, __d('cms', 'Czy napewno chcesz usunąć strone # %s?', $page['Page']['name']),false); ?>
                <div class="button"> <?php echo __d('cms', 'Edit'); ?><br />
                    <?php echo $this->Html->div('clearfix', $this->element('Translate.flags/flags', array('url' => array_merge(array('action' => 'edit', $page['Page']['id'])), 'active' => $page['translateDisplay'], 'title' => __d('cms', 'Edytuj')))); ?>
                </div>
                <?php if ($page['Page']['gallery'] == 1): ?>
                    <div class="button"> <?php echo __d('cms', 'Zdjęcia'); ?> <br />
                        <?php echo $this->Html->image('layouts/admin/img.png', array('url' => array('plugin' => 'photo', 'controller' => 'photos', 'action' => 'index', 'Page.Page', $page['Page']['id']))); ?>
                    </div>
                <?php endif; ?>
                <?php echo $this->element('Translate.flags/trash', array('data' => $page, 'model' => 'Page')); ?> 
            </td>
        </tr>
    <?php endforeach; ?>
</table>