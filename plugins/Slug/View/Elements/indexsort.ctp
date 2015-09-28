<?php
if (!isSet($treeMode)) {
    $treeMode = '';
}
if (!isSet($related)) {
    $related = '';
}
$this->set('related_model', $related);
if (!isSet($related_id)) {
    $related_id = '';
}
$this->set('related_model_id', $related_id);

if (empty($is_ajax)) {
    $this->Html->script(array('jquery-ui-1.8.9.custom.min.js', 'jquery.blockui.js', '/tree/js/tree'), array('inline' => false));
    $this->Html->css('/tree/css/tree', null, array('inline' => false));
}

if (!isset($tree)) {
    $tree = $this->Html->requestAction(array('plugin' => 'tree', 'controller' => 'tree', 'action' => 'index', 'admin' => false, 'user' => false), array('pass' => array($modelAlias)));
}

if (empty($is_ajax)) {
    if ($treeMode == 'MenuLeft') {
        $this->Html->scriptBlock('
            $(document).ready(function() {
              jQuery("div#tree").each(function(){
                  jQuery(this).appendTo(jQuery("#leftMenuContent"));
                });
            });	
        ', array('inline' => false));
    }
}
if (empty($is_ajax)) {
    ?>
    <div id="tree" <?php echo empty($treeMode) ? '' : 'class="' . $treeMode . '" '; ?>>
    <?php } ?>
    <?php echo $this->Session->flash(); ?>

    <ul id="categories">
        <?php if ($treeMode != 'MenuLeft') { ?>
            <?php if (is_file(APP. 'Views' . DS . 'Elements' . DS . 'tree' . DS . strtolower($modelAlias) . DS . 'li_add.ctp')) { ?>
                <?php echo $this->element('tree' . DS . strtolower($modelAlias) . DS . 'li_add'); ?>
            <?php } else { ?>
                <?php echo $this->element('li_add'); ?>
            <?php } ?>
        <?php } ?>            

        <script type="text/javascript">
            jQuery('#TreeName').attr('value','');
            uiHidden();
            jQuery('#flashMessage').click(function(){
                jQuery(this).css('display', 'none');
            });
        </script>
        <li id="category">
            <?php
            echo $this->element('draw', array(
                'treeMode' => $treeMode,
                'data' => $tree,
                'modelAlias' => $modelAlias,
                'FirstJsTrue' => true,
                'plugin' => 'tree'
            ));
            ?>
        </li>
    </ul>
<?php if (empty($is_ajax)) { ?>
    </div>
<?php } ?>
