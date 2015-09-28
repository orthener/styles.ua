<?php

$this->Html->css('/photo/css/photo', null, array('inline' => false));

$deleteUrl = $this->Html->url(array('controller' => 'photos', 'action' => 'delete'));
$setParentUrl = $this->Html->url(array('controller' => 'photos', 'action' => 'set_parent'));
$this->Html->script('jquery.qtip', array('inline' => false));
$this->Html->css('jquery.qtip', null, array('inline' => false));
$ajaxLoaderImage = $this->Html->image('cms/ajax-loader.gif', array('alt' => __d('cms', 'Ładowanie...')));
$getBoxUrl = $this->Html->url(array('admin' => 'admin', 'controller' => 'photos', 'action' => 'view'));
$sortUrl = $this->Html->url(array('admin' => 'admin', 'controller' => 'photos', 'action' => 'sort'));


$progresBarId = 'ProgresBar-' . String::uuid();
$fileUploaderId = 'FileUploader-' . String::uuid();
$photoSpanId = 'FileUploader-' . String::uuid();

//Obsługa akcji z elementu photoBox

$functions = "
var activeSetTitleTip = {};
var activePhotoBox = {};

var galleryConfig = {
    ajaxLoaderImage: '{$ajaxLoaderImage}',
    remote_id: '{$remote_id}',
    model: '{$model}',
    targetModel: '{$targetModel}',
    plugin: '{$plugin}',
    getBoxUrl: '{$getBoxUrl}',
    photoSpanId: '{$photoSpanId}',
    sortUrl: '{$sortUrl}'
};

var deletePhoto = function(params){
        $.ajax({
            url: '{$deleteUrl}\/'+params.id,
            dataType: 'html',
            type: 'POST',
            data: {data: {
                    id: params.id,
                    targetModel: galleryConfig.targetModel,
                    model: galleryConfig.model,
                    plugin: galleryConfig.plugin,
                    remote_id: galleryConfig.remote_id
                }
            },
            success: function(data) {
                $('#PhotoBox-'+params.id).remove();
            }
        });
    };
    var setParent = function(params, callback){
        var tmp = this;
        $.ajax({
            url: '{$setParentUrl}',
            dataType: 'html',
            type: 'POST',
            data: {data: {
                    id: params.id,
                    targetModel: galleryConfig.targetModel,
                    model: galleryConfig.model,
                    plugin: galleryConfig.plugin,
                    remote_id: galleryConfig.remote_id
                }
            },
            success: function(data) {
                $('.photoBox').removeClass('isParentPhoto');    
                $('#PhotoBox-'+params.id).addClass('isParentPhoto');
                if (typeof(callback) == 'function') {
                    callback(data);
                }
            }
        });
    };
    var initQtip = function(element) {
        $(element).qtip({
            content: {
                text: galleryConfig.ajaxLoaderImage,
                ajax: {
                    url: $(element).attr('href'), // Use the rel attribute of each element for the url to load
                    success: function(data) {
                            activeSetTitleTip = this;
                            activePhotoBox = $(element).parents('div.photoBox');
                            this.set('content.text', data);
                    }   
                },
                title: {
                    text: '".__d('cms', 'Ustaw tytuł')."', // Give the tooltip a title using each elements text
                    button: true
                }
            },
            position: {
                at: 'top center', // Position the tooltip above the link
                my: 'top center',
                viewport: $(window), // Keep the tooltip on-screen at all times
                effect: false // Disable positioning animation
            },
            show: {
                event: 'click',
                solo: true // Only show one tooltip at a time
            },
            hide: 'unfocus',
            style: {
                classes: 'ui-tooltip-wiki ui-tooltip-light ui-tooltip-shadow'
            }
        });
    };";
?>

<?php echo $this->Html->scriptBlock($functions, array('inline' => false)); ?>

