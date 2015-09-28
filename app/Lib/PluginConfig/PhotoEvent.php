<?php

/*
 * 
 * 
 */

/**
 * Description of Email
 *
 * @author Sławomir Jach
 */
App::uses('CakeEventListener', 'Event');
class PhotoEvent implements CakeEventListener {
    
    public function implementedEvents() {
        return array(
            'Model.Photo.afterInit' => 'afterPhotoInit',
        );
    }

    function afterPhotoInit($event) {
        $model = $event->subject();

        $model->belongsTo = array(
            'Page' => array(
                'className' => 'Page.Page',
                'foreignKey' => 'page_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            'Product' => array(
                'className' => 'StaticProduct.Product',
                'foreignKey' => 'product_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            'InfoPage' => array(
                'className' => 'Info.InfoPage',
                'foreignKey' => 'info_page_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            'News' => array(
                'className' => 'News.News',
                'foreignKey' => 'news_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            
        );
    }
    
}

?>
