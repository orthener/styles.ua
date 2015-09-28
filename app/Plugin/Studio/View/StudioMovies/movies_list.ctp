<!--<h1>Movies List</h1>-->
<?php $i = 0; ?>
<?php foreach ($movies as $movie): ?>
    <?php if ($movie['StudioMovie']['media_type']): ?>
        <?php echo $this->element('StudioMovies/jplayer', array('movie' => $movie));?>
    <?php else: ?>
        <?php echo $this->element('StudioMovies/youtube', array('movie' => $movie));?>
    <?php endif; ?>
<?php endforeach; ?>
