<?php $this->set('title_for_layout', __d('cms', 'Logowanie')); ?>
<?php echo $this->Html->css('login') ?>
<div id="contentGradient">
    <div class="fixed_overlay">
        <div class="overlay_content"></div>
        <div class="ajax_login_form" >
            <?php echo $this->Form->create('User', array('action' => 'login', 'class' => 'clearfix')); ?>
            <div id="orangeLoginHeader">
                <h3>Witaj użytkowniku!</h3>
            </div>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->Session->flash('auth'); ?>
            <?php
            echo $this->Form->input('email', array('label' => 'E-mail:'));
            echo $this->Form->input('pass', array('label' => 'Hasło:', 'type' => 'password'));
            echo $this->Js->submit(__d('front', 'Zaloguj'), array('update' => '#contentGradient', 'url' => array('controller' => 'users', 'action' => 'ajaxlogin', 'admin' => false, 'plugin' => false)));
            //echo $this->Form->input('remember', array('type'=>'checkbox', 'label'=>'Zapamiętaj mnie'));
            echo $this->Form->end();

            echo $this->Js->writeBuffer();
            ?>

        </div>
    </div>

</div>