<fieldset>
    <legend><?php echo $desc ?></legend>
<?php
    //, array('type' => 'text', 'label' => 'Powiązanie z Użytkownikiem', 'value' => $user['User']['name'], 'readonly' => true)
    echo $this->Form->input('user_id', array('type' => 'hidden'));
    echo $this->Form->input('contact_person', array('label'=>__d('commerce', 'Klient',true)));
    echo $this->Form->input('email');
    echo $this->Form->input('phone', array('label'=>__d('commerce', 'Telefon',true)));
    
    
//    echo $this->Form->input('address_id', array('label'=>__d('commerce', 'Email',true)));
//    echo $this->Form->input('invoice_identity_id');
    
    
    $options = array();
    for($i = 0; $i <= 100; $i++) {
        $options[] = $i;
    }
    echo $this->Form->input('discount', array('label' => "Rabat [%]" ,'options' => $options));
?>
</fieldset>