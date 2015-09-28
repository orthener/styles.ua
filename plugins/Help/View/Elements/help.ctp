<?php
    $urlHelp = array('controller' => 'helps', 'action' => 'view', 'plugin' => 'help', 'admin' => 'admin');
?>

<?php echo $this->Html->link($this->Html->image('/help/img/help.png'), $urlHelp, array('escape' => false, 'id' => "OpenHelpWindow", 'target' => '_blank')); ?>

<script type="text/javascript">
    openHelpWindow = function() {
        window.open('<?php echo $this->Html->url($urlHelp); ?>', 'Regulamin', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=640,height=530').focus(); 
        return false
    };
    $('#OpenHelpWindow').click(openHelpWindow);
</script>