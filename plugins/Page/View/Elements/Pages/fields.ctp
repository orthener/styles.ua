<?php //$html->css('colorpicker',null, array('inline'=>false));  ?>
<?php //$html->script('colorpicker', array('inline'=>false));  ?>
<fieldset>
    <legend><?php echo __d('cms', 'Strona'); ?></legend>
    <?php echo $this->Form->input('name', array('label' => __d('cms', 'Tytuł'))); ?>	
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Kategoria'); ?></legend>
    <?php echo $this->Form->input('category', array('legend' => __d('cms', 'Kategoria'), 'options' => Page::$categories, 'default' => '0', 'type' => 'radio')); ?>
    <?php //echo $this->Form->input('comments', array('label'=>'Komentarze')); ?>
</fieldset>


<fieldset class="textareaFull">
    <legend><?php echo __d('cms', 'Konfiguracja'); ?></legend>
    <?php echo $this->Form->input('gallery', array('label' => __d('cms', 'Galeria'))); ?>
    <?php //echo $this->Form->input('comments', array('label'=>'Komentarze')); ?>
    <?php echo $this->FebTinyMce4->input('desc', array('label' => false), 'full', array('width' => 718)); ?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Ustawienia HTML'); ?></legend>
    <div class="info">
        <?php echo __d('cms', 'Maksymalna ilość znaków 255'); ?>
    </div>
    <?php echo $this->Form->input('description', array('type' => 'textarea', 'class' => 'mceNoEditor')); ?>
    <?php echo $this->Form->input('keywords', array('type' => 'textarea', 'class' => 'mceNoEditor')); ?>
</fieldset>