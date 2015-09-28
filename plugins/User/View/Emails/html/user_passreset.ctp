<p><big><?php echo __d('cms', 'Witaj'); ?> <?php echo $user['name'] ?>,</big></p>
<p>&nbsp;</p>
<p><?php echo __d('cms', 'Aby ustawić nowe hasło, kliknij poniższy link:'); ?></p>
<p>&nbsp;</p>
<?php $link = Router::url($resetLink, true); ?>
<p><a href="<?php echo $link ?>" ><?php echo $link ?></a></p>
<p>&nbsp;</p>
<p style="font-style: italic;"><?php __d('cms', 'Zgłoszenie wysłane:') ?> <?php echo date('Y-m-d H:i:s'); ?>, <?php __d('cms', 'z adresu:') ?> <?php echo $ip; ?></p>

