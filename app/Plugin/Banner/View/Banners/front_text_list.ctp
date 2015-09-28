<?php foreach ($banners as $banner): ?>
    <li><?php echo $this->Html->link($banner['Banner']['name'], array('plugin' => 'banner', 'controller' => 'banners', 'action' => 'view', $banner['Banner']['slug']), array('id' => $banner['Banner']['id'], 'escape' => false));
    ?></li>
<?php endforeach; ?>
