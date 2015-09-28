<?php $this->set('title_for_layout', __d('cms', 'Nowa wiadomość » Newsletter')); ?>

<div class="newsletterMessages form">
    <h2><?php echo __d('cms', 'Utwórz %s', 'wiadomość newslettera'); ?></h2>
    <?php echo $this->Form->create('NewsletterMessage'); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Nagłówki wiadomości'); ?></legend>
        <?php
        echo $this->Form->input('title', array('label' => __d('cms', 'Tytuł')));
        echo $this->Form->input('sender_name', array('label' => __d('cms', 'Nazwa nadawcy')));
        echo $this->Form->input('sender_email', array('label' => __d('cms', 'Email nadawcy')));
        ?>
    </fieldset>

    <fieldset>
        <legend><?php echo __d('cms', 'Treść HTML'); ?></legend>
        <?php echo $this->FebTinyMce4->input('html_content', array('label' => false), 'full', array('width' => 718)); ?>
    </fieldset>

    <fieldset>
        <legend><?php echo __d('cms', 'Treść tekstowa'); ?></legend>
        <?php echo $this->Form->input('content', array('label' => false, 'class' => 'noEditor', 'style' => 'width: 80ex;')); ?>
    </fieldset>

    <?php echo $this->Form->submit(__d('cms', 'Zapisz')); ?>
    <?php echo $this->Form->end(); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__d('cms', 'Lista wiadomości newslettera'), array('action' => 'index')); ?></li>
    </ul>
</div>