<?php
$html->script(array('jquery-ui-1.8.6.custom.min', 'tree'), array('inline'=>false));
$html->css('tree',null, array('inline'=>false));
if(!isset($categories)){
    $categories = $this->requestAction(array('controller'=>'categories', 'action'=>'index', 'admin'=>false));
    $this->Html->scriptBlock('
        $(document).ready(function() {
          jQuery("div#tree").each(function(){
              jQuery(this).appendTo(jQuery("#leftMenuContent"));
            });
    });	
    ', array('inline'=>false));
}
?>
<div id="tree"  <?php echo isset($notMenuLeft)?'class="MenuLeft"':''; ?>>
    <h2><span><?php echo  __d('cms', 'Categories');?></span></h2>
    
    <ul id="categories">
        <li class="firstLiTree">
            <p>Wprowadź nazwę kategorii w polu tekstowym poniżej, a następnie przeciągnij czerwony obiekt do kategorii .</p>
    
            <?php echo $this->Form->input('Category.name', array('onkeyup' => 'updateDragBox()')); ?>
            
            <div class="child"  id="ui-draggable"><span></span></div>
        
        </li>
        <li id="category">
            <?php echo $this->element('tree/draw_category', array('data' => $categories,'FirstJsTrue'=>true)); ?>
        </li>
    </ul>
</div>