<?php
$photoImage = $this->Image->thumb('/files/photo/' . $photo['Photo']['img'], array('width' => 200, 'height' => 200, 'crop' => true), array('class' => 'uploadedImage'));
$this->Html->div('photoBox', $photoImage);
//debug($photo);
$isParentPhotoOption = false;
if (isSet($photo[$model]['photo_id']) || empty($photo[$model]['photo_id'])) {
    //Jest zdjęcie główne
    $isParentPhotoOption = true;
}
?>

<div data-id="<?php echo $photo['Photo']['id']; ?>" class="photoBox <?php echo ($isParentPhotoOption && !empty($photo[$model]['photo_id']) && $photo[$model]['photo_id']==$photo['Photo']['id'])?'isParentPhoto':''?>" id="PhotoBox-<?php echo $photo['Photo']['id']; ?>">
    <?php echo $photoImage; ?>
    <ul class="imageTollbar">
        <?php echo (isSet($isParentPhotoOption))?$this->Permissions->link($this->Html->image('/photo/img/parent.png', array('title' => __d('cms', 'Ustaw jako główne'))), array('action' => 'set_parent'), array('class' => 'setParent', 'outter' => '<li>%s</li>', 'escape' => false)):''; ?>
        <?php echo $this->Permissions->link($this->Html->image('/photo/img/txt.png', array('title' => __d('cms', 'Ustaw opis zdjęcia'))), array('action' => 'get_title', $photo['Photo']['id']), array('class' => 'get_title', 'outter' => '<li>%s</li>', 'escape' => false)); ?>
<!--        <li><?php echo $this->Html->link(__d('cms', 'K'), '#', array('class' => 'cropPhoto')); ?></li>-->
        <?php echo $this->Permissions->link($this->Html->image('/photo/img/del.png', array('title' => __d('cms', 'Usuń zdjęcie'))), array('action' => 'delete'), array('class' => 'deletePhoto', 'outter' => '<li>%s</li>', 'escape' => false)); ?>
    </ul>
    <span class="imageTitle"><?php 
        $title = !empty($photo['Photo']['title'])?$this->Text->truncate($photo['Photo']['title'], '50'):'<i>'.  __d('cms', 'Brak opisu').'</i>';
        echo $this->Permissions->link($title, array('action' => 'get_title', $photo['Photo']['id']), array('class' => 'get_title', 'escape' => false, 'alt' => __d('cms', 'Ustaw opis zdjęcia'))); 
    ?></span>
</div>

<script type="text/javascript">
    $(function(){
        $('#PhotoBox-<?php echo $photo['Photo']['id']; ?>').find('.deletePhoto').click(function(event){
            if (confirm('<?php echo __d('cms', 'Jesteś pewny usunięcia zdjęcia?'); ?>')) {
                deletePhoto({id: '<?php echo $photo['Photo']['id'] ?>'});
            }
            event.preventDefault(); 
        });
        $('#PhotoBox-<?php echo $photo['Photo']['id']; ?>').find('.setParent').click(function(event) {
            setParent({id: '<?php echo $photo['Photo']['id'] ?>'});
            event.preventDefault(); 
        });
        
        initQtip($('#PhotoBox-<?php echo $photo['Photo']['id']; ?>').find('.get_title'));
        
        $('#PhotoBox-<?php echo $photo['Photo']['id']; ?>').find('.get_title').click(function(event) { 
            event.preventDefault(); 
        });
        
    });
</script>

