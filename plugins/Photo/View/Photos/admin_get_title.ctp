<?php 
$id = $this->Form->value('Photo.id');
echo $this->Form->create('Photo', array('id' => 'PhotoAdminGetTitleForm-'.$id)); ?>
<?php echo $this->Form->input('title', array('label' => false)); ?>
<?php echo $this->Form->end(__d('cms', 'Zapisz')); ?>
<script type="text/javascript">
    $('#PhotoAdminGetTitleForm-<?php echo $id; ?>').submit(function(event){
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function(data) {
                console.debug(data);
                activeSetTitleTip.set('content.text', galleryConfig.ajaxLoaderImage);
                $.ajax({
                    url: galleryConfig.getBoxUrl+'/<?php echo $id; ?>',
                    type: 'POST',
                    data: {
                        data: {
                            id: '<?php echo $id; ?>',
                            model: galleryConfig.model,
                            remote_id: galleryConfig.remote_id
                        }
                    },
                    success: function(data) {
                        activePhotoBox.replaceWith(data);
                        activeSetTitleTip.hide();
                    }
                });
            }
        });
        event.preventDefault();
        return false;
    });
</script>