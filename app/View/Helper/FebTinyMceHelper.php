<?php

class FebTinyMceHelper extends AppHelper {

    // Take advantage of other helpers 
    var $helpers = array( 'Js' => array('Jquery'), 'Form', 'Html');
    // Check if the tiny_mce.js file has been added or not 
    var $_script = false;

    var $_readmoreMark = '<!-- readmore -->';
    
    /**
     * Adds the tiny_mce.js file and constructs the options 
     * 
     * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated 
     * @param array $tinyoptions Array of TinyMCE attributes for this textarea 
     * @return string JavaScript code to initialise the TinyMCE area 
     */
    function _build($fieldName, $tinyoptions = array()) {
        if (!$this->_script) {
            // We don't want to add this every time, it's only needed once 
            $this->_script = true;
            $this->Html->script('tiny_mce/jquery.tinymce', array('inline'=>false));
        }
        // Ties the options to the field 
        $thisTiny = $this->domId($fieldName);
        $jQueryObject = '$("#' . $thisTiny . '")';
        
        
        $baseOption['skin'] = 'o2k7';
        $baseOption['gecko_spellcheck'] = true;

        $baseOption['spellchecker_languages'] = "+Polish=pl,English=en";
        $baseOption['skin_variant'] = 'silver';
        $baseOption['language'] = 'pl';
        $baseOption['content_css'] = $this->Html->url('/css/tinymce.css');
        $baseOption['script_url'] = $this->Html->script('/js/tiny_mce/tiny_mce', array('inline'=>false));

        $tinyoptions = array_merge($baseOption, $tinyoptions);
//        debug($tinyoptions);
//                    
        $init = '$(function(){' . $jQueryObject . '.tinymce(' . $this->Js->object($tinyoptions) . ')});';
        //Dodaje Funkcje do Ajaxowego wybierania obrazków
        
        if (isset($tinyoptions['file_browser_callback'])) {
            $urlThumb = $this->Html->url('/',true).'js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?language=pl&view=thumbnail';
            $init .= "
            function ajaxfilemanager(field_name, url, type, win) {
                tinyMCE.activeEditor.windowManager.open({
                    url: '{$urlThumb}',
                    inline : 'yes',
                    close_previous : 'no',
                    width: 782,
                    height: 440,
                },{
                    window : win,
                    input : field_name
                });
            }";
        }
        return $this->Html->scriptBlock($init);
    }

    /**
     * Creates a TinyMCE textarea. 
     * 
     * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
     * @param array $options Array of HTML attributes. 
     * @param array $tinyoptions Array of TinyMCE attributes for this textarea 
     * @return string An HTML textarea element with TinyMCE 
     */
    function textarea($fieldName, $options = array(), $tinyoptions = array(), $preset = null) {
        // If a preset is defined 
        if (!empty($preset)) {
            $preset_options = $this->preset($preset);

            // If $preset_options && $tinyoptions are an array 
            if (is_array($preset_options) && is_array($tinyoptions)) {
                $tinyoptions = array_merge($tinyoptions, $preset_options);
            } else {
                $tinyoptions = $preset_options;
            }
        }
        return $this->Form->textarea($fieldName, $options) . $this->_build($fieldName, $tinyoptions);
    }

    /**
     * Creates a TinyMCE textarea. 
     * 
     * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
     * @param array $options Array of HTML attributes. 
     * @param array $tinyoptions Array of TinyMCE attributes for this textarea 
     * @return string An HTML textarea element with TinyMCE 
     */
    function input($fieldName, $options = array(), $preset = 'basic', $tinyoptions = array()) {
        // If a preset is defined 
        $model = explode('.',$fieldName);
        $fieldName = isset($model[1])?$model['1']:$fieldName;
        $model = isset($model[1])?$model['0']:$this->Form->model();

        if (!empty($preset)) {
            $preset_options = $this->preset($preset);

            // If $preset_options && $tinyoptions are an array 
            if (is_array($preset_options) && is_array($tinyoptions)) {
                $tinyoptions = array_merge($tinyoptions, $preset_options);
                //debug($tinyoptions);
            } else {
                $tinyoptions = $preset_options;
            }
        }
        $options['type'] = 'textarea';
        $idTinyMce = isset($options['id'])?$options['id']:Inflector::camelize($model.'_'.$fieldName);
        return $this->Form->input($fieldName, $options) . $this->_build($idTinyMce, $tinyoptions);
    }

