<?php

/**
 * Libraries
 */
App::import('Vendor', 'Setting.Spyc/Spyc');

/**
 * Settings
 */
if (file_exists(APP . 'Config' . DS . 'settings.yml')) {
    $settings = Spyc::YAMLLoad(file_get_contents(APP . 'Config' . DS . 'settings.yml'));
    foreach ($settings AS $settingKey => $settingValue) {
        Configure::write($settingKey, $settingValue);
    }
} else {
    throw new Exception('Brak pliku settings.yml w ' . APP . 'Config' . DS . 'settings.yml');
}

/**
 * Locale
 */
define('DEFAULT_LANGUAGE', Configure::read('App.defaultLanguage'));

/**
 * Konfiguracja walidacji aplikacji
 */
App::uses('CakeEventManager', 'Event');
CakeEventManager::instance()->attach('beforeValidateSetting', 'Model.settingBeforeValidate');

function beforeValidateSetting($event) {
    $model = $event->subject();
    
    unSet($model->validate['value']);
    if (!empty($model->data['Setting']['key'])) {

        if ($model->data['Setting']['key'] == 'App.WebSenderEmail') {
            $model->validate['value'] = array(
                'rule' => 'email',
                'message' => "Musi być typu email"
            );
        }

        if ($model->data['Setting']['key'] == 'App.AdminEmail') {
            $model->validate['value'] = array(
                'rule' => 'email',
                'message' => "Musi być typu email"
            );
        }
    }
    
}

?>