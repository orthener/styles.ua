<?php foreach ($newsCategories as $newsCategory): ?>
    <li><?php echo $this->Html->link($newsCategory['NewsCategory']['name'], array('type' => 'blog', 'plugin' => 'news', 'controller' => 'news', 'action' => 'index', $newsCategory['NewsCategory']['slug']), array('id' => $newsCategory['NewsCategory']['id'], 'escape' => false));
    ?></li>
<?php endforeach; ?>
