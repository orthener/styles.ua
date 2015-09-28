
<?php if (!empty($this->data['Baner']['image'])) { ?>
    <fieldset>
        <legend><?php echo __d('cms', 'Baner'); ?></legend>

        <?php echo $this->Html->image('/files/baner/' . $this->data['Baner']['image']); ?>

    </fieldset>
<?php } ?>
<fieldset>
    <legend><?php echo $desc ?></legend>


    <?php
    echo $this->Form->input('name', array('label' => __d('cms', 'Nazwa banera')));
    echo $this->Form->input('url', array('label' => __d('cms', 'URL strony')));
    echo $this->Form->input('title', array('label' => __d('cms', 'Tytuł')));
    ?>

    <?php
    $typeOption = array('HTML', 'Obrazek', 'TinyMCE');
    echo $this->Form->input('banerType', array('legend' => 'Typ Baneru', 'separator' => '<br /><br />', 'options' => $typeOption, 'type' => 'radio', 'style' => 'float: left;', 'id' => 'baner-toggle-type'));
    ?>
</fieldset>
<div id="baner-html">
    <fieldset>
        <legend><?php echo __d('cms', 'Baner HTML'); ?></legend>
        <?php echo $this->Form->input('html_code', array('label' => __d('cms', 'Kod HTML'))); ?>
        <div id="baner-html-desc">Aby system poprawnie zliczał kliknięcia należy umieścić click taga: poradnik tutaj >> <?php echo $this->Html->link('TU', array('#')); ?> <<</div>
    </fieldset>
</div>
<div id="baner-image">
    <fieldset>
        <legend><?php echo __d('cms', 'Baner Obrazek'); ?></legend>
        <?php echo $this->FebForm->input('Baner.image', array('label' => __d('cms', 'Wybierz grafikę'), 'type' => 'file')); ?>
    </fieldset>
</div> 
<div id="baner-tinymce">
    <fieldset class="textareaFull">
        <?php echo $this->FebTinyMce->input('tiny', array('label' => __d('cms', 'Treść'), 'id' => 'test'), 'full', array('width' => 1000)); ?>
    </fieldset>
</div>
<div id="baner-publish">
    <fieldset>
        <legend><?php echo __d('cms', 'Publikacja'); ?></legend>
        <?php echo $this->Form->input('published', array('type' => 'checkbox', 'label' => __d('cms', 'Publikować?'))); ?>
        <?php echo $this->Form->input('group', array('label' => __d('cms', 'Położenie'), 'options' => $groupTypes)); ?>
        <?php echo $this->Form->input('publish_date', array('type' => 'text', 'label' => __d('cms', 'Data publikacji'), 'timeFormat' => 24, 'dateFormat' => 'DMY')); ?>
    </fieldset>
</div>
<div id="baner-limits">
    <fieldset>
        <legend><?php echo __d('cms', 'Limity wyświetleń'); ?></legend>
        <div id="BanerClicksLimitDiv">
            <?php echo $this->Form->input('clicks_limit', array('label' => __d('cms', 'Limit kliknięć'))); ?>
        </div>
        <?php echo $this->Form->input('clicks_limit_off', array('label' => __d('cms', 'Bez limitu'), 'type' => 'checkbox', 'default' => true)); ?>
        <div id="BanerShowsLimitDiv">
            <?php echo $this->Form->input('shows_limit', array('label' => __d('cms', 'Limit wyświetleń'))); ?>
        </div>
        <?php
        echo $this->Form->input('shows_limit_off', array('label' => __d('cms', 'Bez limitu'), 'type' => 'checkbox', 'checked' => true));

        echo $this->Form->input('date_limit', array('type' => 'text', 'label' => __d('cms', 'Data wygaśnięcia'), 'timeFormat' => 24, 'dateFormat' => 'DMY', 'div' => 'MyDateLimit input text'));

        //echo $this->Form->input('date_limit_off', array('label' => __d('cms', 'Bez limitu'), 'type' => 'checkbox', 'default' => true));
        ?>
    </fieldset>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#baner-image').hide();
        $('#baner-tinymce').hide();
        $('#baner-html').hide(); 
    });
    $(function(){

        //Kod HTML
        $('#Baner-toggle-type0').click(function(){
            $('#baner-image').hide();
            $('#baner-tinymce').hide();
            $('#baner-html').show();
        });
        //Obrazek
        $('#Baner-toggle-type1').click(function(){
            $('#baner-image').show();
            $('#baner-html').hide();
            $('#baner-tinymce').hide();
        });
        $('#Baner-toggle-type2').click(function(){
            $('#baner-tinymce').show();
            $('#baner-image').hide();
            $('#baner-html').hide();
        });

        //toggle limitu kliknięć
        $('#BanerClicksLimitOff').click(function(){
            if ($(this).attr('checked')) {
                $('#BanerClicksLimit').attr('disabled', 'disabled');
            } else {
                $('#BanerClicksLimit').removeAttr('disabled');
            }
            return true;
        });

        //toggle limitu wyświetleń
        $('#BanerShowsLimitOff').click(function(){
            if ($(this).attr('checked')) {
                $('#BanerShowsLimit').attr('disabled', 'disabled');
            } else {
                $('#BanerShowsLimit').removeAttr('disabled');
            }
            return true;
        });

        //toggle limitu daty
        $('#BanerDateLimitOff').click(function(){
            if ($(this).attr('checked')) {
                $('.MyDateLimit select').attr('disabled', 'disabled');
            } else {
                $('.MyDateLimit select').removeAttr('disabled');
            }
            return true;
        });
        
        //Odkliknięcia - odblokowania limitów
        
        $('#BanerClicksLimitDiv').click(function(){
            if ($('#BanerClicksLimit').attr('disabled')) {
                $('#BanerClicksLimitOff').removeAttr('checked');
                $('#BanerClicksLimit').removeAttr('disabled');
            } 
            return true;
        });
        $('#BanerShowsLimitDiv').click(function(){
            if ($('#BanerShowsLimit').attr('disabled')) {
                $('#BanerShowsLimitOff').removeAttr('checked');
                $('#BanerShowsLimit').removeAttr('disabled');
            }
            return true;
        });        
        
        //Init

        $('#BanerClicksLimit').attr('disabled', 'disabled');
        $('#BanerShowsLimit').attr('disabled', 'disabled');
        $('.MyDateLimit select').attr('disabled', 'disabled');
                
<?php if (!empty($this->data['Baner']['html_code'])) { ?>
            $('#Baner-toggle-type0').click();
<?php } ?>

<?php if (!empty($this->data['Baner']['image'])) { ?>
            $('#Baner-toggle-type1').click();
<?php } ?>
<?php if (!empty($this->data['Baner']['tiny'])) { ?>
            $('#Baner-toggle-type2').click();
<?php } ?>
    });
    jQuery('#BanerPublishDate').datepicker();
    jQuery('#BanerDateLimit').datepicker();
</script>

