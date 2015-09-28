        <div class="child clearfix">
                <div class="action">
                <?php 
                    $optionsFull = array('update'=>'#tree', 'class'=>'button', 'before'=>'blockAll();', 'complete'=>'unblockAll();');  
                 ?>
            
                    <?php
                    echo ' <div class="button">';
                           echo $this->element('Translate.flags/flags', 
                                    array('url' => 
                                        array('admin'=>true, 
                                            'controller'=>'menus', 
                                            'action'=>'edit', 
                                            $value['Menu']['id']), 
                                            'active' => $value['translateDisplay'], 
                                            'title'=>__d('cms','Edytuj'),
                                        )
                                    );
                      echo '</div> ';                   
//array_merge($optionsFull, array('confirm'=>__d('cms', 'Usunąć pozycję, oraz wszystkie pozycje podrzędne?'), 'title'=>'Usuń wszystkie pozycje'))    

                        echo ' <div class="button dodelete">';
                                if(count($value['translateDisplay'])>1){
                                  echo $this->element('Translate.flags/flags', 
                                        array('url' => 
                                            array('plugin' => 'menu', 
                                                    'controller'=>'menus', 
                                                    'action'=>'delete',
                                                    $value['Menu']['id'], 
                                                    0, 
                                                    'admin'=>false, 
                                                    'user' => false,
                                                ),
                                            'active' => $value['translateDisplay'], 
                                            'title'=> __d('cms','Usuń'),
                                            'addit' => array(
                                                    'confirm'=>__d('cms', 'Usunąć pozycję dla tego języka, oraz wszystkie pozycje podrzędne?')
                                                )
                                            )
                                        );
                                  }
                                 echo $this->Html->link($this->Html->image('flag/trash.png', array('alt' => __d('cms', 'Usuń Wszystkie'), 'title' => __d('cms', 'Usuń Wszystkie'))),
                                         array(
                                            'action' => 'delete', 
                                            'plugin' => 'menu', 
                                            'controller'=>'menus',
                                            $value['Menu']['id'], 
                                            1, 
                                            'admin'=>false, 
                                            'user' => false),
                                            array(
                                            'confirm'=>__d('cms', 'Usunąć pozycję dla tego języka, oraz wszystkie pozycje podrzędne?'),
                                                'escape' => false
                                            ));

//echo $this->Js->link('', array('plugin' => 'tree', 'controller'=>'tree', 'action'=>'delete', $modelAlias, $value[$modelAlias]['id'],1, 'admin'=>false, 'user' => false), );
                        echo '</div> ';
                                                
//                 if(empty($value[$modelAlias]['model'])){
//                     echo $this->Html->link(__d('cms', 'Edycja'), array('admin'=>true, 'plugin' => false, 'controller'=>'categories', 'action'=>'edit', $value[$modelAlias]['id'], 'user' => false), array('class'=>'button')); 
// 
// 
// 
// 
//                 } else {
//                     echo $this->Html->link(__d('cms', 'Edycja artykułu'), array('admin'=>true, 'plugin' => false, 'controller'=>'albums', 'action'=>'edit', $value[$modelAlias]['model_id'], 'user' => false), array('class'=>'button')); 
//                 }

                    ?>


                    <?php //echo $this->Js->link('edit', 
                            //        array('controller'=>'categories', 'action'=>'edit_name', $value[$modelAlias]['id'], 'admin'=>false), 
                              //      $options); 
                            ?>
                </div>
                <span>
                    <?php echo $value['Menu']['name']; ?>
                    <?php
                    $value['Link']['options']['target'] = '_blank';
                    echo ($value['Link']['url'] == '#')?'':$this->Html->link('[»»]', $value['Link']['url'], $value['Link']['options']);
 
                ?>
                </span>
            </div>