<?php 
if(isset($name)){
    echo $name;
}else{
    echo $this->Form->create('Category');
    	echo $this->Form->input('id');
    	echo $this->Form->input('name', array('label'=>false));
    	
        echo $this->Js->link('anuluj', 
                            array('action'=>'edit_name',$this->Form->value('id'),1) ,
                            array('update'=>'#category_'.$this->Form->value('id').' span:first',
                                   'class'=>'anulujLink' 
                                )
                        );
    	
    	echo $this->Js->submit('zapisz', 
                            array('update'=>'#category_'.$this->Form->value('id').' span:first')
                            );
                            
    	
    echo $this->Form->end(); 
    
    echo $this->Js->writeBuffer();
}

?>