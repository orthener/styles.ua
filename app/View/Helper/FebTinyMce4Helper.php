<?php

/**
 * Helper dla TinyMCE v 4.0+
 */

class FebTinyMce4Helper extends AppHelper {

    var $helpers = array('Form', 'Html', 'Js');
    var $_script = false;
    var $_readmoreMark = '<!-- readmore -->';

    /**
     * 
     * @param type $fieldName - nazwa pola
     * @param type $options - opcje HTML
     * @param type $preset - ustawienia wstępne dla TinyMCE
     * @param type $tinyoptions - tablica atrybutów TinyMCE dla pola tekstowego
     */
    public function input($fieldName, $options = array(), $preset = 'basic', $tinyoptions = array()) {
        $model = explode('.', $fieldName);
        $fieldName = isset($model[1]) ? $model['1'] : $fieldName;
        $model = isset($model[1]) ? $model['0'] : $this->Form->model();

        if (!empty($preset)) {
            $preset_options = $this->preset($preset);

            if (is_array($preset_options) && is_array($tinyoptions)) {
                $tinyoptions = array_merge($tinyoptions, $preset_options);
            } else {
                $tinyoptions = $preset_options;
            }
        }
        $options['type'] = 'textarea';
        $idTinyMce = isset($options['id']) ? $options['id'] : Inflector::camelize($model . "_" . $fieldName);
        return $this->Form->textarea($fieldName, $options) . $this->_build($idTinyMce, $tinyoptions);
    }

