<?php
class HelpLib {

    static $helpTree = array();
    
    static function flush() {
        self::$helpTree = array();
    }
    
    static function initHelpTree($url) {
        
        $tree_links = explode('/', $url);
        if (count($tree_links) == 1) {
            //Jestem w korzeniu
            self::$helpTree['/'] = '';
            self::$helpTree = array_reverse(self::$helpTree);

            return self::$helpTree;
        } else {
            //Szukam w bazie wpisów z calego drzewa
            $newUrl = implode('/', $tree_links);
            //Zapisuje wyszukiwana galaz
            self::$helpTree[$newUrl] = '';
            //odpinam ostatni element        
            unset($tree_links[count($tree_links)-1]);
            $newUrl = implode('/', $tree_links);
            self::initHelpTree($newUrl);
        }
    }
    
    static function getHelpTree($url){
        self::flush();
        self::initHelpTree($url); 
        $tree_array = explode('/', $url);
         
        if ($url == '/') {
            unset($tree_array[1]);
        }
        $tree_array[0] = '/'; 
        $tree = array_combine(array_keys(self::$helpTree), $tree_array);
        return $tree;

    }
        
}
?>