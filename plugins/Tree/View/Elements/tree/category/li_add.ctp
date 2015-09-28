<?php $this->Html->script('admin_menu', array('inline'=>false)); ?>
        <li class="firstLiTree">
            <?php echo $this->Form->create('Tree', array('id'=>'treeElementAdd')); ?>
            <fieldset>
                <legend><?php echo __d('cms', 'Dodaj nową pozycję menu'); ?></legend>
        <?php $afterInput =  $this->Js->submit(__d('cms', 'Dodaj'), 
            array(
                'url'=>array('controller'=>'tree','action'=>'index',$modelAlias ,'plugin'=>'tree' ,'admin'=>false, 'user'=>false), 
                'update'=>'#tree', 
                'div'=>false, 
                'class'=>'TreeSubmit', 
                'before'=>'blockAll();',
                'complete'=>'unblockAll();'
            )); ?>
        <?php echo $this->Form->input('Tree.name', array('label' => __d('cms', 'Nazwa'),'onkeyup' => 'updateDragBox()')); ?>

                
        <?php 
        if($categoryModel = &ClassRegistry::getObject('category') === false){
            $categoryOptions = array();
        } else {
            $categoryOptions = $categoryModel->options;
        }
        
        echo $this->Form->input('Category.option', array('legend' => __d('cms', 'Opcje'), 'type' => 'radio', 'options' => $categoryOptions, 'value' => '0')); ?>

        <div class="url-section">
            <?php echo $this->Form->input('Category.url', array('label' => __d('cms', 'Adres url'))); ?>
        </div>
        <div class="model-section">
            <div class="input text">
                <label for="model_title">Powiązana podstrona</label>
                <input id="model_title" class="readonly disabled" readonly="readonly" />
                <?php echo $this->element('tabs', array('plugin'=>'tree', 'model' => 'Category')); ?>
            </div>
            <?php echo $this->Form->hidden('Category.model'); ?>
            <?php echo $this->Form->hidden('Category.row_id'); ?>
        </div>



        <?php //echo $this->Form->input('Category.page_id', array('label' => __d('cms', 'Adres url'))); ?>
            <?php echo $afterInput; ?>
                 
            </fieldset>
            <?php echo $this->Js->writeBuffer(); echo $this->Form->end(); ?>
            <p class="ui-hidden">Przeciągnij poniższy element w wybrane miejsce w drzewie lub kliknij przycisk dodaj aby umieścić na końcu drzewa.</p>
            <div class="child ui-hidden clearfix"  id="ui-draggable">
                <div class="action">
                    <?php echo $this->Html->link('Anuluj','#',array('onclick'=>'anulujValue();','class'=>'button')); ?>
                </div>
                <span></span> 
            </div>
            
        </li>
            <?php echo $this->Html->link('Dodaj nową pozycję','#',array('onclick'=>'dodajNowaPozycje();return false;','id'=>'dodajNowaPozycje', 'class'=>'button')); ?>


<?php 
$html->script('admin_menu', array('inline'=>false));
echo $this->Html->scriptBlock('treeOptionClick();');
 ?>