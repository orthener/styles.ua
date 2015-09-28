<?php

/**
 * Setting
 *
 * PHP version 5
 *
 * @category Model
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
App::uses('SettingModel', 'Model');
App::uses('CakeEvent', 'Event');

class Setting extends AppModel {

    /**
     * Model name
     * 
     * @var string
     * @access public
     */
    public $name = 'Setting';

    /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    public $actsAs = array('Tree');

    /**
     * Domyslne sortowanie 
     */
    public $order = array('Setting.lft ASC');
    public $validateDomain = 'validate';
    public $validate = array(
        'key' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Klucz musi być unikalny',
            ),
            'minLength' => array(
                'rule' => array('minLength', 1),
                'message' => 'Pole nie może być puste',
            ),
        ),
    );

    /**
     * afterSave callback
     *
     * @return void
     */
    public function afterSave() {
        $this->updateYaml();
        $this->writeConfiguration();
    }

    /**
     * afterDelete callback
     *
     * @return void
     */
    public function afterDelete() {
        $this->updateYaml();
        $this->writeConfiguration();
    }

    function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        $this->getEventManager()->dispatch(new CakeEvent('Model.settingBeforeValidate', $this));
    }

    /**
     * Creates a new record with key/value pair if key does not exist.
     *
     * @param string $key
     * @param string $value
     * @param array $options
     * @return boolean
     */
    public function write($key, $value, $options = array()) {
        $_options = array(
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'params' => '',
        );
        $options = array_merge($_options, $options);

        $setting = $this->findByKey($key);
        if (isset($setting['Setting']['id'])) {
            $setting['Setting']['id'] = $setting['Setting']['id'];
            $setting['Setting']['value'] = $value;
            $setting['Setting']['description'] = $options['description'];
            $setting['Setting']['input_type'] = $options['input_type'];
            $setting['Setting']['editable'] = $options['editable'];
            $setting['Setting']['params'] = $options['params'];
        } else {
            $setting = array();
            $setting['key'] = $key;
            $setting['value'] = $value;
            $setting['description'] = $options['description'];
            $setting['input_type'] = $options['input_type'];
            $setting['editable'] = $options['editable'];
            $setting['params'] = $options['params'];
        }

        $this->id = false;
        if ($this->save($setting)) {
            Configure::write($key, $value);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes setting record for given key
     *
     * @param string $key
     * @return boolean
     */
    public function deleteKey($key) {
        $setting = $this->findByKey($key);
        if (isset($setting['Setting']['id']) &&
                $this->delete($setting['Setting']['id'])) {
            return true;
        }
        return false;
    }

    /**
     * All key/value pairs are made accessible from Configure class
     *
     * @return void
     */
    public function writeConfiguration() {
        $settings = $this->find('all', array('fields' => array('Setting.key', 'Setting.value')));
        foreach ($settings AS $setting) {
            Configure::write($setting['Setting']['key'], $setting['Setting']['value']);
        }
    }

    /**
     * Find list and save yaml dump in app/config/settings.yml file.
     * Data required in bootstrap.
     *
     * @return void
     */
    public function updateYaml() {
        $list = $this->find('list', array(
            'fields' => array(
                'key',
                'value',
            ),
            'order' => array(
                'Setting.key' => 'ASC',
            ),
                ));
        $filePath = APP . 'Config' . DS . 'settings.yml';

        $listYaml = Spyc::YAMLDump($list, 4, 60);
        file_put_contents($filePath, $listYaml);
    }

}

?>