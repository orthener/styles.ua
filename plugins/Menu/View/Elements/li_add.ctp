<li class="firstLiTree" id="">
    <?php echo $this->Form->create('Menu', array('id' => 'treeElementAdd')); ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Dodaj nową pozycję menu'); ?></legend>
        <?php
        $afterInput = $this->Js->submit('Dodaj', array(
            'url' => array('admin' => true, 'plugin' => 'menu', 'controller' => 'menus', 'action' => 'add'),
            'update' => '#tree',
            'div' => false,
            'class' => 'TreeSubmit',
            'before' => 'blockAll();',
            'complete' => 'unblockAll();'
                ));
        ?>
        <?php echo $this->element('fields'); ?>


        <?php echo $afterInput; ?>

    </fieldset>
    <?php echo $this->Js->writeBuffer();
    echo $this->Form->end();
    ?>
    <p class="ui-hidden">Przeciągnij poniższy element w wybrane miejsce w drzewie lub kliknij przycisk dodaj aby umieścić na końcu drzewa.</p>
    <div class="child ui-hidden clearfix"  id="ui-draggable">
        <div class="action">
<?php echo $this->Html->link('Anuluj', '#', array('onclick' => 'anulujValue();', 'class' => 'button')); ?>
        </div>
        <span></span> 
    </div>

</li>
<?php echo $this->Html->link(__d('cms', 'Dodaj nową pozycję'), '#', array('onclick' => 'dodajNowaPozycje();return false;', 'id' => 'dodajNowaPozycje', 'class' => 'button')); ?>

<script type="text/javascript">
    updateDragBox();
</script>