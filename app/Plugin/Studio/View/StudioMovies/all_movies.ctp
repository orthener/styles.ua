<?php $i = 0; ?>
<?php foreach ($movies as $movie): ?>
    <div class="span4 onePlayer">
        <?php echo $this->element('StudioMovies/jplayer', array('movie' => $movie)); ?>
    </div>
    <?php $i++; ?>
    <?php if ($i % 3 == 0): ?>
        </div>
        <div class="row-fluid">
        <?php endif; ?>
    <?php endforeach; ?>
