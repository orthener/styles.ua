<?php

// Ustawia SERVER_NAME - do wykorzystania tam, gdzie nie ma mozliwosci skorzystania z $_SERVER['SERVER_NAME'] (cake console)
function setServerName($server_name = null) {
    $http = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    if (isSet($_SERVER['SERVER_NAME'])) {
        $server_name = str_replace(array('http://', 'https://'), '', $_SERVER['SERVER_NAME']);
    }
    if (empty($server_name)) {
        $file = WWW_ROOT . 'serw_name.txt';
        $server_name = file_get_contents($file);

        $_SERVER['SERVER_NAME'] = $http . $server_name;
    }
    if (!defined('FULL_BASE_URL')) {
        define('FULL_BASE_URL', $http . $server_name);
    }

    if (!defined('SURE_BASE_URL')) {
        define('SURE_BASE_URL', $server_name);
    }
    Configure::write('App.SERVER_NAME', $server_name);
}

setServerName();
?>