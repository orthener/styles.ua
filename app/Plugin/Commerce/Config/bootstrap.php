<?php

if (!defined('PRICE_NET')) {
    define('PRICE_NET', 0);
}
if (!defined('PRICE_GROSS')) {
    define('PRICE_GROSS', 1);
}

if (!defined('PRICE_TYPE')) {
    define('PRICE_TYPE', PRICE_GROSS);
}

if (!Configure::read('Commerce.Sender.Email') AND Configure::read('App.WebSenderEmail')) {
    Configure::write('Commerce.Sender.Email', Configure::read('Email.default'));
}

if (!Configure::read('Commerce.Sender.Name') AND Configure::read('App.AppName')) {
    Configure::write('Commerce.Sender.Name', Configure::read('Email.defaultname'));
}
?>