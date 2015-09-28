<?php //tabs

echo $this->Html->link(__d('cms', 'Wybierz'), '#', array('onclick'=>"openDialog(); return false;",'class'=>'button'));
?>
<div id="dialogTree" style="display:none">
<ul>
	<li><?php echo $this->Html->link('Sklep', array('plugin' => 'menu', 'admin' => true, 'controller' => 'menus', 'action'=>'relatedindex', 'Page.Page','shop')); ?></li>
	<li><?php echo $this->Html->link('Blog', array('plugin' => 'menu', 'admin' => true, 'controller' => 'menus', 'action'=>'relatedindex', 'Page.Page','blog')); ?></li>
	<li><?php echo $this->Html->link('Studio', array('plugin' => 'menu', 'admin' => true, 'controller' => 'menus', 'action'=>'relatedindex', 'Page.Page','studio')); ?></li>
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
        jQuery('#MenuModel').val(model);
        jQuery('#MenuRowId').val(model_id);
        jQuery('#model_title').val(jQuery('#' + model + '_' + model_id).text());
        jQuery('#dialogTree').dialog('close');
    }
	
</script>