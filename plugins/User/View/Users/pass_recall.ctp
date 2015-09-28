<?php $this->Html->addCrumb(__d('front', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb(__d('cms', 'Przypomnienie hasła')); ?>

<?php
echo $this->FebHtml->meta('description', __d('cms', 'Przypomnienie hasła', true), array('inline' => false));
//echo $this->FebHtml->meta('keywords','',array('inline'=>false));
$this->set('title_for_layout', __d('cms', 'Przypomnienie hasła', true));
?>
<div id="users" class="clearfix orders">
    <div class="row-fluid">
        <div class="breadcrump span12 bt-no-margin">
            <span class="navi">NAVIGATION:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="border-page padding20">
                <div class="title clearfix">
                    <h1><?php printf(__d('cms', 'Przypomnienie hasła')); ?></h1>
                </div>
                <div id="passRecall" class="documentContent users login">
                    <?php echo $this->Form->create('User'); ?>
                    <?php
                    echo $this->Form->input('email');
                    ?>
                    <?php echo $this->Form->submit(__d('cms', 'Wyślij'), array('class' => 'btnGradientBlue')); ?>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
