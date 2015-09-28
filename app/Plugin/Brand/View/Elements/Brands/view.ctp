<li id="brand-<?php echo $brand['Brand']['slug']; ?>">
    <div class="brand-logo">dsf
        <?php if(!empty($brand['Brand']['img'])): ?>
            <?php echo $this->Html->image('/files/brand/' . $brand['Brand']['img']); ?>
        <?php endif;?>
    </div>
    <div class="brand-desc">
        <?php echo $brand['Brand']['desc']; ?>
    </div>
</li>