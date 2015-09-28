<?php $this->set('title_for_layout', __d('cms', 'Sort')); ?>
<?php echo $this->Html->css('Sort.sort'); ?>

<h2><span></span><?php echo __('Sortowanie'); ?></h2>
<ul id="sortable">
    <?php foreach ($datas as $data): ?>
        <li class="ui-state-default" data-id="<?php echo $data[$model->alias]['id']; ?>">
            <?php //debug($data[$model->alias]); ?>
            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
            <?php echo $data[$model->alias][$model->displayField]; ?> (<?php echo $data[$model->alias]['id']; ?>)<br/>
            <?php echo ($data[$model->alias]['img']) ? $this->Image->thumb('/files/brand/' . $data[$model->alias]['img'], array('width' => 100, 'height' => 100, 'crop' => false)) : ''; ?>
        </li>
    <?php endforeach; ?>
</ul>

<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List '.Inflector::pluralize($model->alias)), array('plugin' => Inflector::underscore($plugin), 'controller' => Inflector::underscore(Inflector::pluralize($model->alias)), 'action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>

<script type="text/javascript">
    $(function() {
        $("#sortable").sortable({
            stop: function(event, ui) {
                var reLocate = {};
                $("#sortable").find('li').each(function(index, object) {
                    reLocate[index] = $(object).attr('data-id');
                });
                $.ajax({
                    url: '<?php echo $this->Html->url(array('action' => 'resort', $this->request->params['pass'][0])); ?>',
                    dataType: 'html',
                    type: 'POST',
                    data: {
                        data: {
                            reLocate: reLocate
                        }
                    },
                    error: function(data) {
                        alert('<?php echo __d('cms', 'Wystąpił krytyczny bład, skontaktuj się z administratorem') ?>');
//                        location.reload();
                    }
                });

            }
        });
        $("#sortable").disableSelection();
    });
</script>
