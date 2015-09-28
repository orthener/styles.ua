<?php if ($data): ?>
    <?php echo empty($FirstJsTrue) ? $this->Html->link('&ndash;', '#', array('class' => 'toggle', 'escape' => false)) : ''; ?>
    <ul>
        <?php foreach ($data as $key => $value): ?>
            <li id="category_<?php echo $value['Menu']['id']; ?>">
                <?php echo ($key == 0) ? $this->Html->div(null, '&nbsp;', array('escape' => false, 'class' => 'sortTop sort')) : ''; ?>            

                <?php
//draw li from li_position element, or from li_position_leftmenu (dependent from treeMode)
                $el_name = 'li_position';
                if ($treeMode == 'MenuLeft') {
                    $el_name = 'li_position_leftmenu';
                }
                ?>
                <?php //draw app element if specified, otherwise draw default plugin element ?>


                <?php echo $this->element($el_name, array('value' => $value, 'treeMode' => $treeMode)); ?>



                <?php
                echo $this->element('draw', array(
                    'data' => $value['children'],
                    'treeMode' => $treeMode
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
        urlPostUpdate = '<?php echo $this->Html->url(array('controller' => 'menus', 'action' => 'update', 'admin' => true), true); ?>';
        urlPostAdd = '<?php echo $this->Html->url(array('controller' => 'menus', 'action' => 'add', 'admin' => true), true); ?>';
        	
        jQuery("div#tree li.firstLiTree").dblclick(function(){
            jQuery(this).removeClass("firstLiTree");
        });
    </script>
<?php endif; ?>