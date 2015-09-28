<?php $this->Html->script('admin_menu', array('inline'=>false)); ?>

<fieldset>
    <legend><?php __d('cms','Menu'); ?></legend>	
    <?php
    echo $this->Form->input('name');
//     if($this->Form->value('option') == '1'){
//         echo $this->Form->input('url');
//     } else {
//         echo $this->Form->hidden('url');
//     }
    ?>

        <?php 
        if($categoryModel = &ClassRegistry::getObject('category') === false){
            $categoryOptions = array();
        } else {
            $categoryOptions = $categoryModel->options;
        }
        
        echo $this->Form->input('Category.option', array('legend' => __d('cms', 'Opcje'), 'type' => 'radio', 'options' => $categoryOptions)); ?>

        <div class="url-section">
            <?php echo $this->Form->input('Category.url', array('label' => __d('cms', 'Adres url'))); ?>
        </div>
        <div class="model-section">
            <div class="input text">
                <label for="model_title">Powiązana podstrona</label>
                <?php echo $this->Form->text('Category.model_title', array('id' => "model_title", 'class' => 'readonly disabled', 'readonly' => true)); ?>
                <?php echo $this->element('tabs', array('plugin'=>'tree', 'model' => 'Category')); ?>
            </div>
            <?php echo $this->Form->hidden('Category.model'); ?>
            <?php echo $this->Form->hidden('Category.row_id'); ?>
        </div>





    <div style="display:none">
    <?php
    echo $this->Form->input('lock');
    ?>
    </div>
</fieldset>