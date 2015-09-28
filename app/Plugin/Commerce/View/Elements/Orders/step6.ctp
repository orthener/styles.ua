<div class="orderReference">
    <div class="orderReferenceLabel"><?php echo __d('front', 'Wpisz dane osoby rekomendującej'); ?></div>
    <?php echo $this->Form->input('OrderReference.name', array('label' => __d('public', 'Imię i Nazwisko:')));  ?>
    <?php echo $this->Form->input('OrderReference.phone', array('label' => __d('public', 'Telefon:')));  ?>
</div>
<div>
    <div class="komentarzLabel"><?php echo __d('front', 'Dodaj komentarz do zamówienia'); ?>:</div>
    <?php echo $this->Form->input('note', array('type' => 'textarea','label'=>false)); ?>
</div>