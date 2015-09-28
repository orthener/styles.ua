<div class="comments clearfix">
    <?php 
    foreach($strona['Comment'] as $comment){
        if( $comment['active'] == 0) continue;
        echo $this->Html->div('commentName', $comment['name'].' ');
        echo $this->Html->div('commentDesc', $comment['desc']);
        echo '<br class="clear" />';
    } 
    ?>
</div>
<?php echo $this->Form->create('Page', array('id'=>'comment', 'url'=>$this->Html->url('/'.$this->params->url,true)));?>
	<fieldset>
 		<legend><?php echo  __d('front', 'Dodaj komentarz');?></legend>
	<?php
        echo $this->Form->input('Comment.name', array('label'=>'Autor'));
        echo '<br />';
		echo $this->Form->hidden('Comment.page_id', array('value'=>$strona['Page']['id']));
        echo $this->Form->input('Comment.desc', array('label'=>'Treść'));
        echo $this->Form->label('', __d('front', 'Przepisz dwa słowa z obrazka'), array('style'=> 'width: 400px'));
        echo $this->CaptchaTool->show('Comment'); 
	?>
	</fieldset>
<?php echo $this->Form->end(__d('front', 'Dodaj'));?>