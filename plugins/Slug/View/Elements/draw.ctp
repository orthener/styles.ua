<?php if ($data): ?>
    <?php echo empty($FirstJsTrue) ? $this->Html->link('&ndash;', '#', array('class' => 'toggle', 'escape' => false)) : ''; ?>
    <ul>
        <?php foreach ($data as $key => $value): ?>
            <li id="category_<?php echo $value[$modelAlias]['id']; ?>">
                <?php echo ($key == 0) ? $this->Html->div(null, '&nbsp;', array('escape' => false, 'class' => 'sortTop sort')) : ''; ?>            



                <?php
//draw li from li_position element, or from li_position_leftmenu (dependent from treeMode)
                $el_name = 'li_position';
                if ($treeMode == 'MenuLeft') {
                    $el_name = 'li_position_leftmenu';
                }
                ?>
                <?php
                //draw app element if specified, otherwise draw default plugin element
                if (is_file(APP. 'Views' . DS . 'Elements' . DS . 'tree' . DS . strtolower($modelAlias) . DS . $el_name . '.ctp')) {
                    ?>
                    <?php echo $this->element('tree' . DS . strtolower($modelAlias) . DS . $el_name, array('value' => $value, 'modelAlias' => $modelAlias, 'treeMode' => $treeMode)); ?>
        <?php } else { ?>
                    <?php echo $this->element($el_name, array('value' => $value, 'modelAlias' => $modelAlias, 'treeMode' => $treeMode)); ?>
                <?php } ?>


                <?php
                echo $this->element('draw', array(
                    'data' => $value['children'],
                    'modelAlias' => $modelAlias,
                    'treeMode' => $treeMode,
                    'plugin' => 'tree'
                ));
                ?>
                <div class="sortDown sort" > &nbsp;</div>
            </li>
    <?php endforeach; ?>

    </ul>

<?php endif; ?>

<?php
if (isset($FirstJsTrue)):

    echo $this->Js->writeBuffer();
    ?>
    <script type="text/javascript">
        initTree();
        indexUrl = '<?php echo $this->Html->url('/', true); ?>tree/tree/index/<?php echo $modelAlias . "/" . $treeMode; ?>';
        url = '<?php echo $this->here; ?>';
    	
        jQuery("div#tree li.firstLiTree").dblclick(function(){
            jQuery(this).removeClass("firstLiTree");
        });
    </script>
<?php endif; ?>