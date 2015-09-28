<?php $this->set('title_for_layout',__d('cms','Logowanie')); ?>

<?php echo $this->Form->create('User', array('url' => '/'.$this->params->url, 'class'=>'clearfix','id'=>'UserLoginForm')); ?>
    <div id="orangeLoginHeader">
    <h3>Witaj użytkowniku!</h3>
    </div>
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Session->flash('auth'); ?>
    <?php
    echo $this->Form->input('email',array('label'=>'E-mail:','value'=>'testowanie'));
    echo $this->Form->input('pass',array('label'=>'Hasło:','type'=>'password'));
    echo $this->Form->submit('Zaloguj');
    //echo $this->Form->input('remember', array('type'=>'checkbox', 'label'=>'Zapamiętaj mnie'));
echo $this->Form->end();
?>
