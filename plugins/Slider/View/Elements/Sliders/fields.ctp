<?php
    echo $this->Html->css('Slider.colorpicker', null, array('inline' => false));
    echo $this->Html->script('Slider.colorpicker', array('inline' => false));
?>

<fieldset>
    <legend><?php echo __d('cms', 'Slider Data'); ?></legend>
    <?php
    echo $this->Form->input('active', array('label' => __d('cms', 'Aktywny'), 'type' => 'checkbox', 'default' => 1));
    echo $this->Form->input('name', array('label' => __d('cms', 'Slider Name')));
    echo $this->Form->input('tiny_name', array('label' => __d('cms', 'Tiny Name')));
    echo $this->Form->input('content', array('type'=>'textarea','label' => __d('cms', 'Content')));
//    echo $this->Form->input('text_color', array('label' => __d('cms', 'Text Color'), 'type' => 'select', 'options' => Slider::$text_colors));
    ?>
    <div class="input text">
        <?php
        echo $this->Form->input('text_color', array('label' => __d('cms', 'Text Color'), 'id' => 'colorpicker', 'div' => false, 'default'=>'8b8b8c'));
        ?>
        <div class="colors" style="float: left;width: 30px; height: 30px; background-color: #<?php echo!empty($this->request->data['Slider']['text_color']) ? $this->request->data['Slider']['text_color'] : ''; ?>;"></div>
    </div>
    <?php
    echo $this->Form->input('button_text', array('label' => __d('cms', 'Button Text')));
    echo $this->Form->input('button_link', array('label' => __d('cms', 'Button Link')));
    echo $this->FebForm->file('img', array('type' => 'file', 'label' => __d('cms', 'Img')));
    ?>
</fieldset>

<script type="text/javascript">
    //<![CDATA[
    $('#colorpicker').ColorPicker({
        color: '#<?php echo !empty($this->request->data['Slider']['text_color']) ? $this->request->data['Slider']['text_color'] : '8b8b8c'; ?>',
        onShow: function(colpkr) {
            $(colpkr).fadeIn(500);
            $(colpkr).change();
//            $('.colors').css('backgroundColor', '#8b8b8c');
            return false;
        },
        onHide: function(colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function(hsb, hex, rgb) {
            var r = 255 - rgb.r;
            var g = 255 - rgb.g;
            var b = 255 - rgb.b;
            var color = r + "," + g + "," + b;
            $('#colorpicker').val(hex);
            $('.colors').css('backgroundColor', '#' + hex);
//            $('#colorpicker').css('backgroundColor', '#' + hex);
//            $('#colorpicker').css('color', "rgb(" + color + ")");
        }
    });
    //]]>
</script>