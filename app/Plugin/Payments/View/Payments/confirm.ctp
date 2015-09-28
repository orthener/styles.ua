<?php
//echo $this->FebHtml->meta('description','',array('inline'=>false));
//echo $this->FebHtml->meta('keywords','',array('inline'=>false));
$this->set('title_for_layout', __d('public', 'Potwierdzenie', true));
?>
<div class="clearfix configurations ">
    <div class="orders white-background">
        <?php if ($status == 'ok'): ?>

            <h1 class="orange"><?php echo empty($payment) ? __d('payments', 'Płatność jest w trakcie realizacji', true) : __d('payments', 'Płatność przebiegła pomyślnie', true); ?></h1>
            <div class="p10" style="margin-top: 50px;">
                <?php if (empty($payment)): ?>
                    <p>
                        <?php echo __d('payments', "Trwa oczekiwanie na potwierdznie ze strony systemu płatności elektroniczych. Może to potrwać do 48 godzin. <br />
                            (Zwykle transakcja jest finalizowana do 15 min od dokonania płatności)", true); ?>
                    </p>

                    <p>
                        <?php echo __d('payments', "Jeśli płatność nie zostanie potwierdzona w przeciągu 48h od dokonania płatności, prosimy o przesłanie formularzem
         kontaktowym zgłoszenia zawierającego datę i godzinę transakcji, oraz dane kontaktowe używane podczas transakcji.", true); ?>
                    </p>
                <?php else: ?>
                    <p>
                        <?php echo __d('payments', "Płatność została potwierdzona przez system płatności elektronicznej. <br />
         O dalszym przebiegu realizacji zamówienia będziemy informować przez email.", true); ?>
                    </p>
                <?php endif; ?>
            </div>

        <?php else: ?>

            <h1 class="orange"><?php echo __d('payments', 'Płatność nie została wykonana', true); ?></h1>
            <div class="p10" style="margin-top: 50px;">
                <p> 
                    <?php echo __d('payments', "W razie problemów, prosimy o przesłanie formularzem kontaktowym
         zgłoszenia zawierającego datę i godzinę transakcji, dane kontaktowe używane podczas transakcji, 
         oraz treść poniższego komunikatu.", true); ?>
                </p>

                <p><?php echo __d('payments', "Informacja systemu płatności:", true); ?>
                    <strong><?php echo $errorCodes[$error]; ?></strong>
                </p>
            </div>

        <?php endif; ?>

        <div class="clearfix orderRedLink p10">
            <?php echo $this->Session->check('Auth.User.id') ? $this->Html->link('Moje zamówienia', array('controller' => 'customers', 'action' => 'my_orders_active', 'plugin' => 'commerce'), array('class' => 'orangeButton2 fr')) : ''; ?>
            <?php echo $this->Html->link('Kolejne zamówienie', '/', array('class' => 'blueButton fl')); ?>
        </div>
    </div>
</div>