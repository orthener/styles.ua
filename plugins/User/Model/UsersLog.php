<?php

class UsersLog extends AppModel {

    public $name = 'UsersLog';
    public $useTable = 'users_logs';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User.User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => ''
        )
    );

    function beforeSave() {

        if (empty($this->data['UsersLog']['id']) AND empty($this->id)) {

            $this->data['UsersLog']['really_ip'] = $this->getOnlyIP();
            $this->data['UsersLog']['users_ip'] = $this->getUserIP();
            if (empty($this->data['UsersLog']['action'])) {
                $this->data['UsersLog']['action'] = $_SERVER['PHP_SELF'];
            }
        }

        return true;
    }

    /**
     * Funkcja zwraca IP uzytkownika, serwera PROXY i host
     * 
     * @return string 
     */
    function getUserIP() {
        $userIP = '';

        // Uzytkownik wchodzi poprzez PROXY
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $userIP .= 'IP:' . $_SERVER['HTTP_X_FORWARDED_FOR'] . ', PROXY:' . $_SERVER['REMOTE_ADDR'] . ', HOST: ' . @gethostbyaddr($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            // Uzytkownik wszedl bez serwera PROXY
            $userIP .= 'IP:' . $_SERVER['REMOTE_ADDR'] . ', HOST: ' . @gethostbyaddr($_SERVER['REMOTE_ADDR']);
        }

        return $userIP;
    }

    /**
     * Funkcja zwraca rzeczywiste (z uwzglednieniem PROXY) IP uzytkownika
     * 
     * @return type 
     */
    function getOnlyIP() {
        $userIP = null;

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // if access direct to Internet, without Proxy
            $userIP = $_SERVER['REMOTE_ADDR'];
        }

        return $userIP;
    }

    function last_login($user_id) {
        $this->recursive = -1;
        $data = $this->find('all', array(
            'conditions' => array(
                'UsersLog.user_id' => $user_id,
                'UsersLog.action' => 'Вы вошли в свой аккаунт.'
            ),
            'order' => 'UsersLog.created DESC',
            'limit' => 2,
            'fields' => 'created'
                ));

        if (!isset($data[1])) {
            $data = 'pierwsze logowanie';
        } else {
            $data = $data[1]['UsersLog']['created'];
            $date = new DateTime($data);
            $data = $date->format('d-m-Y H:i:s');
        }

        return $data;
    }

}

?>
