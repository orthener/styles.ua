<?php
echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
?>

<?php echo $this->Form->input('option', array('default' => 0, 'legend' => __d('cms', 'Opcje'), 'type' => 'radio', 'options' => $urlOptions, 'separator' => '<br />')); ?>
<?php echo $this->Form->input('blink', array('label'=>  __d('cms', 'Migająca pozycja'), 'type'=>'checkbox')); ?>
<?php echo $this->Form->input('mode', array('label'=>  __d('cms', 'Sekcja'), 'type'=>'select', 'options'=>Menu::$modes, 'default'=>(isset($treeMode)? $treeMode : ''))); ?>
<div class="url-section">
    <?php echo $this->Form->input('url', array('label' => __d('cms', 'Adres url'))); ?>
</div>
<div class="model-section">
    <div class="input text">
        <label for="model_title">Powiązana podstrona</label>
        <?php echo $this->Form->text('model_title', array('id' => "model_title", 'class' => 'readonly disabled', 'readonly' => true)); ?>
        <?php echo $this->element('tabs'); ?>
    </div>
    <?php echo $this->Form->hidden('model'); ?>
    <?php echo $this->Form->hidden('row_id'); ?>
</div>


<div style="display:none">
    <?php
    echo $this->Form->input('lock');
    ?>
</div>

<?php echo $this->Html->script('/menu/js/admin_menu'); ?>