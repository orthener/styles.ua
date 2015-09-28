<?php foreach ($banners as $banner): ?>
    <?php $img = '<span class="green-flag"></span>' . $this->Html->image('/files/banner/' . $banner['Banner']['img']); ?>
    <?php if (!empty($banner['Banner']['link'])): ?>
        <?php echo $this->Html->link($img, $banner['Banner']['link'], array('id' => $banner['Banner']['id'], 'escape' => false, 'target' => (($banner['Banner']['new_window']) ? '_blank' : false))); ?>
    <?php else: ?>
        <?php echo $img; ?>
    <?php endif; ?>
<?php endforeach; ?>
