<div id="refresh-on-submit">
 
            <?php echo $this->Form->create('Tree', array('id'=>'treeElementAdd')); ?>
            <fieldset>
                <legend>Dodaj stronę do menu</legend>
        <?php $afterInput =  $this->Js->submit('Dodaj', 
            array(
                'url'=>array('controller'=>'tree','action'=>'index','Category' ,'MenuLeft','plugin'=>'tree' ,'admin'=>false, 'user'=>false), 
                'update'=>'#tree', 
                'div'=>false, 
                'class'=>'TreeSubmit', 
                'before'=>'blockAll();',
                'complete'=>'unblockAll();updateClasses();'
            )); ?>
        <?php echo $this->Form->input('Tree.name', array('label' => __d('cms', 'Nazwa'),'onkeyup' => 'updateDragBox()')); ?>

        <?php echo $this->Form->input('Category.model', array('type' => 'hidden', 'value' => 'Album')); ?>
        <?php echo $this->Form->input('Category.row_id', array('type' => 'hidden', 'value' => $this->Form->value('Album.id'))); ?>
        <?php echo $this->Form->input('Category.option', array('type' => 'hidden', 'value' => 2)); ?>
            <?php echo $afterInput; ?>
                 
            <p class="ui-hidden">Przeciągnij poniższy element w wybrane miejsce w drzewie lub kliknij przycisk dodaj aby umieścić na końcu drzewa.</p>
            <div class="child ui-hidden clearfix"  id="ui-draggable">
                <div class="action">
                    <?php echo $this->Html->link('Anuluj','#',array('onclick'=>'anulujValue();','class'=>'button')); ?>
                </div>
                <span></span> 
            </div>
            </fieldset>
            <?php echo $this->Js->writeBuffer(); echo $this->Form->end(); ?>
</div>