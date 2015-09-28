<?php //tabs

echo $this->Html->link('Wybierz ...', '#', array('onclick'=>"openDialog(); return false;",'class'=>'button'));
?>
<div id="dialogTree" style="display:none">
<ul>
	<li><?php echo $this->Html->link('Podstrony', array('plugin' => 'tree', 'admin' => false, 'controller' => 'tree', 'action'=>'relatedindex', 'Page','podstrony')); ?></li>
	<li><?php echo $this->Html->link('Galerie', array('plugin' => 'tree', 'admin' => false, 'controller' => 'tree', 'action'=>'relatedindex', 'Page','galerie')); ?></li>
</ul>

</div>
<script type="text/javascript">
	jQuery('#dialogTree').tabs();
	
	jQuery(document).ready(function(){
    
    });

    function openDialog(){
        if(jQuery('.ui-dialog #dialogTree').length == 1 && jQuery('#treeElementAdd #dialogTree').length == 1){
            jQuery('#treeElementAdd #dialogTree').remove();
        }
        jQuery('#dialogTree').dialog({width:960,top:30});    
    }
	
    function selectModelElement(model, model_id){
        jQuery('#<?php echo $model; ?>Model').val(model);
        jQuery('#<?php echo $model; ?>RowId').val(model_id);
        jQuery('#model_title').val(jQuery('#' + model + '_' + model_id).text());
        jQuery('#dialogTree').dialog('close');
    }
	
</script>