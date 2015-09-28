<?php if (!empty($logged_in) && $logged_in): ?> 
    <?php $auth = $this->Session->read('Auth'); ?>
    <div>
        <?php echo $this->Html->link(__d('front', 'Wyloguj się'), array('plugin' => 'user', 'controller' => 'users', 'action' => 'logout')); ?>
        <?php if (!empty($auth['Groups']['superAdmins']) || !empty($auth['Groups']['admins']) || !empty($auth['Groups']['editors'])): ?>
            <?php echo $this->Html->link(__d('front', "Moje konto"), array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'my_orders_active')); ?>
            <?php echo $this->Html->link(__d('front', "Przejdź do panelu"), array('plugin' => 'panel', 'controller' => 'panel', 'action' => 'index', 'admin' => 'admin')); ?>
        <?php elseif (!empty($auth['User']['id'])): ?>
            <?php echo $this->Html->link(__d('front', "Moje konto"), array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'my_orders_active')); ?>
        <?php endif; ?>
        <span class="welcome"><?php echo __d('front', 'Witaj') . ' ' . $auth['User']['name']; ?></span>  
    </div>
<?php else: ?>
    <?php echo $this->Form->create('User', array('url' => '/user/users/login', 'class' => 'clearfix')); ?>
    <?php // echo $this->Session->flash(); ?>
    <?php // echo $this->Session->flash('auth'); ?>

    <div class="actionLogin">
        <?php
        echo $this->Form->submit(__d('front', 'Zaloguj'));
//        echo $this->Form->input('remember', array('type' => 'checkbox', 'label' => 'Zapamiętaj mnie'));
        ?>
        <?php echo $this->Html->link(__d('public', 'Rejestracja'), array('plugin' => 'user', 'controller' => 'users', 'action' => 'register'), array('class' => 'registerLink')); ?>

    </div>

    <div class="formLog">
        <?php
        echo $this->Form->input('email', array('label' => false, 'placeholder' => 'e-mail'));
        echo $this->Form->input('pass', array('label' => false, 'type' => 'password', 'placeholder' => __d('front', 'hasło')));
//        echo $this->Html->link(__d('cms', 'Nie pamiętasz hasła? Przypomnij hasło.'), array('plugin' => 'user', 'controller' => 'users', 'action' => 'pass_recall'));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
<?php endif; ?>