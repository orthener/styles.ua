<div id="help-dialog">
    <?php echo $this->element('breadcrumb', array('plugin' => 'help', 'tree' => $tree)); ?>

    <div id="help-content">
        <?php
        echo $this->Form->create('Help', array('url' => array('plugin' => 'help', 'admin' => 'admin', 'controller' => 'helps', 'action' => 'set', base64_encode($referer), base64_encode($url))));
        echo $this->Form->hidden('id', array('value' => $help['Help']['id']));
        echo $this->Form->hidden('url', array('value' => $url));
        echo $this->Form->input('title');
        echo $this->FebTinyMce->input('content', array('label' => false));
        echo $this->Form->end('Zapisz');
        ?>
    </div>
</div>