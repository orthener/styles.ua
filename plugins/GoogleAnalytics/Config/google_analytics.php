<?php
class GOOGLE_ANALYTICS_CONFIG {

    var $googleAnalytics = array(
        'datasource' => 'google_analytics',
        'Email' => 'statystyki@feb.net.pl',
        'Passwd' => 'yf6rf23!WESUD'
    );
    var $googleAnalytics_test = array(
        'datasource' => 'google_analytics',
        'Email' => 'user@google.com',
        'Passwd' => 'super-secret-password'
    );

    function __construct() {
        if (Configure::read('Analytics.datasource'))
            $this->googleAnalytics['datasource'] = Configure::read('Analytics.datasource');

        if (Configure::read('Analytics.email'))
            $this->googleAnalytics['Email'] = Configure::read('Analytics.email');

        if (Configure::read('Analytics.passwd'))
            $this->googleAnalytics['Passwd'] = Configure::read('Analytics.passwd');
    }

}
