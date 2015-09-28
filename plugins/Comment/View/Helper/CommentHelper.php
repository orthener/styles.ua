<?php

/**
 * CommentHelper
 * 
 * @version 1.0
 * 
 */
class CommentHelper extends AppHelper {

    public $helpers = array("Html", 'Text', 'Permissions');
        
    public function render($type) {
        $this->out = '';

        $navComment = CommentCMS::getStructure($type);
        $navComment = $this->authData($navComment);
        $navComment = $this->clearParents($navComment);      
        $this->renderLinks($navComment);
        return $this->out;
        
    }
    
    private function renderLinks($data) {
        $this->out .= '<ul>';
        foreach($data as $d) {
            $class = !$d['Comment']['parent_id'] ? ' class="subNav"' : ' ';
            $this->out .= "<li{$class}>";
            $this->out .= $this->Html->link($d['Comment']['label'], $d['Comment']['url']);
            if (!empty($d['children'])) {
                $this->renderLinks($d['children']);
            }  
            
            $this->out .= '</li>';
            
        }
        
        $this->out .= '</ul>';
        return $this->out;
    }
    
    public function authData($navComment) {
        
        foreach ($navComment as $k => &$d) {
            
            if (!empty($d['children'])) {
                $this->authData(&$d['children']);
            }
            
            if ($d['Comment']['url'] != '#' && !$this->Permissions->isAuthorized($d['Comment']['url'])) {      
                unSet($navComment[$k]);
                continue;
            }
        }
                
        return $navComment;
    }
    
    private function clearParents($navComment) {
        
        foreach ($navComment as $k => &$d) {
            
            if (!empty($d['children'])) {
                $this->clearParents(&$d['children']);
            } elseif(!$d['Comment']['parent_id'] && $d['Comment']['url'] == '#') {
                unSet($navComment[$k]);
            }
        }
        
        return $navComment;
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