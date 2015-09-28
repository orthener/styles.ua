<?php

class Menu extends AppModel {

    public $name = 'Menu';
    public $displayField = 'name';

    /**
     * Pole inicjalizujące Behaviory
     *
     * @var array
     */
    public $actsAs = array(
        //'Slug',
        'Translate' => array('name', 'url'),
        //'Image.Upload'=>array('imageOptions'=>array('size'=>array('width'=>1920, 'height'=>1200))),
        //'Tree.FebTree'
        'Menu.Menu',
        'Modification.Modification'
    );
    public $belongsTo = array(
        'Page' => array(
            'className' => 'Page.Page',
            'foreignKey' => 'row_id',
            'conditions' => array('Menu.model' => 'Page')
        )
    );
    public static $modes = array(
        1 => 'Sklep',
        2 => 'Blog',
        3 => 'Studio',
        4 => 'Blog - stopka',
        5 => 'Studio - stopka'
    );
    public static $front_modes = array(
        'default' => 1,
        'blog' => 2,
        'studio' => 3,
        'blog_stopka' => 4,
        'studio_stopka' => 5,
        'shop' => 1
    );

    public function urlOptions() {
        $options['0'] = __d('cms', 'Pozycja bez linku (węzeł)');
        $options['1'] = __d('cms', 'Pozycja z linkiem');
        $options['2'] = __d('cms', 'Pozycja powiązana z podstroną');
        return $options;
    }

    public function setScope($scope) {
        $this->Behaviors->attach('Menu.Menu', array('scope' => $scope));
    }

}
