<fieldset>
    <legend><?php echo __d('cms', 'News Data'); ?></legend>
    <?php
    //$opt = array(0 => 'Aktualność', 1 => 'Blog');
    //echo $this->Form->input('blog', array('label' => false, 'options' => $opt, 'type' => 'radio', 'default' => 0, 'legend' => false, 'separator' => '     '));
    echo $this->Form->hidden('blog', array('value' => 1));
    echo $this->Form->input('title', array('label' => __d('cms', 'Title')));
    //echo $this->Form->input('user_id', array('label' => __d('cms', 'User Id')));
    echo $this->Form->input('news_category_id', array('options' => $news_categories, 'label' => __d('cms', 'Kategoria wpisu')));
    echo $this->Form->input('date', array('type' => 'text', 'label' => __d('cms', 'Data wydarzenia')));
    echo $this->Form->input('main', array('label' => __d('cms', 'Main')));
    echo $this->Form->input('is_published', array('label' => __d('cms', 'Czy opublikować')));
    ?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Opis skrócony'); ?></legend>
    <?php //echo $this->FebTinyMce->input('tiny_content', array('label' => false), 'full'); ?>
    <?php echo $this->FebTinyMce4->input('tiny_content', array('label' => false), 'full', array('width' => 718));?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Content'); ?></legend>
    <?php //echo $this->FebTinyMce->input('content', array('label' => false), 'full'); ?>
    <?php echo $this->FebTinyMce4->input('content', array('label' => false), 'full', array('width' => 718));?>
</fieldset>

<fieldset>
    <legend><?php echo __d('cms', 'Kody reklam zewnętrznego reklamodawcy');?></legend>
    <?php echo $this->Form->input('ad_code', array('label' => __d('cms', 'Reklama nr 1'), 'type' => 'textarea'));?>
    <?php echo $this->Form->input('ad_code2', array('label' => __d('cms', 'Reklama nr 2'), 'type' => 'textarea'));?>
    <?php echo $this->Form->input('head_code', array('label' => __d('cms', 'Kod w sekcji head'), 'type' => 'textarea'));?>
</fieldset>


<fieldset>
    <legend><?php echo __d('cms', 'Ustawienia html');?></legend>
    <?php echo $this->Form->input('metakey', array('label' => __d('cms', 'Słowa kluczowe'), 'type' => 'textarea'));?>
    <?php echo $this->Form->input('metadesc', array('label' => __d('cms', 'Opis strony'), 'type' => 'textarea'));?>
</fieldset>







<script type="text/javascript">
    $(function() {
//        $('#NewsDate').datepicker({
//            dateFormat: 'yy-mm-dd'//'dd.mm.yy',
//        });
        
        $('#NewsDate').datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat:  "HH:mm"
        });
    });
</script>
