<?php $title = __d('public', 'Faktury'); ?>
<?php $this->set('title_for_layout', $title); ?>

<div id="my-account">
    <?php echo $this->element('customer/menu'); ?>
    <div id="my-account-content">
        <h1><?php echo $title ?></h1>
    </div>
</div>