<?php

/* @var $this View */
/* @var $this->Html-> HtmlHelper */
/* @var $js JavascriptHelper */
?>

<?php
echo empty($error) ? '' : '<div class="error-message">' . $error . '</div>';


//Nie ma zadnego pliku projektu
if(empty($readonly) AND empty($orderItem['OrderItemFile']) AND !empty($deny_adding_files)){
    echo '';
} elseif (empty($readonly) AND empty($orderItem['OrderItemFile'])) {
    echo '<div class="fileInfoCont">';
    echo $this->Html->tag('span', ' Brak pliku!', array('class' => 'noFile'));
    echo $this->element('Orders/add_file',compact('orderItem','fileStatus'));
    echo '</div>';
} else { 
//Edycja plików projektu
?>
<?php $fileStatus = !empty($fileStatus); ?>
<?php if(empty($readonly)){ ?>
    <div class="fileInfoCont" id="fileInfoCont<?php echo $orderItem['id']; ?>" style="display:none;">
    <table>
        <tr>
            <th>Nazwa pliku</th>
            <th class="descInfoOptions">Opcje</th>
            <?php echo  empty($fileStatus)?'':'<th>Uwagi</th>'; ?> 
        </tr>
        
     <?php 
     $notAccepted = $accepted = 0;
     foreach ($orderItem['OrderItemFile'] as $key => $orderItemFile) { ?>
        <tr class="descInfo<?php echo $key%2==0?' altrow':''; ?>" id="ItemFileDesc_<?php echo $orderItemFile['id']; ?>">
            <td><?php echo $this->Html->link($orderItemFile['name'], '/files/orderitemfile/' . $orderItemFile['name']); ?></td>
            <td class="descInfoOptions">
            
            <?php echo $this->Html->link('Podgląd', '/files/orderitemfile/' . $orderItemFile['name'], array('class' => 'viewFile', 'target' => '_blank')); ?>

            <?php 
                if ($orderItemFile['accepted'] != 1) { ?>
                    <?php
                    echo $this->Form->create('OrderItem', array('type' => 'file', 
                        'onsubmit' => "return AIM.submit(this, {'onStart' : startCallbackUpdate, 'onComplete' : completeCallbackUpdate})", 
                        'class' => 'sendFileForm', 'id' => 'uploadForm_' . $orderItem['id'].'_'.$orderItemFile['id'], 
                        'url' => array('controller' => 'order_items', 'action' => 'upload_file', 'plugin' => 'commerce',$fileStatus)));
                    
                    echo $this->Form->hidden('OrderItem.id', array('value' => $orderItem['id']));
                    echo $this->Form->hidden('OrderItemFile.id', array('value' => $orderItemFile['id']));
                    
                    echo $this->Form->input('OrderItemFile.name', 
                            array(
                                'onchange' => "jQuery('#uploadForm_" . $orderItem['id'].'_'.$orderItemFile['id'] . "').submit();", 
                                'id' => 'inputfile_' . $orderItemFile['id'], 
                                'type' => 'file', 
                                'value' => '', 
                                'size' => '1', 
                                'class' => 'inputfile', 
                                'label' => false, 
                                //'div' => array('class' => 'input file')
                                ));
                    
                    echo $this->Form->submit('Zmień', array('class' => 'editFile', 'escape' => false, 'div' => false));
                    
                    echo $this->Form->end(); ?>
                    
                    <?php 
                            echo $js->link($this->Html->tag('span', 'Usuń', array('class' => 'deleteFile')), 
                            array('controller' => 'order_items', 'action' => 'delete_file', $orderItem['id'], $orderItemFile['id']), 
                            array('update' => '#projektTd_' . $orderItem['id'], 'escape' => false, 'confirm' => __('Na pewno chcesz usunąć ten plik?'),'complete'=>" jQuery('.ui-icon-closethick').click()")); ?>  
                    
                <?php } ?>
            </td>
            <?php if(!empty($fileStatus)){ ?>
            <td>
                <?php if ($orderItemFile['accepted'] == 2) { //Plik nie zaakceptowany?>
                <div class="notAcceptedFile">
                    <?php
                    ++$notAccepted;
                     echo $this->Html->image('problem.png'); ?>
                    <span>Brak Akceptacji pliku</span> 
                </div>
                <?php } elseif ($orderItemFile['accepted'] == 1) { //Plik Zakceptowany ?>
                <div class="acceptedFile">
                    <?php ++$accepted;
                     echo $this->Html->image('true.png'); ?>
                    <span>Plik Zaakceptowany</span>
                 </div>   
                <?php } elseif ($orderItemFile['accepted'] == 0) { //Jeszcze nie widziany przez admina ?>
                    <span>W trakcie akceptacji</span>
                <?php } ?>

        
                <?php echo $orderItemFile['desc']?'<span class="commentFile">'.$orderItemFile['desc'].'</span>':''; ?>
        </td>
        <?php } ?>
        

        </tr>
    <?php } ?>
    </table>
    </div>
<?php } ?>
    <div class="summaryTextFile" <?php echo count($orderItem['OrderItemFile'])?'':'style="color:red"'; ?>>
        wysłano <?php echo count($orderItem['OrderItemFile']).' '.__n('plik','plików',count($orderItem['OrderItemFile'])); ?> <br />
        <?php 
        if(!empty($fileStatus)){
            echo $notAccepted?'nie zaakceptowano '.$notAccepted.' '.__n('pliku','plików',$notAccepted).'<br />':'';
            echo $accepted?'zaakceptowano '.$accepted.' '.__n('plik','plików',$accepted).'<br />':''; 
        }  
        ?>
<?php if(empty($readonly)){ ?>
        <?php 
        $dialogOption = '{dialogClass:"orders",
                          width:"600px",
                          draggable:false,
                          modal: true,
                          resizable: false
                          }';
        echo $this->Html->link('Szczegóły', '#', array('class' => 'viewFile','onclick'=>'jQuery("#fileInfoCont'.$orderItem['id'].'").dialog('.$dialogOption.'); return false;')); ?>
        <?php if(empty($deny_adding_files)){ ?>
            <?php echo $this->element('Orders/add_file',compact('orderItem','fileStatus')); ?>
        <?php } ?>
<?php } ?>
    </div>
    <?php }
    ?>
<script type="text/javascript">
	jQuery('#projekt_'+<?php echo $orderItem['id'] ?>).parents('td').attr('id','projektTd_'+<?php echo $orderItem['id'] ?>);
</script>
<?php echo $this->Js->writeBuffer(); ?>
