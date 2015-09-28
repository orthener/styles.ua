<?php

/**
 * MenuHelper
 * 
 * @version 1.0
 * 
 */
class MenuHelper extends AppHelper {

    public $helpers = array("Html", 'Text', 'Permissions');
        
    public function render($type) {
        $this->out = '';

        $navMenu = MenuCMS::getStructure($type);
        $navMenu = $this->authData($navMenu);
        $navMenu = $this->clearParents($navMenu);      
        $this->renderLinks($navMenu);
        return $this->out;
        
    }
    
    private function renderLinks($data) {
        $this->out .= '<ul>';
        foreach($data as $d) {
            $class = !$d['Menu']['parent_id'] ? ' class="subNav"' : ' ';
            $this->out .= "<li{$class}>";
            $this->out .= $this->Html->link($d['Menu']['label'], $d['Menu']['url']);
            if (!empty($d['children'])) {
                $this->renderLinks($d['children']);
            }  
            
            $this->out .= '</li>';
            
        }
        
        $this->out .= '</ul>';
        return $this->out;
    }
    
    public function authData($navMenu) {
        
        foreach ($navMenu as $k => &$d) {
            
            if (!empty($d['children'])) {
                $this->authData(&$d['children']);
            }
            
            if ($d['Menu']['url'] != '#' && !$this->Permissions->isAuthorized($d['Menu']['url'])) {      
                unSet($navMenu[$k]);
                continue;
            }
        }
                
        return $navMenu;
    }
    
    private function clearParents($navMenu) {
        
        foreach ($navMenu as $k => &$d) {
            
            if (!empty($d['children'])) {
                $this->clearParents(&$d['children']);
            } elseif(!$d['Menu']['parent_id'] && $d['Menu']['url'] == '#') {
                unSet($navMenu[$k]);
            }
        }
        
        return $navMenu;
    }
    
    public function reorganizeDataTree(&$data, $model, &$_this, $f) {

        foreach ($data as $k => &$d) {
            $tmpChildren = $d['children'];
            $d = $d[$model];
            $d['children'] = $tmpChildren;
            $f(&$d, $_this);
            if (!empty($d['children'])) {
                $this->reorganizeDataTree(&$d['children'], $model, &$_this, $f);
            }
        }
        
    }

}

?>