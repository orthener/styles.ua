<?php if (!empty($empty)) { ?>
    <p>
        Hasło jest ustawione 
    </p>
<?php } else { ?>
    <div class="users form">
        <?php echo $this->Form->create('User'); ?>
        <fieldset>
            <legend><?php echo __d('cms', 'Ustaw hasło'); ?></legend>
            <?php
            echo $this->Form->input('pass', array('label' => __d('cms', 'Hasło'), 'type' => 'password'));
            ?>
        </fieldset>
        <?php echo $this->Form->end(__d('cms', 'Zapisz')); ?>
    </div>
<?php } ?>