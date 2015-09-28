<?php echo __d('cms', 'Witaj'); ?> <?php echo $user['name'] ?>,


<?php echo __d('cms', 'Aby ustawić nowe hasło, kliknij poniższy link:'); ?>


<?php echo Router::url($resetLink, true); ?>

--
<?php __d('cms', 'Zgłoszenie wysłane:') ?> <?php echo date('Y-m-d H:i:s'); ?>, <?php __d('cms', 'z adresu:') ?> <?php echo $ip; ?>
