<div class="clearfix">
    <div class="formularz-kontaktowy">
        <div class="kontakt clearfix">
            <h3><?php echo __d('public', 'Formularz kontaktowy'); ?></h3>
            <?php
            echo $this->Form->create('Page');
            echo $this->Form->input('imieNazwisko', array(
                'label' => __d('public', 'Imię i Nazwisko:'),
            ));
            echo $this->Form->input('email', array(
                'label' => 'E-mail:',
            ));
            echo $this->Form->input('wiadomosc', array(
                'label' => __d('front', 'Wiadomość:'),
                'type' => 'textarea'
            ));
            echo $this->Form->submit(__d('cms', 'Wyślij'));
            ?>

            <!--                <div class="buttonRed clearfix">
                                <a href="#form"><?php echo __d('public', 'Zadaj pytanie</span>'); ?></a>
                            </div>-->
        </div>
    </div>
</div>
