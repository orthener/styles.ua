<?php

class Category extends AppModel {

    var $name = 'Category';
    var $actsAs = array(
        'Translate' => array('name' => 'translateDisplay', 'url' => 'translateUrl'),
        'Tree.FebTree'
    );

    function virtualSlug($locale = null) {
        if (empty($locale)) {
            $I18n = & I18n::getInstance();
            $locale = $I18n->l10n->locale;
        }
        $this->virtualFields['slug'] = 'SELECT content FROM i18n AS slugs WHERE slugs.foreign_key COLLATE utf8_bin = Category.row_id COLLATE utf8_bin AND slugs.model COLLATE utf8_unicode_ci = Category.model COLLATE utf8_unicode_ci AND slugs.field = "slug" AND slugs.locale COLLATE utf8_unicode_ci = "' . $locale . '" COLLATE utf8_unicode_ci ';
    }

    function beforeFind($query) {
        $return = parent::beforeFind($query);

        $query = (is_array($return)) ? $return : $query;

        if ($return === false) {
            return false;
        }

        $this->virtualSlug();

        return $query;
    }

    var $displayField = 'name';
    var $options = array();
    var $belongsTo = array(
        'Page' => array(
            'className' => 'Page.Page',
            'foreignKey' => 'row_id',
            'conditions' => array('Category.model' => 'Page')
        )
    );
    var $validate = array(
        'name' => array(
            'length' => array(
                'rule' => array('notempty')
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'depth' => array('rule' => array('maxdepth' => 3))
    );

    function __construct() {
        parent::__construct();
        $this->validate['name']['length']['message'] = __d('cms', "Wprowadź tytuł");
        $this->validate['depth']['message'] = __d('cms', "Menu może mieć maksymalnie 3 poziomy zagłębienia");

        $this->options['0'] = __d('cms', 'Pozycja bez linku (węzeł)');
        $this->options['1'] = __d('cms', 'Pozycja z linkiem');
        $this->options['2'] = __d('cms', 'Pozycja powiązana z podstroną');
    }

}

?>