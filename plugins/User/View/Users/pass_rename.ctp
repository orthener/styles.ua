<?php $this->Html->addCrumb('Strona główna', '/'); ?>
<?php $this->Html->addCrumb('Zmiana hasła'); ?>

<div id="users" class="clearfix orders">
    <div class="row-fluid">
        <div class="breadcrump span12 bt-no-margin">
            <span class="navi">NAVIGATION:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="border-page padding20">

                <?php
                echo $this->Form->create('User', array('action' => 'pass_rename/' . $form->value('id'), 'class' => 'clearfix'));

                echo $this->Form->hidden('id');
                echo $this->Form->input('pass', array('type' => 'password', 'label' => 'Hasło:'));
                echo $this->Form->input('newpassword', array('type' => 'password', 'label' => 'Nowe hasło:'));
                echo $this->Form->input('confirmpass', array('type' => 'password', 'label' => 'Powtórz hasło'));
                echo $this->Form->end('zmień');
                ?>

            </div>
        </div>
    </div>
</div>