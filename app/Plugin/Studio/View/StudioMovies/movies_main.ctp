<div>
<?php if($movie['StudioMovie']['media_type']): ?>
    <?php echo $this->element('StudioMovies/jplayer');?>
<?php else: ?>
    <?php echo $this->element('StudioMovies/youtube');?>
<?php endif; ?>
</div>