    /**
     * Creates a preset for TinyOptions 
     *  
     * @param string $name 
     * @return array 
     */
    private function preset($name) {
        // Full Feature 
        if ($name == 'full') {
            return array(
                'theme' => 'advanced', 
                'plugins' => 'iframe,readmore,spellchecker,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
                'theme_advanced_buttons1' => 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
                'theme_advanced_buttons2' => 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
                'theme_advanced_buttons3' => 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
                'theme_advanced_buttons4' => 'insertlayer,moveforward,spellchecker,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,readmore,|,iframe',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_statusbar_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'theme_advanced_resize_horizontal' => false,
                'convert_fonts_to_spans' => true,
                'file_browser_callback' => 'ajaxfilemanager',
                'extended_valid_elements' => 'iframe[align<bottom?left?middle?right?top|class|frameborder|height|id|width|src|scrolling|marginheight|marginwidth',
                'template_external_list_url'=> $this->Html->url('/js/tiny_mce/template/list_option.js',true)
            );
        }
        // Basic 
        if ($name == 'basic') {
            return array(
                'theme' => 'advanced',
                'plugins' => 'readmore,spellchecker,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_statusbar_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'theme_advanced_resize_horizontal' => false,
                'convert_fonts_to_spans' => true
            );
        }
        // BBCode 
        if ($name == 'bbcode') {
            return array(
                'theme' => 'advanced',
                'plugins' => 'bbcode',
                'theme_advanced_buttons1' => 'bold,italic,underline,undo,redo,link,unlink,image,forecolor,styleselect,removeformat,cleanup,code,|,readmore',
                'theme_advanced_buttons2' => '',
                'theme_advanced_buttons3' => '',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_styles' => 'Code=codeStyle;Quote=quoteStyle',
                'theme_advanced_statusbar_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'theme_advanced_resize_horizontal' => false,
                'entity_encoding' => 'raw',
                'add_unload_trigger' => false,
                'remove_linebreaks' => false,
                'inline_styles' => false
            );
        }
        // IMG 
        if ($name == 'image') {
            return array(
                'theme' => 'advanced',
                'plugins' => 'readmore,spellchecker,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
                'theme_advanced_buttons1' => 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontsizeselect',
                'theme_advanced_buttons2' => 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code',
                'theme_advanced_buttons3' => 'tablecontrols,|,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print',
                'theme_advanced_buttons4' => 'insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,blockquote,|,insertdate,inserttime,|,forecolor,backcolor,|,fullscreen,|,readmore',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_path_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'file_browser_callback' => 'ajaxfilemanager',
                'relative_urls' => false
            );
        }
        // Email 
        if ($name == 'email') {
            return array(
                'theme' => 'advanced',
                'plugins' => 'readmore,spellchecker,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
                'content_css' => $this->Html->url('/css/email.css'),
                'theme_advanced_buttons1' => 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontsizeselect',
                'theme_advanced_buttons2' => 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code',
                'theme_advanced_buttons3' => 'tablecontrols,|,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print',
                'theme_advanced_buttons4' => 'insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,blockquote,|,insertdate,inserttime,|,forecolor,backcolor,|,fullscreen,|,readmore',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_path_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'file_browser_callback' => 'ajaxfilemanager',
                'relative_urls' => false,
                'remove_script_host' => false,
                'convert_urls' => false
            );
        }
        return null;
    }
    
	function readmore($text, $length = 100, $options = array()) {
        if(($pos = strpos($text, $this->_readmoreMark)) === false){
            if(empty($options['html'])){
                $text = strip_tags($text);
            }
            return $this->Text->truncate($text, $length, $options);
        }
        $text = substr($text, 0, $pos);
        if(empty($options['html'])){
            $text = strip_tags($text);
        }
        if(!empty($options['forceTruncate'])){
            return $this->Text->truncate($text, $length, $options);
        }
        return $text;
    }

}
?>