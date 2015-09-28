        <li class="firstLiTree">
            <?php echo $this->Form->create('Tree', array('id'=>'treeElementAdd')); ?>
            <fieldset>
                <legend><?php echo __d('cms', 'Dodaj nową pozycję'); ?></legend>
                <?php $afterInput =  $this->Js->submit(__d('cms', 'Dodaj pozycję'), array('url'=>array('controller'=>'tree','action'=>'index',$modelAlias ,'MenuLeft','plugin'=>'tree' ,'admin'=>false, 'user'=>false), 'update'=>'#tree', 'div'=>false, 'class'=>'TreeSubmit', 'before'=>'blockAll();', 'complete'=>'unblockAll();')); ?>
           <?php 
           echo $this->Form->hidden('Category.url');
           echo $this->Form->input('Tree.name', array('label' => __d('cms', 'Nazwa'),'onkeyup' => 'updateDragBox()','after'=>$afterInput)); ?>
                 
            </fieldset>
            <?php echo $this->Js->writeBuffer();
 echo $this->Form->end(); ?>
            <p class="ui-hidden"><?php echo __d('cms', 'Przeciągnij poniższy element w wybrane miejsce w drzewie lub kliknij przycisk dodaj aby umieścić na końcu drzewa.'); ?></p>
            <div class="child ui-hidden clearfix"  id="ui-draggable">
                <div class="action">
                    <?php echo $this->Html->link(__d('cms', 'Anuluj'),'#',array('onclick'=>'anulujValue();','class'=>'button')); ?>
                </div>
                <span></span> 
            </div>
            
        </li>
            <?php echo $this->Html->link(__d('cms', 'Dodaj nową pozycję'),'#',array('onclick'=>'dodajNowaPozycje();return false;','id'=>'dodajNowaPozycje', 'class'=>'button')); ?>
