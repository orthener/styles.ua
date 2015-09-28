<?php

class NewsletterMessage extends AppModel {

    public $name = 'NewsletterMessage';
    public $actsAs = array(
        'Translate' => array('title' => 'translateTitle', 'html_content' => 'translateHtmlContent', 'content' => 'translateContent'),
    );
    public $validate = array(
        'title' => array(
            'length' => array(
                'rule' => array('notempty')
            )
        ),
    );
    public $displayField = 'title';

    public function __construct() {
        parent::__construct();
        $this->validate['title']['length']['message'] = __d('front', "Wprowadź tytuł wiadomości");
    }

}

?>