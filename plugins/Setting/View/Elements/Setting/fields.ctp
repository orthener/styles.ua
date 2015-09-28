<ul>
    <li><a href="#setting-basic"><span><?php echo __d('cms', 'Ogólne'); ?></span></a></li>
    <li><a href="#setting-misc"><span><?php echo __d('cms', 'Zaawansowane'); ?></span></a></li>
</ul>
<div id="setting-basic">
    <?php
    echo $this->Form->input('key', array('rel' => __d('cms', "np. Tytuł strony")));
    echo $this->Form->input('value');
    ?>
</div>

<div id="setting-misc">
    <?php
    echo $this->Form->input('title');
    echo $this->Form->input('description');
    echo $this->Form->input('input_type', array('rel' => __d('cms', "e.g., takie jak w inpucie + tinymce")));
    echo $this->Form->input('editable');
    echo $this->Form->input('params');
    ?>
</div>

<script type="text/javascript">
    $(function(){
        $('.tabs').tabs();
    });
</script>