<div class="photos index">
    <h2><?php echo __d('cms', 'Galeria zdjęć: '); ?> <?php echo empty($objectName)?'':$objectName; ?><div id="photoHelp">?</div></h2>
    
    <div class="photoBoxes clearfix">
        <?php
        //generuje liste obrazków
        $toDisplayPhotos = '';
        foreach ($photos as $photo) {
            $toDisplayPhotos .= $this->element('/Photos/photoBox', array('photo' => $photo));
        }

        //opcje do obrazków
        $initParams = array();

        $progresBar = $this->Html->div('progressbar', '', array('id' => $progresBarId));
        $fileUploader = $this->Html->div('fileUploader', '', array('id' => $fileUploaderId));
        $photoSpan = $this->Html->tag('ul', $toDisplayPhotos, array('class' => 'photoSpan', 'id' => $photoSpanId));

        $initParams['progresBar'] = $progresBar;
        $initParams['fileUploader'] = $fileUploader;
        $initParams['photoSpan'] = $photoSpan;

        $initParams['progresBarId'] = $progresBarId;
        $initParams['fileUploaderId'] = $fileUploaderId;
        $initParams['photoSpanId'] = $photoSpanId;
        
        $callBacks['onComplete'] = "onComplete: function(id, fileName, responseJSON){
            if (responseJSON.success === true) {
                $.ajax({
                    url: '{$getBoxUrl}/'+responseJSON.id,
                    type: 'POST',
                    data: {data: {
                            id: responseJSON.id,
                            targetModel: galleryConfig.targetModel,
                            model: galleryConfig.model,
                            plugin: galleryConfig.plugin,
                            remote_id: galleryConfig.remote_id
                        }
                    },
                    success: function(data) {
                        $('#{$photoSpanId}').append(data);
                    }
                });
                $('#{$progresBarId}').progressbar('value', 100);
            } else {
                alert('Błąd');
            }               
           }";
        ?>
        <?php echo $this->FebForm->upload($model, $remote_id, $initParams, $callBacks); ?>        
    </div>
</div>

<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php 
        if($model != 'EntryCategory'){
            echo $this->Permissions->link(__d('cms', 'Edit '.Inflector::pluralize($model)), array('plugin' => !empty($plugin)?Inflector::underscore($plugin):false,'controller' => Inflector::tableize($model), 'action' => 'edit', $remote_id), array('outter' => '<li>%s</li>')); 
        } else {
            echo $this->Permissions->link(__d('cms', 'Edycja wpisów'), array('plugin' => false,'controller' => 'entries', 'action' => 'index', $objectSlug), array('outter' => '<li>%s</li>')); 
        }
        ?>
        
        <?php echo $this->Permissions->link(__d('cms', 'List '.Inflector::pluralize($model)), array('plugin' => !empty($plugin)?Inflector::underscore($plugin):false, 'controller' => Inflector::tableize($model), 'action' => 'index', $remote_id), array('outter' => '<li>%s</li>')); ?>
        <?php if($model == 'Product'):?>
            <?php echo $this->Permissions->link(__d('cms', 'New Product'), array('admin' => 'admin', 'plugin' => 'static_product', 'controller' => 'products', 'action' => 'add'), array('outter' => '<li>%s</li>')); ?>
        <?php endif;?>
    </ul>
</div>

<script type="text/javascript">
    $(function() {
        
        $( "#<?php echo $photoSpanId; ?>" ).sortable({
            stop: function(event, ui) {
                var reLocate = {}; 
                $( "#<?php echo $photoSpanId; ?>" ).find('div.photoBox').each(function(index, object) {
                    reLocate[index] = $(object).attr('data-id');
                }); 
                
                $.ajax({
                    url: galleryConfig.sortUrl,
                    dataType: 'html',
                    type: 'POST',
                    data: {
                        data: {
                            targetModel: galleryConfig.targetModel,
                            model: galleryConfig.model,
                            plugin: galleryConfig.plugin,
                            remote_id: galleryConfig.remote_id,
                            reLocate: reLocate
                        }
                    },
                    error: function(data) {
                        alert('<?php echo __d('cms', 'Wystąpił krytyczny bład, skontaktuj się z administratorem')?>');
                        location.reload();
                    }
                });
                
            }
        });

        $( "#<?php echo $photoSpanId; ?>" ).disableSelection();  
        
        $('#photoHelp').qtip({
            content: {
                text: "<ul><li>▪ możesz wrzucać kilka zdjęć na raz</li><li>▪ maksymalny rozmiar pliku 3MB</li><li>▪ dozwolone formaty zdjęć: .jpg .png .gif</li></ul>",
                title: {
                    text: 'Czy wiesz że:', // Give the tooltip a title using each elements text
                    button: false
                }
            },
            position: {
                at: 'top center', // Position the tooltip above the link
                my: 'top center',
                viewport: $(window), // Keep the tooltip on-screen at all times
                effect: false // Disable positioning animation
            },
            show: {
                event: 'click',
                solo: false // Only show one tooltip at a time
            },
            hide: 'unfocus',
            style: {
                classes: 'ui-tooltip-wiki ui-tooltip-light ui-tooltip-shadow'
            }
        }); 
    });
     
</script>