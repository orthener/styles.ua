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
    $this->Html->script(array('jquery-ui.min.js', 'jquery.blockui.js', '/menu/js/tree'), array('inline' => false));
    $this->Html->css('/menu/css/tree', null, array('inline' => false));
}

if (!isset($tree)) {
    $tree = $this->Html->requestAction(array('controller' => 'menus', 'action' => 'index', 'admin' => false, 'user' => false), array('pass' => array()));
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
        <?php echo $this->element('li_add'); ?>


        <script type="text/javascript">
            jQuery('#MenuName').attr('value','');
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
                'FirstJsTrue' => true,
                'plugin' => 'menu'
            ));
            ?>
        </li>
    </ul>
    <?php if (empty($is_ajax)) { ?>
    </div>
<?php } ?>
