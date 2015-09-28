<div>
    <?php
    $url = $movie['StudioMovie']['url'];
    $tmp = explode("v=", $url);
    $yt_id = $tmp[1];
    ?>
    
    <iframe width="301" height="175" src=<?php echo "//www.youtube.com/embed/" . $yt_id; ?> frameborder="0" allowfullscreen></iframe>
</div>