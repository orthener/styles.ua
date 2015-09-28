<?php

/**
 * Description MenuCms
 *
 * @author Sławomir Jach
 * 
 * @To-Do Dodać klucze after, before przy dodawaniu, dodać opcjonalne ikonki oraz tooltipy
 */
class MenuCMS extends Object {

    const TOP = 1;
    const LEFT = 2;

    private static $_map = array();
    private static $_data = array();

    public static function add($menu, $position, $url, $order = null) {

//        debug($url);
//        $url = Router::parse(Router::normalize($url));
        if (!empty($url['prefix']) && !empty($url['action']) && strpos($url['action'], $url['prefix'] . '_') === 0) {
            $url['action'] = substr($url['action'], strlen($url['prefix'] . '_'));
        }
        self::$_data[$menu][$position] = $url;
    }

    /**
     * Element:
     * 
     * parent_id
     * isNode
     * name
     * url
     * 
     */
    public static function getStructure($menu, $scope = '1 = 1') {
        $ret = array();
        $uid = 0;

        foreach (self::$_data[$menu] as $path => $url) {
            
            $insides = explode('/', $path);

            //Jest to węzeł
            if (count($insides) == 1) {
                $element['Menu'] = array(
                    'id' => self::getId($path, ++$uid),
                    'label' => $path,
                    'url' => $url,
                    'parent_id' => null
                );
                $ret[] = $element;
            } else {
                //Podmenu
                foreach ($insides as $curent => $label) {
                    ++$uid;
                    if ($curent == 0) {
                        //Tworzę tylko wtedy kiedy go nie ma
                        if (self::getId($label, $uid) == $uid) {
                            $element['Menu'] = array(
                                'id' => $uid,
                                'url' => '#',
                                'label' => $label,
                                'parent_id' => null
                            );
                            $ret[] = $element;
                        }
                    } else {
                        //Elementy drzewa                        
                        //Odcinam label w poszukiwaniu id parenta
                        $subPath = str_replace('/'.$label, '', $path);
                        //debug($uid);
                        $element['Menu'] = array(
                            'id' => self::getId($path, $uid),
                            'url' => $url,
                            'label' => $label,
                            'parent_id' => self::getId($subPath)
                        );
                        $ret[] = $element;
                    }
                }
            }
        }

        return Set::nest($ret);
    }

    private static function getId($path, $uid = null) {
        if (isSet(self::$_map[$path])) {
            return self::$_map[$path];
        } else {
//            if (!$uid) throw new Exception('Musi istnieć parent do tego node');
            self::$_map[$path] = $uid;
            return $uid;
        }
    }
    
}

?>
