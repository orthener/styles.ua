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

$is_ajax = $this->request->is('ajax');

if (empty($is_ajax)) {
    $this->Html->script(array('jquery-ui.min.js', 'jquery.blockui.js', '/menu/js/tree'), array('inline' => false));
    $this->Html->css('/menu/css/tree', null, array('inline' => false));
}

if (empty($is_ajax)) {
    ?>
    <div id="tree" <?php echo empty($treeMode) ? '' : 'class="' . $treeMode . '" '; ?>>
    <?php } ?>
    <?php echo $this->Session->flash(); ?>

    <ul id="categories">
        <script type="text/javascript">
            jQuery('#MenuName').attr('value','');
            uiHidden();
            jQuery('#flashMessage').click(function(){
                jQuery(this).css('display', 'none');
            });
        </script>
        <li id="category">
            <?php
            echo $this->element('Banners/draw', array(
                'treeMode' => $treeMode,
                'data' => $tree,
                'FirstJsTrue' => true,
                'plugin' => 'photo'
            ));
            ?>
        </li>
    </ul>
    <?php if (empty($is_ajax)) { ?>
    </div>
<?php } ?>
