<?php

/**
 * FebHtmlHeleper
 * 
 * @version 1.0
 * 
 */
class FebHtmlHelper extends AppHelper {

    var $helpers = array("Html", 'Text', 'Permissions');
    var $_readmoreMark = '<!-- readmore -->';

    function readmore($text, $length = 100, $options = array()) {
        if (($pos = strpos($text, $this->_readmoreMark)) === false) {
            if (empty($options['html'])) {
                $text = strip_tags($text);
            }
            return $this->Text->truncate($text, $length, $options);
        }
        $text = substr($text, 0, $pos);
        if (empty($options['html'])) {
            $text = strip_tags($text);
        }
        if (!empty($options['forceTruncate'])) {
            return $this->Text->truncate($text, $length, $options);
        }
        return $text;
    }

    function meta($type = 'description', $content = null, $options = array()) {

        if ($type == 'description') {
            $content = $this->Text->truncate(strip_tags($content), 255, array('exact' => false));
            $lenght = mb_strlen($content, 'UTF-8');

            if ($lenght < 160) {
                $alternativeContent = Configure::read('Description.Alternative');
                $content .= $this->Text->truncate($content . ' ' . $alternativeContent, 255, array('exact' => false));
            }
        }

        return $this->Html->meta($type, $content, $options);
    }

    function position($position = 0, $type = 'latitude') {
        $degrees = floor($position);
        $minutesInRest = ($position - $degrees) * 60;
        $minutes = floor($minutesInRest);
        $second = ($minutesInRest - $minutes) * 60;
        $second = round($second * 10) / 10;
        $directions = 'E';
        if ($type == 'latitude') {
            $directions = ($position >= 0) ? 'N' : 'S';
        }
        if ($type == 'longitude') {
            $directions = ($position >= 0) ? 'E' : 'W';
        }

        $return = printf($directions . '%02.0f°%02.0f’%02.0f”', $degrees, $minutes, $second);

        return $return;
    }

    /**
     * Wypisuje dane z tablicy
     * 
     * @param type $data
     * @param type $determinel
     * @return type 
     */
    public function printArray($data = array(), $field = null, $options = array()) {
        $options['endl'] = empty($options['endl']) ? "<br />" : $options['endl'];

        $arrayCount = count($data);
        $output = "";
        foreach ($data as $key => $row) {
            $output .= $field ? $row[$field] : $row;
            if ($arrayCount != $key) {
                $output .= $options['endl'];
            }
        }
        return $output;
    }

public function getTagSize($clickedMax, $clicked) {
        //obiczamy wysokosc czcionki
        $fontSize = ((18 / $clickedMax) * $clicked) + 10;

        //zabezpiecznie przed zlym przeliczeniem
        if ($fontSize > 20)
            $fontSize = 20;
        if ($fontSize <= 10)
            $fontSize = 10;

        return $fontSize;
}


    public function renderMenu($navMenu = array()) {
        $output = '';
        foreach ($navMenu as $navLabel => $subMenus) {
            $ret = '';
            //Główny węzeł / link menu
            $navUrl = $subMenus[0];
            unSet($subMenus[0]);

            $permitedUrl = ($navUrl != '#') ? $this->Permissions->link(__d('cms', $navLabel), $navUrl) : $this->Html->link(__d('cms', $navLabel), $navUrl);

            foreach ($subMenus as $subLabel => $subUrl) {
                $linkTemp = $this->Permissions->link(__d('cms', $subLabel), $subUrl);
                $ret .= $linkTemp ? $this->Html->tag('li', $linkTemp) : '';
            }
            //Jezeli ma uprawnienia do jakiejkolwiek z ponizszych
            if ($ret OR $permitedUrl) {
                $output .= $this->Html->tag('li', $permitedUrl . $this->Html->tag('ul', $ret), array('class' => 'subNav'));
            }
        }

        return $this->Html->tag('ul', $output);
    }
    public function getTagColor($clickedMax, $clicked) {
        //obliczamy color
        $c = 34 - round((34 / $clickedMax) * $clicked);
        $color = (50 + $c) . ', ' . (100 + 2 * $c) . ', ' . (150 + 3 * $c);
        return $color;
    }
    public function reorganizeDataTree(&$data = array(), $_this, $f) {

        foreach ($data as $k => &$d) {
            $tmpChildren = $d['children'];
            $d = $d['ServicesCategory'];
            $d['children'] = $tmpChildren;
            $f(&$d, $_this);
            if (!empty($d['children'])) {
                $this->reorganizeDataTree($d['children'], $_this, $f);
            }
        }
    }

    
    /**
     *outputs a tick image according to the input value
     **/         
    function tick($val, $options=null, $return = false)
    {
        if($val === false) {
            $val = 0;
        }
        //$val = intval($val);
        if (empty($options['path']))
        {
            $options['path'] = 'icon/'; //.DS
        }
        if (empty($options['image']) || empty($options['ext']))
        {
            $options['image'] = 'tick';
            $options['ext'] = 'png';
        }
        $img = $options['path'].$options['image'].$val.'.'.$options['ext'];
        
        $htmlAttributes = array('alt'=>$img);
        
        return $this->output($this->Html->image($img, $htmlAttributes));
    }    
    
}

?>