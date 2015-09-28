<fieldset>
    <legend><?php echo __d('cms', 'Studio Movie Data'); ?></legend>
    <?php
    echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
    echo $this->Form->input('author', array('label' => __d('cms', 'Author')));
    echo $this->Form->input('is_active', array('label' => __d('cms', 'Czy ma być aktywny')));
    echo $this->Form->input('media_type', array('legend' => __d('cms', 'Rodzaj utworu'), 'default' => '0', 'type' => 'radio', 'options' => $mediaTypes));
    ?>
    <?php if (!empty($this->request->data['StudioMovie']['media_type']) && $this->request->data['StudioMovie']['media_type'] == 1): ?>
        <div id="MediaType_File" style='display: block'>
            <?php echo $this->FebForm->file('file', array('type' => 'file', 'label' => __d('cms', 'File'))); ?>
        </div>
        <div id="MediaType_Youtube" style="display: none">
            <?php echo $this->Form->input('url', array('label' => __d('cms', 'Url'))); ?>
        </div>
    <?php else : ?>
        <div id="MediaType_File" style='display: none'>
            <?php echo $this->FebForm->file('file', array('type' => 'file', 'label' => __d('cms', 'File'))); ?>
        </div>
        <div id="MediaType_Youtube" style="display:block">
            <?php echo $this->Form->input('url', array('label' => __d('cms', 'Url'))); ?>
        </div>
    <?php endif; ?>
</fieldset>

<script>
    // Youtube
    $('#StudioMovieMediaType0').click(function() {
        $("#MediaType_Youtube").css('display', 'block');
        $("#MediaType_File").css('display', 'none');
    });
    // Pliki
    $('#StudioMovieMediaType1').click(function() {
        $("#MediaType_Youtube").css('display', 'none');
        $("#MediaType_File").css('display', 'block');
    });
</script>