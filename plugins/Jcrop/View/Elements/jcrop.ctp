<?php 
$name = $data['name'];
$x = empty($data['x'])?0:$data['x'];
$y = empty($data['y'])?0:$data['y'];

$path ='/files/'.strtolower($model).'/'.$name;
$info = @getimagesize(WWW_ROOT.$path);

//$size = min((int)$info[0],(int)$info[1]);

$rx = 500 / $info[0];
$ry = 500 / $info[1];
$ratio = min($rx,$ry);
(int)$width = round($ratio * $info[0]);
(int)$height = round($ratio * $info[1]);
$size = min($width, $height);
//zabezpieczenie przed przekroczeniem zakresu
$x = round($ratio * $x);
$y = round($ratio * $y);
if($x > ($width - $size) or $y > ($height-$size) ){
    $x = 0;
    $y = 0;
}

$setSelect = array($x,$y,$size+$x,$size+$y);
?>

<div class="jcrop clearfix">
    <div class="actionJcrop">
        <div class="thumbJcrop">
            <?php echo $this->Html->image($path, array('id'=>'preview')); ?>
        </div>
        <?php
        echo $this->Form->create('Jcrop', array('id'=>'JcropForm'));
        echo $this->Form->input('x', array('id'=>'JcropX', 'name'=>'data[x]','value'=>round($x/$ratio),'readonly'));
        echo $this->Form->input('y', array('id'=>'JcropY', 'name'=>'data[y]','value'=>round($y/$ratio),'readonly'));
        echo $this->Js->submit('zapisz', 
                    array(
                        'update'=>'#JcropForm',
                        'url'=>array('controller'=>'jcrops','action'=>'update','plugin'=>'jcrop','admin'=>false, $model, $id),
                        'complete'=>'jQuery("#editCrop").dialog("destroy")'
                        )
                    );
        echo $this->Form->end();
         ?>
        
    </div>
    <div class="contentJcrop">
        <?php $styleImg = $this->Html->style(array('width'=>$width.'px !important','height'=>$height.'px !important')); ?>
        <?php echo $this->Html->image($path, array('class'=>'jcrop', 'style'=>$styleImg)); ?>
    </div>
</div>

<script type="text/javascript">

    jQuery('.jcrop').Jcrop({
        setSelect: <?php echo $test= json_encode($setSelect) ?>,
        aspectRatio: 1,
        allowSelect: false,
        allowResize: false,
        onSelect: updateFeields,
        disable: true,
        onChange: showPreview,
        bgOpacity: .7
        
    });
    
    function updateFeields(coords){
        ratio = <?php echo $ratio; ?>;
        jQuery('#JcropX').attr('value', Math.round(coords.x/ratio));
        jQuery('#JcropY').attr('value', Math.round(coords.y/ratio));
    }
    function updateAjax(coords){
      // variables can be accessed here as
      // coords.x, coords.y, coords.x2, coords.y2, coords.w, coords.h
      $.ajax({
          type: 'POST',
          url: "<?php echo $this->Html->url(array('controller'=>'jcrops','action'=>'update','plugin'=>'jcrop','admin'=>false, $model, $id),true); ?>",
          data: ({
                'data[x]':Math.round(coords.x/ratio),
                'data[y]':Math.round(coords.y/ratio)
                }),
          //success: success,
          dataType: 'json'
        });
    };
    
    function showPreview(coords){
    	var rx = 100 / coords.w;
    	var ry = 100 / coords.h;
    
    	$('#preview').css({
    		width: Math.round(rx * <?php echo $width ?>) + 'px',
    		height: Math.round(ry * <?php echo $height ?>) + 'px',
    		marginLeft: '-' + Math.round(rx * coords.x) + 'px',
    		marginTop: '-' + Math.round(ry * coords.y) + 'px'
    	});
    }; 
    
</script>
<?php echo $this->Js->writeBuffer(); ?>