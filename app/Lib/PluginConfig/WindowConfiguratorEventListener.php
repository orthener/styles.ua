<?php

/*
 * 
 * 
 */

/**
 * @author Arkadiusz Dziki
 * 
 * @copyright (c) 2012, feb.net.pl, Arkadiusz Dziki
 */
App::uses('CakeEventListener', 'Event');
class WindowConfiguratorEventListener implements CakeEventListener {
    
    public function implementedEvents() {
        return array(
            'Model.Photo.afterInit' => 'afterPhotoInit',
        );
    }

    function afterPhotoInit($event) {
        $model = $event->subject();


    }
    
}

?>
