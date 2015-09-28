<p><big><?php echo __d('cms', 'Witaj'); ?></big></p>
<p>&nbsp;</p>
<p><?php echo __d('cms', 'Aby dokończyć proces rejestracji, należy kliknąć (lub wkleić w pasek adresu przeglądarki) poniższy link:'); ?></p>
<?php $link = Router::url(array('plugin' => 'user', 'admin' => false, 'controller' => 'users', 'action' => 'activate', $user['User']['id'], $user['User']['md5']), true); ?>
<p>&nbsp;</p>
<p><a href="<?php echo $link ?>" ><?php echo $link ?></a></p>
