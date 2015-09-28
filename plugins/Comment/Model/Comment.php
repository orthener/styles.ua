<?php

class Comment extends AppModel {

    public $name = 'Comment';
    public $displayField = 'name';

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array(
        //'Slug',
        //'Translate' => array('name'),
        //'Image.Upload'=>array('imageOptions'=>array('size'=>array('width'=>1920, 'height'=>1200))),
        //'Tree.FebTree'
        'Menu.Menu',
//        'Modification.Modification'
    );
    public $belongsTo = array(
        'News' => array(
            'className' => 'News.News',
            'foreignKey' => 'news_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public static $front_modes = array(
        'default' => 1,
        'blog' => 2,
        'studio' => 3,
        'blog_stopka' => 4,
        'studio_stopka' => 5
    );

    public function setScope($scope) {
        $this->Behaviors->attach('Menu.Menu', array('scope' => $scope));
    }

}
