<?php echo __d('cms', 'Witaj,'); ?>


<?php echo __d('cms', 'Aby dokończyć proces rejestracji, należy kliknąć (lub wkleić w pasek adresu przeglądarki) poniższy link:'); ?>


<?php echo Router::url(array('plugin' => 'user', 'admin' => false, 'controller' => 'users', 'action' => 'activate', $user['User']['id'], $user['User']['md5']), true); ?>

