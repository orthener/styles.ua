<?php isset($step)?$step:''; ?>
<div class="steps clearfix">
    <div class="step <?php echo (1 < $step)?'already':''; ?> <?php echo ($step == 1)?'active':''; ?>">
        <?php echo (1 < $step)?$this->Html->link('<b>1</b> <span>WIDOK<br />KOSZYKA</span>',array('controller'=>'orders','action'=>'cart','plugin'=>'commerce'), array('escape'=>false)):'<b>1</b> <span>WIDOK<br />KOSZYKA</span>'; ?>
    </div>
    <div class="step  <?php echo (2 < $step)?'already':''; ?> <?php echo ($step == 2)?'active':''; ?>">
        <?php echo (2 < $step)?$this->Html->link('<b>2</b> <span>DANE<br /> KLIENTA</span>',array('controller'=>'customers','action'=>'edit','plugin'=>'commerce'), array('escape'=>false)):'<b>2</b> <span>DANE<br /> KLIENTA</span>'; ?>
        
    </div>
    <div class="step  <?php echo (3 < $step)?'already':''; ?> <?php echo ($step == 3)?'active':''; ?>">
        <?php echo (3 < $step)?$this->Html->link('<b>3</b> <span>PODSUMOWANIE<br /> ZAMÓWIENIA</span>',array('controller'=>'orders','action'=>'summary','plugin'=>'commerce'), array('escape'=>false)):'<b>3</b> <span>PODSUMOWANIE<br /> ZAMÓWIENIA</span>'; ?>
       
    </div>
    <div class="step  <?php echo (4 < $step)?'already':''; ?> <?php echo ($step == 4)?'active':''; ?>">
       <b>4</b> <span><br />PŁATNOŚĆ</span>
    </div>
</div>