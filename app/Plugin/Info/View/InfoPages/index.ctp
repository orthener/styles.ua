<?php $this->set('title_for_layout', __d('public', 'List') . ' &bull; ' . __d('cms', 'Info Pages')); ?>
<div class="infoPages index clearfix">
    <?php //echo $this->Element('InfoPages/table_index'); ?> 
    <div id="rightPageColumn">
        <div id="borderPage">
            <h1><?php echo $on_blog == 1 ? __d('public', 'Blog') : __d('public', 'Aktualności'); ?></h1>
            <?php foreach ($infoPages as $infoPage) { ?>
                <?php //debug($infoPage); ?>
                <div class="listBox">
                    <?php echo $this->Html->link('<h2>' . $infoPage['InfoPage']['title'] . '</h2>', array('plugin' => 'info', 'controller' => 'info_pages', 'action' => 'view', $infoPage['InfoPage']['slug'])); ?>
                    <h3><?php echo $infoPage['InfoPage']['publication_date'] ?></h3>
                    <div class="clearfix">
                        <?php echo $infoPage['InfoPage']['content']; ?>
                    </div>
                </div>
            <?php } ?>
            <?php echo $this->Element('default/paginator'); ?>
        </div>
    </div>
    
    
    
    <div id="leftPageColumn">
        <ul>
            <?php foreach ($infoCategories as $id => $infoCategoryName): ?>
                <?php
                $params = array();
                $params['class'] = (!empty($this->request->params['named']['category']) && $this->request->params['named']['category'] == $id ) ? 'active' : '';
                ?>
                <li><?php echo $this->Html->link($infoCategoryName, array('category' => $id), $params); ?></li>
            <?php endforeach; ?>
        </ul>
        <h3><?php echo __d('public', 'Najpopularniejsze tagi'); ?></h3>
        <p>
            <?php
            $clickedMax = @max(Set::combine($tags, '{n}.InfoTag.count', '{n}.InfoTag.count'));
            $tagsLinks = array();
            foreach ($tags as $tag) {
                $label = $tag['InfoTag']['name'] . ' (' . $tag['InfoTag']['count'] . ')';
                $fontSize = $this->FebHtml->getTagSize($clickedMax, $tag['InfoTag']['count']);
                $color = $this->FebHtml->getTagColor($clickedMax, $tag['InfoTag']['count']);
                $style = 'font-size:' . $fontSize . 'px; color: rgb(' . $color . ');';
                $tagsLinks[] = $this->Html->link($label, array('tag' => base64_encode($tag['InfoTag']['name'])), array('style' => $style));
            }
            echo implode(', ', $tagsLinks);
            ?>
        </p>
    </div>

</div>
<?php echo $this->Html->addCrumb(__d("public", "Lasopedia"), array('action' => 'index')); ?>
<?php echo $this->element('default/crumb'); ?>