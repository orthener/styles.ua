        <div class="child clearfix">
                <div class="action">
                <?php 
                    $optionsFull = array('update'=>'#tree', 'class'=>'button', 'before'=>'blockAll();', 'complete'=>'unblockAll();');  
                 ?>
            
                    <?php
                    echo ' <div class="button">';
                           echo $this->element('flag', 
                                    array('url' => 
                                        array('admin'=>true, 
                                            'plugin' => false, 
                                            'controller'=>'categories', 
                                            'action'=>'edit', 
                                            $value[$modelAlias]['id']), 
                                            'active' => $value['translateDisplay'], 
                                            'title'=>__d('cms','Edytuj'),
                                        )
                                    );
                      echo '</div> ';                   
//array_merge($optionsFull, array('confirm'=>__d('cms', 'Usunąć pozycję, oraz wszystkie pozycje podrzędne?'), 'title'=>'Usuń wszystkie pozycje'))    

                        echo ' <div class="button dodelete">';
                                if(count($value['translateDisplay'])>1){
                                  echo $this->element('flag', 
                                        array('url' => 
                                            array('plugin' => 'tree', 
                                                    'controller'=>'tree', 
                                                    'action'=>'delete', 
                                                    $modelAlias, 
                                                    $value[$modelAlias]['id'], 
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
                                            'plugin' => 'tree', 
                                            'controller'=>'tree',
                                            $modelAlias, 
                                            $value[$modelAlias]['id'], 
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
                    <?php echo $value[$modelAlias]['name']; ?>
                    <?php //debug($value); 
                    $params = array('target'=>'_blank');
                    $falseLink = false;
                    switch ($value[$modelAlias]['option']) {
                    case 0:
                        $value[$modelAlias]['link'] = '';
                        break;
                    case 1:
                        $value[$modelAlias]['link'] = $value[$modelAlias]['url']?$value[$modelAlias]['url']:'';
                        break;
                    case 2:
                        //Inflector::pluralize($value[$modelAlias]['model'])
                        $value[$modelAlias]['link'] = '';
                        
                        if($value[$modelAlias]['model'] == 'Page'){
                            $value[$modelAlias]['link'] = array('plugin'=>false,'user'=>false,'admin'=>false,'controller'=>'pages','action'=>'strona',$value[$modelAlias]['slug']);
                        }
                        
                        if(!$value[$modelAlias]['slug']) $falseLink  = true;
                        
                        break;
                    default:
                        $value[$modelAlias]['link'] = '';
                }
                
                
                if(empty($value[$modelAlias]['link'])){
                   // $value[$modelAlias]['link'] = '#';
                   // $params['onclick'] = 'return false;';
                  //  $params['style'] = 'cursor:default;';
                }else{
                    echo $falseLink?'':$html->link('[»»]', $value[$modelAlias]['link'], $params);
                }
                
                 
                
                ?>
                </span>
            </div>