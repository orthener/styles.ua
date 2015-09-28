<?php $this->set('title_for_layout', __d('cms', 'Podgląd wiadomości » Newsletter')); ?>
<div class="newsletterMessages view">
    <h2><?php __d('cms', 'Wiadomość newslettera'); ?></h2>
    <?php if ($newsletterMessage['NewsletterMessage']['recipients'] == 0) { ?>
        <?php echo $this->Form->create('NewsletterMessage', array('url' => array('action' => 'send', $newsletterMessage['NewsletterMessage']['id']))) ?>
        <fieldset>
            <legend><?php echo __d('cms', 'Wysyłanie wiadomości'); ?></legend>
        <?php } ?>

        <div><?php echo __d('cms', 'Temat'); ?></div>
        <div><?php echo $newsletterMessage['NewsletterMessage']['title']; ?></div>
        <br />
        <div><?php echo __d('cms', 'Nadawca'); ?></div>
        <div>
            <?php echo $newsletterMessage['NewsletterMessage']['sender_name'] . ' &lt;' . $newsletterMessage['NewsletterMessage']['sender_email'] . '&gt;'; ?>
        </div>
        <br />
        <div><?php echo __d('cms', 'Treść'); ?></div>
        <pre style="border:1px solid #AAAABB; background-color:white;width:130ex;padding:3px 20px;white-space:pre-wrap"><?php
            $text_append = '
        
' . __d('cms', 'Aby zrezygnować z newslettera należy kliknąć w poniższy link:') . '

::'.  __d('cms', 'link wypisania z newslettera').'::';

            echo $this->renderLayout($newsletterMessage['NewsletterMessage']['content'] . $text_append, 'Emails/text/default');
            ?></pre>
        <br />
        <div><?php echo __d('cms', 'Treść HTML'); ?></div>
        <div><iframe style="border:1px solid #AAAABB; background-color:white" width="800" height="300" src="<?php echo Router::url(array('admin' => 'admin', 'controller' => 'newsletter_messages', 'action' => 'htmlpreview', $newsletterMessage['NewsletterMessage']['id'])); ?>"></iframe></div>
        <br />

        <div><?php echo __d('cms', 'Utworzono'); ?></div>
        <div><?php echo $newsletterMessage['NewsletterMessage']['created']; ?></div>
        <div><?php echo ($newsletterMessage['NewsletterMessage']['recipients']) ? __d('cms', 'Wysłano') : __d('cms', 'Zmodyfikowano'); ?></div>
        <div><?php echo $newsletterMessage['NewsletterMessage']['modified']; ?></div>

        <?php if ($newsletterMessage['NewsletterMessage']['recipients'] == 0) { ?>

            <?php echo $this->Form->hidden('id', array('value' => $newsletterMessage['NewsletterMessage']['id'])); ?>
            <?php echo $this->Form->submit(__d('cms', 'Wyślij %s', __d('cms', 'wiadomość newslettera'))); ?>

        </fieldset>
        <?php echo $this->Form->end(); ?>
    <?php } ?>
    <?php if ($newsletterMessage['NewsletterMessage']['recipients'] == 0) { ?>
        <br />
        <?php echo $this->Form->create('NewsletterMessage', array('url' => array('action' => 'test_send', $newsletterMessage['NewsletterMessage']['id']))) ?>
        <fieldset>
            <legend><?php echo __d('cms', 'Wysyłka testowa'); ?></legend>
            <?php echo $this->Form->hidden('id', array('value' => $newsletterMessage['NewsletterMessage']['id'])); ?>
            <?php echo $this->Form->input('email'); ?>
            <?php echo $this->Form->submit(__d('cms', 'Wyślij %s', __d('cms', 'wiadomość newslettera'))); ?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
        <br />
        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__d('cms', 'Edytuj wiadomość newslettera'), array('action' => 'edit', $newsletterMessage['NewsletterMessage']['id'])); ?> </li>
                <li><?php echo $this->Html->link(__d('cms', 'Usuń wiadomość newslettera'), array('action' => 'delete', $newsletterMessage['NewsletterMessage']['id']), null, __d('cms', 'Jesteś pewien, że chcesz usunąć wiadomość o temacie: "%s"?', $newsletterMessage['NewsletterMessage']['title'])); ?> </li>
                <li><?php echo $this->Html->link(__d('cms', 'Lista wiadomości newslettera'), array('action' => 'index')); ?> </li>
            </ul>
        </div>
    <?php } else { ?>
        <?php echo __d('cms', 'Wiadomość została wysłana do %s odbiorców', $newsletterMessage['NewsletterMessage']['recipients']); ?>
        <br />
        <div><?php echo __d('cms', 'Lista odbiorców'); ?></div>
        <pre><?php echo $newsletterMessage['NewsletterMessage']['recipients_list']; ?></pre>
        <br />

    <?php } ?>
</div>