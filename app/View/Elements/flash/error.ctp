<div id="flashMessage" class="error_message">
    <?php
    if (isset($url))
        echo '<a href="' . $url . '">';
    ?> 
    <?php echo $message; ?>

    <?php
    if (isset($url))
        echo '</a>';
    ?>   
</div>