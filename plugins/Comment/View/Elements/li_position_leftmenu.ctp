<?php $class = ($value[$modelAlias]['option'] == 2)?'div-'.$value[$modelAlias]['model'].'-'.$value[$modelAlias]['row_id']:'';; ?>

            <div class="child clearfix <?php echo $class; ?>">
<!--                <div class="action"> -->
                <?php 
                    $optionsFull = array('update'=>'#tree', 'before'=>'blockAll();', 'complete'=>'unblockAll();');
                 ?>
            
                    <?php 
//                     echo $this->Js->link(__d('cms', 'x'), 
//                                     array('plugin' => 'tree', 'controller'=>'tree', 'action'=>'delete', $modelAlias, $value[$modelAlias]['id'],1, 'admin'=>false, 'user' => false, $treeMode), 
//                                     array_merge($optionsFull, 
//                                             array('confirm'=>__d('cms', 'Usunąć pozycję, oraz wszystkie pozycje podrzędne?'),
//                                                   'title'=>'Usuń wszystkie pozycje'  
//                                                 )));
                                                 ?>
                    <?php //echo $this->Js->link('edit', 
                            //        array('controller'=>'categories', 'action'=>'edit_name', $value[$modelAlias]['id'], 'admin'=>false), 
                              //      $options); 
                            ?>
<!--                </div> -->
                <span><?php echo $value[$modelAlias]['name']; ?></span>
            </div>