<?php 
echo $this->Form->create('Newsletter', array('id'=>'newsletterForm'));

$value = __d('cms','wpisz adres e-mail');

echo $this->Form->input('email', array(
                                'label'=>false,
                                'value'=>$value,
                                'onblur'=>'if(!jQuery(this).val()){this.value="'.$value.'"};',
                                'onfocus'=>'if(jQuery(this).val() == "'.$value.'"){this.value=""};'
                                ));
                                
echo $this->Js->submit(__d('cms','Dołącz'), array(
                                    'update'=>'#newsletter',
                                    'url'=>array('user'=>false, 'controller'=>'newsletters', 'plugin'=>'newsletter','action'=>'add'),
//                                    'before'=>'newsletterBlock()',
                                    ));

echo $this->Form->end();   

echo $this->Js->writeBuffer();         
?>
<script type="text/javascript">
function newsletterBlock(){
    jQuery('#newsletter').block({message: "<?php __d('cms','Proszę czekać'); ?>",
    
    css: { 
        padding:        0, 
        margin:         0, 
        width:          '30%', 
        top:            '40%', 
        left:           '35%', 
        textAlign:      'center', 
        color:          '#fff', 
        border:         'none 0px', 
        backgroundColor:'transparent', 
        cursor:         'wait' 
    }, 
 
    // styles for the overlay 
    overlayCSS:  { 
        backgroundColor: '#000', 
        opacity:         0.6 
    }
    
    });
}
function newsletterUnBlock(){
    jQuery('#newsletter').unblock();
}	
</script>