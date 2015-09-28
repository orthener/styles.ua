<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
    echo $this->Form->input('name', array('label' => 'Nazwa Grupy Uzytkowników'));
    echo $this->Form->input('minimum', array('label' => 'Minimalny Obrót [PLN]'));
    $options = array();
    for($i = 0; $i <= 100; $i++) {
        $options[] = $i;
    }
    echo $this->Form->input('discount', array('label' => "Rabat [%]" ,'options' => $options));
	?>
</fieldset>
