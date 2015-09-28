<div id="help-breadcrumb" class="clearfix">
    <div id="breadcrumb">
        <?php
        $treeCount = count($tree);
        $i = 1;
        $link = array(
            'controller' => 'helps',
            'action' => 'special_view',
            'admin' => 'admin',
            'plugin' => 'help',
            base64_encode($referer),
            base64_encode($url)
        );
        $linkParams = array(
            //'before' => '$("#help-dialog").dialog("open");',
            'update' => '#help-dialog',
            'escape' => false,
            'title' => 'Pomoc',
            'class' => 'help-exist'
        );

        foreach ($tree as $key => $value) {
            $i++;
            //Dodawanie Akcji Edycji Pomocy
            //$linkParams['data'] = $this->Js->object(array('data' => array('Help' => array('url' => $key))));
            //Wartosci skrajne
            $link[1] = base64_encode($key);
            if ($key == '/') {
                //Klucz to root
                echo $this->Js->link($value, $link, $linkParams) . ' ';
            } else {
                echo $this->Js->link($value, $link, $linkParams) . ' » ';
            }

            //if ($referer == $key) {
            //Ustawianie klasy dla istniejacych / nie istniejacych wpisow
            //$linkParams['class'] = 'help-not-exist';
//            if ($permissionAction) {
//                $link['action'] = 'edit';
//            }
            //debug($linkParams);
            echo ($this->Js->writeBuffer());
        }
        ?>
    </div>
    <div id="help-edit-area">
        <?php
        $editLink = array(
            'controller' => 'helps',
            'action' => 'set',
            'admin' => 'admin',
            'plugin' => 'help',
            base64_encode($referer),
            base64_encode($url)
        );
        $editParams = array(
            'title' => __d('cms', 'Edycja Strony Pomocy'),
            'escape' => false,
        );
        echo $this->Html->link($this->Html->image('/help/img/edit.png'), $editLink, $editParams);
        ?>
    </div>
</div>