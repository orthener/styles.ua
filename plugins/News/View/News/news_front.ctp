<!--<h1>
<?php // echo $this->Html->link(__d('cms', 'wszystkie »'), array('controller' => 'news', 'plugin' => 'news', 'action' => 'index')); ?>
<?php // echo __d('cms', 'Ostatnie wydarzenia'); ?>
</h1>-->
<?php foreach ($news as $new) : ?>
    <?php $linkView = array('controller' => 'news', 'plugin' => 'news', 'action' => 'view', $new['News']['slug'], 'type' => 'blog'); ?>
    <article class="blogLast clearfix" style="overflow:hidden;">
        <?php //echo $this->Image->thumb('/files/photo/' . $new['Photo']['img'], array('width' => '71', 'height' => '71')); ?>
        <?php // echo $this->Html->image('/files/photo/'.$new['Photo']['img']); ?>
        <h2><?php echo $new['News']['created']; ?> <?php echo $this->Html->link($this->Text->truncate(strip_tags($new['News']['title']), 50), $linkView); ?></h2>
        <p><?php echo $this->Text->truncate(strip_tags($new['News']['content']), 125) ?> <?php echo $this->Html->link(' '.  __d('front', 'rozwiń').' »', $linkView); ?></p>
    </article>
<?php endforeach; ?>