<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
//		echo $this->Form->input('user_id', array('label' => __d('cms', 'User Id')));
    echo $this->Form->input('contact_person', array('label' => __d('cms', 'Contact Person')));
    echo $this->Form->input('email', array('label' => __d('cms', 'Email')));
    echo $this->Form->input('phone', array('label' => __d('cms', 'Phone')));

//    echo $this->Form->hidden('referer', array('default' => $referer));
//		echo $this->Form->input('address_id', array('label' => __d('cms', 'Address Id')));
//		echo $this->Form->input('invoice_identity_id', array('label' => __d('cms', 'Invoice Identity Id')));
    echo $this->Form->input('discount', array('label' => __d('cms', 'Discount'), 'after' => '%', 'style' => 'width: 30px'));
    ?>
</fieldset>