    /**
     * Funkcja generuje zestaw ustawień dla poszczególnych sytuacji
     * @param type $name - nazwa ustawienia
     * @return tablica parametrów, dla danego zestawu ustawień
     */
    private function preset($name) {
        if ($name == 'full') {
            return array(
                "language" => "pl",
                "plugins" => "image pagebreak link insertdatetime filemanager media code hr nonbreaking preview print table visualblocks template   " .
                             "advlist anchor charmap contextmenu emoticons fullscreen paste searchreplace textcolor visualchars directionality autolink",
                                "rel_list" => array(
                    array("title" => 'noFollow', "value" => 'nofollow')
                ),
                "toolbar1" => "print preview searchreplace | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
                "toolbar2" => "formatselect fontselect fontsizeselect removeformat subscript superscript",
                "toolbar3" => "hr nonbreaking | charmap insertdate inserttime | link unlink anchor | forecolor backcolor | emoticons image media | ltr rtl visualblocks visualchars pagebreak",
                "object_resizing" => true,
                'image_advtab' => true,
                'pagebreak_separator' => "<!-- pagebreak -->",
               // 'insertdatetime_element' => true,
               // 'insertdate_timeformat' => "%H:%M:%S",
               // 'insertdate_dateformat' => "%Y-%m-%d",
                "autosave_ask_before_unload" => false,
                "nonbreaking_force_tab" => true,
                "max_height" => 200,
                "min_height" => 150,
                "height" => 180,
                "convert_fonts_to_spans" => true,
                "font_size_style_values" => "xx-small,x-small,small,medium,large,x-large,xx-large, xxx-large",
                //"document_base_url" => WWW_ROOT,
                //"relative_urls" => true
            );
        }
        if ($name == 'basic') {
            return array(
                "language" => "pl",
                "plugins" => "code insertdatetime table template contextmenu fullscreen " .
                "hr link image charmap print preview anchor pagebreak searchreplace visualblocks visualchars code media nonbreaking directionality emoticons textcolor",
                "toolbar1" => "print preview searchreplace | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
                "toolbar2" => "formatselect fontselect fontsizeselect removeformat subscript superscript",
                "toolbar3" => "hr nonbreaking | charmap insertdate inserttime", 
                "object_resizing" => true,
                'image_advtab' => true,
                'pagebreak_separator' => "<!-- pagebreak -->",
               // 'insertdatetime_element' => true,
               // 'insertdate_timeformat' => "%H:%M:%S",
               // 'insertdate_dateformat' => "%Y-%m-%d",
                "autosave_ask_before_unload" => false,
                "nonbreaking_force_tab" => true,
                "max_height" => 200,
                "min_height" => 150,
                "height" => 180,
                "convert_fonts_to_spans" => true,
                "font_size_style_values" => "xx-small,x-small,small,medium,large,x-large,xx-large, xxx-large"
            );
        }
        if ($name == 'bbcode') {
            return array(
                "language" => "pl",
                "plugins" => "code insertdatetime table template contextmenu fullscreen " .
                "hr link image charmap print preview anchor pagebreak searchreplace visualblocks visualchars code media nonbreaking directionality emoticons textcolor",
                "toolbar1" => "print preview searchreplace | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
                "toolbar2" => "formatselect fontselect fontsizeselect removeformat subscript superscript",
                "toolbar3" => "hr nonbreaking | charmap insertdate inserttime",
                "object_resizing" => true,
                'image_advtab' => true,
                'pagebreak_separator' => "<!-- pagebreak -->",
               // 'insertdatetime_element' => true,
               // 'insertdate_timeformat' => "%H:%M:%S",
               // 'insertdate_dateformat' => "%Y-%m-%d",
                "autosave_ask_before_unload" => false,
                "nonbreaking_force_tab" => true,
                "max_height" => 200,
                "min_height" => 150,
                "height" => 180,
                "convert_fonts_to_spans" => true,
                "font_size_style_values" => "xx-small,x-small,small,medium,large,x-large,xx-large, xxx-large"
            );
        }
        if ($name == 'email') {
            return array(
                "language" => "pl",
                "plugins" => "code insertdatetime table template contextmenu fullscreen " .
                "hr link image charmap print preview anchor pagebreak searchreplace visualblocks visualchars code media nonbreaking directionality emoticons textcolor",
                "toolbar1" => "print preview searchreplace | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
                "toolbar2" => "formatselect fontselect fontsizeselect removeformat subscript superscript",
                "toolbar3" => "hr nonbreaking | charmap insertdate inserttime | link unlink anchor | forecolor backcolor | emoticons image media | ltr rtl visualblocks visualchars pagebreak",
                "object_resizing" => true,
                'image_advtab' => true,
                'pagebreak_separator' => "<!-- pagebreak -->",
               // 'insertdatetime_element' => true,
               // 'insertdate_timeformat' => "%H:%M:%S",
               // 'insertdate_dateformat' => "%Y-%m-%d",
                "autosave_ask_before_unload" => false,
                "nonbreaking_force_tab" => true,
                "max_height" => 200,
                "min_height" => 150,
                "height" => 180,
                "convert_fonts_to_spans" => true,
                "font_size_style_values" => "xx-small,x-small,small,medium,large,x-large,xx-large, xxx-large"
            );
        }
        return null;
    }

    /**
     * Funkcja generuje kod funkcji definiującej element TinyMCE
     * @param type $fieldName
     * @param type $tinyoptions
     * @return type
     */
    function _build($fieldName, $tinyoptions = array()) {
        if (!$this->_script) {
            $this->_script = true;
            $this->Html->script('tiny_mce4/js/tinymce/tinymce.min', array('inline' => false));
        }
        $thisTiny = $this->domId($fieldName);
        $baseOption['skin'] = 'lightgray';
        $baseOption['selector'] = '#' . $fieldName;

        $tinyoptions = array_merge($baseOption, $tinyoptions);
        $init = 'tinymce.init(' . $this->Js->object($tinyoptions) . ')';



        /* $tinyoptions['file_browser_callback'] = 'function() {
          }';
           */

        /* if (isset($tinyoptions['3_file_browser_callback'])) {
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
          tinyMCE.triggerSave();
          }";
          } */
        return $this->Html->scriptBlock($init);
    }

}

?>
