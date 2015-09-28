<?php if(empty($is_ajax)){ ?>
<div>
<?php if($treeMode == ''){ ?>
     <?php if(is_file(APP. 'Views' . DS . 'Elements' . DS .'tree'.DS.strtolower($modelAlias).DS.'title.ctp')){ ?>
        <?php echo $this->element('tree'.DS.strtolower($modelAlias).DS.'title'); ?>
    <?php } else { ?>
        <?php echo $this->element('title'); ?>
    <?php } ?>
<?php } ?>
<?php echo $this->element('indexsort', array('tree' => $tree, 'plugin' => 'tree')); ?>
</div>
<?php } else { ?>
<?php echo $this->element('indexsort', array('tree' => $tree, 'plugin' => 'tree')); ?>
<?php } ?>