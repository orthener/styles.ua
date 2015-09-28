<?php
$this->set('title_for_layout', 'Nasze Marki');
$this->Html->addCrumb('Wiarygodność', $this->here);
echo $this->element('default/crumb');
?>
<div class="row">
    <div class="span3">
        <div class="redTop">Nasze Marki</div>
        <div class="navLink">
            <?php foreach ($brands as $brand) { ?>
                <?php echo $this->Html->link($brand['Brand']['name'], array('action' => 'view', $brand['Brand']['slug']), array('escape' => false)); ?>
            <?php } ?>
        </div>
    </div>
    <div class="span9">
        <div class="contentPage">
            
        </div>
    </div> 
</div>
