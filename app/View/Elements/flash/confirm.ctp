<div id="flashMessage" class="confirm_message">
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