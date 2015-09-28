<?php

class User extends AppModel {

    var $name = 'User';
    var $displayField = 'name';
    var $actsAs = array('Image.Upload', 'Modification.Modification');
//    var $useTable = 'phpbb_users';
//    var $tablePrefix = '';
//    var $primaryKey = 'user_id';
//    var $displayField = 'username';

    var $validate = array(
        'email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => 'Podaj prawidłowy adres email',
            ),
            'uniqe' => array(
                'rule' => 'isUnique',
                'message' => 'Ten adres jest już zarejestrowany w naszej bazie'
            )
        ),
        'name' => array(
            'maxlength' => array(
                'rule' => array('maxlength', 30),
                'message' => 'Podaj nazwę nie przekraczającą 30 znaków',
            ),
            'minLength' => array(
                'rule' => array('minLength', 3),
                'message' => 'Podaj nazwę przekraczającą 3 znaki',
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Ten login jest już zajęty, wybierz inny'
            ),
//            'format' => array(
//                'rule' => array(
//                    'custom', '/^[A-Za-z0-9_ -]+$/',
//                ),
//                'message' => 'To pole nie może zawierać znaków specjalnych'
//            ),
        ),
        'newpassword' => array(
            'lenght' => array(
                'rule' => array('minLength', 5),
                'message' => 'Hasło musi zawierać minimum 5 znaków',
            ),
            'equal' => array(
                'rule' => 'validatePassword',
                'message' => 'Hasła wpisane w oba pola nie są takie same.',
            )
        ),
        'rules' => array(
            'rule' => array('comparison', '!=', 0),
            'message' => 'Nie zaakceptowałeś regulaminu serwisu',
        //'on' => 'create'
        ),
    );
    var $hasAndBelongsToMany = array(
        'Group' => array(
            'className' => 'User.Group',
            'joinTable' => 'groups_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'group_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Permission' => array(
            'className' => 'User.Permission',
            'joinTable' => 'requesters_permissions',
            'foreignKey' => 'row_id',
            'associationForeignKey' => 'permission_id',
            'unique' => true,
            'conditions' => array('RequestersPermission.model' => 'User'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    var $hasOne = array(
        'Customer' => array(
            'className' => 'Commerce.Customer',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'dependent' => true
        )
    );

    /**
     * Serializacja pól PermissionGroup
     * 
     * @return boolean 
     */
    function beforeSave() {
        if (isSet($this->data['PermissionGroup'])) {
            $this->data[$this->name]['permission_groups'] = json_encode($this->data['PermissionGroup']);
        }
        return true;
    }

    /**
     * Logika powiązań z modelem RequestersPermission, usuwanie odznaczonych
     * oraz zapisywanie zaznaczonych uprawnień, w chwili obecnym ich stanie
     * 
     * @param type $created
     * @return boolean
     * @throws ErrorException 
     */
    function afterSave($created) {

        if (isSet($this->data['PermissionGroup'])) {
            $this->data[$this->name]['permission_groups'] = json_encode($this->data['PermissionGroup']);

            $params['conditions']['Permission.permission_group_id'] = $this->data['PermissionGroup']['PermissionGroup'];
            $params['fields'] = array('Permission.id');
            $permissions = $this->Permission->PermissionGroup->Permission->find('list', $params);

            $params = array();
            $params['conditions']['RequestersPermission.model'] = $this->name;
            $params['conditions']['RequestersPermission.row_id'] = $this->data[$this->name]['id'];
            $params['fields'] = array('RequestersPermission.permission_id');
            $requestersPermissionsToDelete = $this->Permission->RequestersPermission->find('list', $params);
            if (!empty($requestersPermissionsToDelete)) {
                if (!$this->Permission->RequestersPermission->deleteAll(array('RequestersPermission.permission_id' => $requestersPermissionsToDelete), false)) {
                    throw new ErrorException(__d('cms', 'Krytyczny błąd podczas usuwania uprawnień'));
                }
            }
            if (!empty($permissions)) {
                $toSave['RequestersPermission']['model'] = $this->name;
                $toSave['RequestersPermission']['row_id'] = $this->data[$this->name]['id'];
                foreach ($permissions as $permissionId) {
                    $toSave['RequestersPermission']['permission_id'] = $permissionId;
                    $this->Permission->RequestersPermission->create();
                    if (!$this->Permission->RequestersPermission->save($toSave)) {
                        throw new ErrorException(__d('cms', 'Krytyczny błąd podczas zapisywania uprawnień (odznaczone uprawnienia zostały już usunięte)'));
                    }
                }
            }
            unset($this->data['PermissionGroup']);
        }
        return true;
    }

    /**
     * Deserializacja pól PermissionGroup
     * 
     * @param type $dates
     * @return type 
     */
    function afterFind($dates) {
        foreach ($dates as &$data) {
            if (is_array($data)) {

                if (isSet($data[$this->name]['permission_groups'])) {
                    if ($data[$this->name]['permission_groups'] == null) {
                        $data['PermissionGroup']['PermissionGroup'] = array();
                    } else {
                        $data['PermissionGroup'] = json_decode($data[$this->name]['permission_groups'], true);
                        if (empty($data['PermissionGroup']['PermissionGroup'])) {
                            $data['PermissionGroup']['PermissionGroup'] = array();
                        }
                    }
                } else {
                    $data['PermissionGroup']['PermissionGroup'] = array();
                }
            }
        }
        return $dates;
    }

    function beforeValidate() {

        if (!empty($this->data['User'])) {
            foreach ($this->data['User'] as $key => &$field) {
                if (is_string($field) and !in_array($key, array('newpassword', 'confirmpassword'))) {
                    $field = trim($field);
                }
            }
        }
        
        $this->validate = array(
            'email' => array(
                'email' => array(
                    'rule' => 'email',
                    'message' => __d('cms', 'Podaj prawidłowy adres email'),
                ),
                'uniqe' => array(
                    'rule' => 'isUnique',
                    'message' => __d('cms', 'Ten adres jest już zarejestrowany w naszej bazie')
                )
            ),
            'name' => array(
                'maxlength' => array(
                    'rule' => array('maxlength', 30),
                    'message' => __d('cms', 'Podaj nazwę nie przekraczającą 30 znaków'),
                ),
                'minLength' => array(
                    'rule' => array('minLength', 3),
                    'message' => __d('cms', 'Podaj nazwę przekraczającą 3 znaki'),
                ),
                'isUnique' => array(
                    'rule' => 'isUnique',
                    'message' => __d('cms', 'Ten login jest już zajęty, wybierz inny')
                ),
            ),
            'newpassword' => array(
                'lenght' => array(
                    'rule' => array('minLength', 5),
                    'message' => __d('cms', 'Hasło musi zawierać minimum 5 znaków'),
                ),
                'equal' => array(
                    'rule' => 'validatePassword',
                    'message' => __d('cms', 'Hasła wpisane w oba pola nie są takie same.'),
                )
            ),
            'rules' => array(
                'rule' => array('comparison', '!=', 0),
                'message' => __d('cms', 'Nie zaakceptowałeś regulaminu serwisu'),
            //'on' => 'create'
            ),
        );
        return true;
    }

    /**
     *  Sprawdzenie zgodnosci hasla z powtorzeniem hasla
     * 
     * @param type $value
     * @param type $params
     * @return boolean 
     */
    function validatePassword($value, $params) {
        if (isset($this->data['User']['newpassword'], $this->data['User']['confirmpassword']) && $this->data['User']['newpassword'] !== $this->data['User']['confirmpassword']) {
            $this->invalidate('confirmpassword', ' ');
            return false;
        }
        return true;
    }

    /**
     * Sprawdza poprawność hash'a'
     * 
     * @param type $id
     * @param type $hash
     * @return boolean 
     */
    function checkResetPassHash($id, $hash) {
        $userData = $this->read('modified', $id);
        $compare = Security::hash($id . $userData['User']['modified'], null, true);
        if ($compare == $hash) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Zwraca link do zmiany hasła
     * 
     * @param type $email
     * @param type $modified
     * @return type 
     */
    function createResetPassLink($email, $modified) {
        $link = array('controller' => 'users', 'action' => 'new_pass', $id);
        $link[] = Security::hash($id . $modified, null, true);
        return $link;
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

    function logAction($action = null, $id = null, $login = null, $email = null) {

        App::uses('UsersLog', 'User.Model');
        $this->UsersLog = new UsersLog();
        $data['UsersLog']['user_id'] = ($id === null) ? $this->id : $id;
        if ($action != null) {
            $data['UsersLog']['action'] = $action;
        }
        if ($login != null) {
            $data['UsersLog']['login'] = $login;
        } else {
            $user = $this->find('first', array('conditions' => array('User.' . $this->primaryKey => $id)));
            $data['UsersLog'][$this->displayField] = $user['User'][$this->displayField];
            $email = $user['User']['email'];
        }
        if ($email != null) {
            $data['UsersLog']['email'] = $email;
        }
        $this->UsersLog->create();
        $this->UsersLog->save($data);
    }

    /**
     * Generate salt for hash generation 
     * 
     * @param type $input
     * @param type $itoa64
     * @param int $iteration_count_log2
     * @return type 
     */
    private function _hash_gensalt_private($input, &$itoa64, $iteration_count_log2 = 6) {
        if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31) {
            $iteration_count_log2 = 8;
        }
        $output = '$H$';
        $output .= $itoa64 [min($iteration_count_log2 + ((PHP_VERSION >= 5) ? 5 : 3), 30)];
        $output .= $this->_hash_encode64($input, 6, $itoa64);
        return $output;
    }

    /**
     * Encode hash 
     * 
     * @param type $input
     * @param type $count
     * @param type $itoa64
     * @return type 
     */
    private function _hash_encode64($input, $count, &$itoa64) {
        $output = '';
        $i = 0;
        do {
            $value = ord($input [$i++]);
            $output .= $itoa64 [$value & 0x3f];
            if ($i < $count) {
                $value |= ord($input [$i]) << 8;
            }
            $output .= $itoa64 [($value >> 6) & 0x3f];
            if ($i++ >= $count) {
                break;
            }
            if ($i < $count) {
                $value |= ord($input [$i]) << 16;
            }
            $output .= $itoa64 [($value >> 12) & 0x3f];
            if ($i++ >= $count) {
                break;
            }
            $output .= $itoa64 [($value >> 18) & 0x3f];
        } while ($i < $count);
        return $output;
    }

    /**
     * The crypt function/replacement 
     * 
     * @param type $password
     * @param type $setting
     * @param type $itoa64
     * @return string 
     */
    private function _hash_crypt_private($password, $setting, &$itoa64) {
        $output = '*';
        // Check for correct hash 
        if (substr($setting, 0, 3) != '$H$') {
            return $output;
        }
        $count_log2 = strpos($itoa64, $setting [3]);
        if ($count_log2 < 7 || $count_log2 > 30) {
            return $output;
        }
        $count = 1 << $count_log2;
        $salt = substr($setting, 4, 8);
        if (strlen($salt) != 8) {
            return $output;
        }
        /**
         * We're kind of forced to use MD5 here since it's the only 
         * cryptographic primitive available in all versions of PHP 
         * currently in use.  To implement our own low-level crypto 
         * in PHP would result in much worse performance and 
         * consequently in lower iteration counts and hashes that are 
         * quicker to crack (by non-PHP code). 
         */
        if (PHP_VERSION >= 5) {
            $hash = md5($salt . $password, true);
            do {
                $hash = md5($hash . $password, true);
            } while (--$count);
        } else {
            $hash = pack('H*', md5($salt . $password));
            do {
                $hash = pack('H*', md5($hash . $password));
            } while (--$count);
        }
        $output = substr($setting, 0, 12);
        $output .= $this->_hash_encode64($hash, 16, $itoa64);
        return $output;
    }

    function utf8_clean_string($text) {
        static $homographs = array();
        if (empty($homographs)) {
            $homographs = include(WWW_ROOT . 'confusables.php');
        }
        $text = strtr($text, $homographs);
        // Other control characters
        $text = preg_replace('#(?:[\x00-\x1F\x7F]+|(?:\xC2[\x80-\x9F])+)#', '', $text);
        // we need to reduce multiple spaces to a single one
        $text = preg_replace('# {2,}#', ' ', $text);
        $text = strtolower($text);
        // we can use trim here as all the other space characters should have been turned
        // into normal ASCII spaces by now
        return trim($text);
    }

    public function unique_id($extra = 'c') {
        static $dss_seeded = false;
        $val = microtime();
        $val = md5($val);
        $dss_seeded = true;
        return substr($val, 4, 16);
    }

    /**
     * Check for correct password
     *
     * @param string $password The password in plain text
     * @param string $hash The stored password hash
     *
     * @return bool Returns true if the password is correct, false if not.
     */
    function phpbb_check_hash($password, $hash) {

        $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        if (strlen($hash) == 34) {
            return ($this->_hash_crypt_private($password, $hash, $itoa64) === $hash) ? true : false;
        }
        return (md5($password) === $hash) ? true : false;
    }

    public function phpbb_hash($password) {
        $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $random_state = $this->unique_id();
        $random = '';
        $count = 6;

        if (($fh = @fopen('/dev/urandom', 'rb'))) {

            $random = fread($fh, $count);

            fclose($fh);
        }

        if (strlen($random) < $count) {
            $random = '';
            for ($i = 0; $i < $count; $i+=16) {

                $random_state = md5($this->unique_id() . $random_state);

                $random .= pack('H*', md5($random_state));
            }

            $random = substr($random, 0, $count);
        }
        $hash = $this->_hash_crypt_private($password, $this->_hash_gensalt_private($random, $itoa64), $itoa64);

        if (strlen($hash) == 34) {
            return $hash;
        }
        return md5($password);
    }

    /**
     * Hashes an email address to a big integer
     *
     * @param string $email		Email address
     *
     * @return string			Unsigned Big Integer
     */
    function phpbb_email_hash($email) {
        return sprintf('%u', crc32(strtolower($email))) . strlen($email);
    }

    /**
     * Logika dla globalnej wyszukiwarki w cms
     * nadpisuje metodę z AppModel
     * 
     * @param array $options
     * @param array $params
     * @return type array
     */
    public function search($options, $params = array()) {
        $fraz = $options['Searcher']['fraz'];
        $params['conditions']['OR']["User.name LIKE"] = "%{$fraz}%";
        $params['conditions']['OR']["User.email LIKE"] = "%{$fraz}%";
        $params['limit'] = 5;
        $this->recursive = 1;
        return $this->find('all', $params);
    }

    function filterParams($data) {
        $params = array();
        if (!empty($data['User']['id'])) {
            $params['conditions']['User.id'] = $data['User']['id'];
        }
        if (!empty($data['User']['email'])) {
            $params['conditions']['User.email LIKE'] = '%' . $data['User']['email'] . '%';
        }
        if (!empty($data['Group']['id'])) {
            $params['joins'][] = array(
                'table' => 'groups_users',
                'alias' => 'GroupsUser',
                'type' => 'LEFT',
                'conditions' => array(
                    'GroupsUser.user_id = User.id',
                )
            );
            $params['conditions']['GroupsUser.group_id'] = $data['Group']['id'];
        }

        return $params;
    }

}

?>