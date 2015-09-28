<?php $this->set('title_for_layout', __d('public', 'Rejestracja')); ?>
<?php $this->Html->addCrumb(__d('cms', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb(__d('cms', 'Rejestracja'), array('action' => 'register')); ?>
<div class="row-fluid">
    <div class="container">
        <div class="breadcrump span8 my-span8 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
</div>
<div class="white-background register clearfix">
    <div class="clearfix">
        <div class="border-page padding20">

            <div class="title clearfix">
                <h1><?php echo __d('cms', 'Konto zostało utworzone'); ?></h1>
            </div>
            <p>
                <?php echo __d('cms', 'Dziękujemy za rejestrację.'); ?>
            </p>
            <p>
                <?php echo __d('cms', 'Odbierz pocztę email, aby aktywować konto.'); ?>
            </p>
        </div>
    </div>
</div>