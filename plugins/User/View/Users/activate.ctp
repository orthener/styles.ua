<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb(__d('public', 'Rejestracja')); ?>
<div id="users" class="clearfix orders">
    <div class="container">
        <div class="row-fluid">
            <div class="breadcrump span8 my-span8 bt-no-margin">
                <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
            </div>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="border-page padding20">

                <div id="newPass" class="documentContent">
                    <div class="users form">
                        <?php echo $this->Form->create('User', array('url' => '/' . $this->params->url));
                        ?>
                        <h3><?php echo __d('cms', 'Aktywacja konta'); ?></h3>
                        <fieldset>
                            <?php
                            echo $this->Form->input('name', array('label' => __d('cms', 'Login')));
                            echo $this->Form->input('email', array('readonly' => true));
                            echo $this->Form->input('newpassword', array('label' => __d('cms', 'Hasło'), 'type' => 'password', 'value' => ''));
                            echo $this->Form->input('confirmpassword', array('label' => __d('cms', 'Powtórz hasło'), 'type' => 'password', 'value' => ''));
                            ?>
                        </fieldset>
                        <?php echo $this->Form->submit(__d('cms', 'Zapisz'), array('class' => 'btnGradientBlue')); ?>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



