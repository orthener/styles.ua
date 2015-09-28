<?php $this->set('title_for_layout', __d('cms', 'Logowanie')); ?>
<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb(__d('public', 'Logowanie')); ?>
<div id="users" class="clearfix orders">
    <div class="container">
        <div class="row-fluid">
            <div class="breadcrump span8 my-span8 bt-no-margin">
                <?php $this->Html->addCrumb(__d('cms', 'Logowanie')); ?>
                <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
            </div>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="border-page padding20 registers">

                <div id="LoginHeader" class="login users">
                    <div class="title clearfix">
                        <h1><?php echo __d('cms', 'Logowanie'); ?></h1>
                    </div>
                    <?php echo $this->Form->create('User', array('action' => 'login', 'class' => 'clearfix')); ?>
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->Session->flash('auth'); ?>
                    <?php
                    echo $this->Form->input('email', array('label' => __d('front', 'E-mail').':'));
                    echo $this->Form->input('pass', array('label' => __d('front', 'Hasło').':', 'type' => 'password'));
                    ?>
                    <div class="actionLogin">
                        <?php
                        echo $this->Form->input('remember', array('type' => 'checkbox', 'label' => __d('cms', 'Zapamiętaj mnie')));
                        echo $this->Form->submit(__d('front', 'Zaloguj'),array('class'=>'btnBlueWhite button black white-text'));
                        echo $this->Html->link(__d('front', 'Nie pamiętasz hasła? Przypomnij hasło.'), array('action' => 'pass_recall'));
                        ?>
                    </div>
                    <?php
                    echo $this->Form->end();
                    ?>

                </div> 
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_minimal',
            radioClass: 'iradio_minimal'
        });
    });
    //]]>
</script>