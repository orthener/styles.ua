<?php
/**
 * FebHtmlHeleper
 * @version 1.1
 * 
 * Changelog:
 * 1.1 - Dodanie metody upload
 * 
 */
class FebFormHelper extends AppHelper {

    var $helpers = array("Form", 'Html', 'Image.Image', 'Js');
    var $extImg = array('.jpg', '.png', '.gif', '.jpeg');

    function input($fieldName = null, $options= array()) {
        if (isset($options['type']) and $options['type'] == 'file') {
            return $this->file($fieldName, $options);
        }
        if (isset($options['type']) and $options['type'] == 'multiselect') {
            return $this->multiselect($fieldName, $options);
        }
        
        if (isset($options['type']) and $options['type'] == 'autocomplete') {
            return $this->autocomplete($fieldName, $options);
        }
        return $this->Form->input($fieldName, $options);
    }

    function file($fieldName, $options = array()) {
        $model = explode('.', $fieldName);
        $model = isset($model[1]) ? $model['0'] : $this->Form->model();
        $extOption = isset($options['ext']) ? $options['ext'] : false;
        unSet($options['ext']);

        if (isset($options['delete'])) {
            $delete = $options['delete'];
            unSet($options['delete']);
        }

        if (!isset($options['type'])) {
            $options['type'] = 'file';
        }
        if (!isset($options['label'])) {
            $options['label'] = false;
        }


        $input = $this->Form->input($fieldName, $options);
        $val = $this->Form->value($fieldName);

        if ($val && !is_array($val)) {
            $ext = strtolower(substr($val, -4));
            $url = '/files/' . strtolower($model) . '/' . $val;

            $input .= '<div class="zdjecieInput file clearfix">';
            $input .= '<label>&nbsp;</label>';

            if (($extOption === false and in_array($ext, $this->extImg)) or $extOption == 'image') {
                $input .= $this->Image->thumb($url, array('width' => 100, 'height' => 100), array('url' => $url));
            } else {
                $input .= $this->Html->link($val, $url);
            }

            $input .= '</div>';

            if (!isSet($delete)) {
                $input .= $this->Form->input($fieldName . '_delete', array('type' => 'checkbox', 'label' => __d('front', 'usuń plik')));
            } elseif ($delete !== false) {
                $input .= $delete;
            }
        }

        return $input;
    }
 
    /**
     * Helper tworzący inputowy multiselect - stosowany przeważnie dla powiązań szczególnie hasAndBelongsToMany
     * 
     * @param string $fieldName - Wymagane wpisanie pełnej ścieżki fieldu np: Competition.Competition dla powiązania obecnego modelu z modelem Competition
     * @param array
     *  'add' => array();
     *      --- Tablica inicjalizująca wygląd linku dodawnia kolejnego wpisu ( label = wyświetlany tekst ) reszta parametrów jak w options dla metody link w helperze Html
     *      --- Domyślnie może być pusta
     *  'delete' => array();
     *      --- Tablica inicjalizująca wygląd buttonu usuwania pól w formularzu ( label = wyświetlany tekst )
     *      --- Domyślnie może być pusta
     *  'label' => 'asd', 
     *      --- Wyświetlany label przed kazdym nowym inputem
     *  'class' => 'competition_autocomplete', 
     *      --- Metoda wymaga do prawidłowego działania wpisania klasy jaką będą miały formularze
     *  'options' => $competitions)
     *      --- W wersji 1.0 opcja nic nie robi
     * @param array $autocompleteOptions  --- Tablica inicjująca pola formularza więcej w dokumentacji metody autocomplete
     * @return string 
     * @author Sławomir Jach
     * @toDo Przycisk dodaj do konkurencji jezeli ta konkurencja nie istnieje ( ogólnie )
     * @version 1.0
     */
    function multiselect($fieldName, $options = array(), $autocompleteOptions = array()) {
                
        $fieldSelerated = explode('.', $fieldName);
        $model = isset($fieldSelerated[1]) ? $fieldSelerated['0'] : $this->Form->model();
        $fieldAutocompleteName = isSet($fieldSelerated[1]) ? $fieldSelerated[1] : $fieldName;

        //Opcje dla ukrytego inputa input[type=hidden]
        $optionsForHiddenInput = array();
        $optionsForHiddenInput['name'] = "data[{$model}][{$model}][]";
        $optionsForHiddenInput['id'] = false;

        $hiddenId = $this->Form->hidden("{$model}.{$model}", $optionsForHiddenInput);

        $addOptionLabel = isSet($options['add']['label']) ? $options['add']['label'] : __('Dodaj pole');
        if (isSet($addOption['class'])) {
            $addOption['class'] .= 'button addNew'.$fieldAutocompleteName;
        } else {
            $addOption['class'] = 'button addNew'.$fieldAutocompleteName;
        }
        
        $addOption['id'] = false;
        if (isSet($options['add'])) {
            $addOption = array_merge($options['add'], $addOption);
        }
        $addNew = $this->Html->link($addOptionLabel, array('#'), $addOption);

        $deleteLabel = isSet($options['delete']['label']) ? $options['delete']['label'] : __('X');
        if (isSet($deleteOption['class'])) {
            $deleteOption['class'] .= 'button deleteButton'.$fieldAutocompleteName;
        } else {
            $deleteOption['class'] = 'button deleteButton'.$fieldAutocompleteName;
        }
        
        $deleteOption['id'] = false;
        $deleteOption['type'] = 'button';
        if (isSet($options['delete'])) {
            $deleteOption = array_merge($options['delete'], $deleteOption);
        }
        $deleteButton = $this->Form->button($deleteLabel, $deleteOption);

        //Opcje dla wyświetlanego input[type=text]
        $optionsForInput = array();
        $optionsForInput['name'] = "data[_autocomplete][$model][]";
        $optionsForInput['id'] = false;
        $optionsForInput['type'] = 'text';

        if (!isSet($optionsForInput['after'])) {
            $optionsForInput['after'] = "";
        }

        $optionsForInput['after'] = $deleteButton . $hiddenId . $optionsForInput['after'];

        //$optionsForInput
        $optionsForInput = array_merge($options, $optionsForInput);

        $this->Html->script('feb-autocomplete', array('inline' => false));

        if (!isSet($autocompleteOptions['remoteSource'])) {
            $controller = Inflector::tableize($model);
            $autocompleteOptions['remoteSource'] = array('controller' => $controller, 'action' => 'autocomplete');
        }

        $url = Router::url($autocompleteOptions['remoteSource']);

        if (!isSet($autocompleteOptions['displayField'])) {
            $autocompleteOptions['displayField'] = 'name';
        }

        if (!isSet($autocompleteOptions['after'])) {
            $autocompleteOptions['after'] = "";
        }
        
        $autocompleteOptions['after'] = $deleteButton . $hiddenId . $autocompleteOptions['after'];

        $indexFormName = Inflector::camelize($fieldAutocompleteName);
        
        $autocompleteScript = "initAutocomplete(newAutocompleteInput, {
            url: '{$url}',
            model: '{$model}',
            displayField: '{$autocompleteOptions['displayField']}'
        }).bind('autocompleteselect', function(event, ui) {
            setChangeInput($(this).parent('div').find('input[type=hidden]'), '{$model}', ui.item.data.{$model}.{$autocompleteOptions['displayField']}); 
            if (typeof(afterSelect{$indexFormName}) == 'function') {
                afterSelect{$indexFormName}(ui.item.data);
            };
        }).change(function() {
            setChangeInput($(this).parent('div').find('input[type=hidden]'), '{$model}', $(this).val());
            if (typeof(afterSelect{$indexFormName}) == 'function') {
                afterSelect{$indexFormName}($(this).val());
            };
        });";

        $autocompleteOptions = array_merge($autocompleteOptions, $options);

        $autocompleteOptions['name'] = "data[_autocomplete][$model][]";

        $scriptInlineFalse = "<script type=\"text/javascript\">
                var clickDeleteInput{$fieldAutocompleteName} = function() {
                    if (typeof(beforeDeleteField{$fieldAutocompleteName}) == 'function') {
                        if (!beforeDeleteField{$fieldAutocompleteName}(this)) {
                            return false;
                        };
                    }
                    $(this).parent('div').remove();
                    if (typeof(afterDeleteField{$fieldAutocompleteName}) == 'function') {
                        afterDeleteField{$fieldAutocompleteName}(this);
                    }
                    return false;
                }
            </script>";

        $inputTemplate = $this->Form->input($fieldName, $optionsForInput);
        
        $deleteClass = 'deleteButton'.$fieldAutocompleteName;
        $addClass = 'addNew'.$fieldAutocompleteName;
        
        $scriptForActions = "<script type=\"text/javascript\">
            $(function(){
                var clickAdd{$fieldAutocompleteName} = function() {
                    if (typeof(beforeNewField{$fieldAutocompleteName}) == 'function') {
                        if (!beforeNewField{$fieldAutocompleteName}()) {
                            return false;
                        }
                    }
                    var newObject = $('{$inputTemplate}').insertBefore($(this));
                    var newDeleteButton = newObject.find('button').bind('click', clickDeleteInput$fieldAutocompleteName);  
                    var newAutocompleteInput = newObject.find('input[type=text]'); 
                    {$autocompleteScript}

                    
                    if (typeof(afterNewField{$fieldAutocompleteName}) == 'function') {
                        afterNewField{$fieldAutocompleteName}(newObject);
                    }
                    return false;
                }
                $('button.$deleteClass').click(clickDeleteInput$fieldAutocompleteName);
                $('a.$addClass').click(clickAdd{$fieldAutocompleteName});
            });
            </script>";

        $inputs = "";


        if (!empty($this->data['_autocomplete'][$model])) { //Przy akcji add
            foreach ($this->data['_autocomplete'][$model] as $key => $displayField) {
                $autocompleteOptions['value'] = $displayField;
                $autocompleteOptions['hiddenValue'] = $this->data[$model][$model][$key];
                $optionsForHiddenInput['value'] = $this->data[$model][$model][$key];

                $hiddenId = $this->Form->hidden("{$model}.{$model}", $optionsForHiddenInput);
                $autocompleteOptions['after'] = $deleteButton . $hiddenId;

                $input = $this->autocomplete($fieldName, $autocompleteOptions, false);

                $inputs .= $input;
            }
        } elseif (!empty($this->data[$model]) && is_array($this->data[$model])) {  //Przy akcji edit
            foreach ($this->data[$model] as $key => $value) {
                if (is_numeric($key)) {
                    $autocompleteOptions['value'] = $value[$autocompleteOptions['displayField']];
                    $autocompleteOptions['hiddenValue'] = $value['id'];
                    $optionsForHiddenInput['value'] = $value['id'];
                    $hiddenId = $this->Form->hidden("{$model}.{$model}", $optionsForHiddenInput);
                    $autocompleteOptions['after'] = $deleteButton . $hiddenId;
                    $input = $this->autocomplete($fieldName, $autocompleteOptions, false);
                    $inputs .= $input;
                }
            }
        } else {
            $inputs = $this->autocomplete($fieldName, $autocompleteOptions, false);
        }

        $output = $inputs . $addNew . $scriptInlineFalse . $scriptForActions;
        return $output;
//        
    }

    /**
     * Helper formularza, umożliwia uzyskanie automatycznych podpowiedzi składni
     * @param array $options = (
     *  'label' => __('Konkurencja kwalifikująca'), 
     *  'options' => $competitions, 
     *      --- Lista klucz->wartość dla wydobycia nazwy przy edycji pola
     *  'remoteSource' => array('controller' => 'competitions', 'action' => 'autocomplete'), 
     *      --- Link do kontrollera wyszukującego - domyślnie szuka w admin_/autocomplete kontrolera do którego przypisane jest pole
     *  'displayField' => 'full_name')
     *      --- Dowolne pole wysyłane do widoku z kontrolera
     * 
     * @example echo $this->FebForm->autocomplete('olympic_program_qualification_competition_id', $options);
     * @param string $fieldName
     * @param array $addHiddenInput
     * @return string 
     * @author Sławomir Jach
     * @version 1.0
     */
    function autocomplete($fieldName, $options = array(), $addHiddenInput = true) {
        $this->Html->script('feb-autocomplete', array('inline' => false));

        $initScript = "$(function(){
                $('form').submit(function(){
                    if ($(this).find('.autocomplete-error').length) {
                        alert('Formularz zawiera błędy!');
                        return false;
                    }
                });
            });";
   
        $this->Html->scriptBlock($initScript,array('inline' => false));

        $modelExplode = explode('.', $fieldName);
        $model = isset($modelExplode[1]) ? $modelExplode[0] : $this->Form->model();
        $fieldAutocompleteName = isSet($modelExplode[1]) ? $modelExplode[1] : $fieldName;

        isSet($options['autoModel'])?$modelFromField = $options['autoModel']:$modelFromField = $model;
        
        $controller = Inflector::tableize($modelFromField);
        
        if (!isSet($options['remoteSource'])) {
            
            $options['remoteSource'] = array('controller' => $controller, 'action' => 'autocomplete');
            $cacheIndex = $model;
        } else {
            if (!isSet($options['remoteSource']['controller'])) {
                return "USTAW KONTROLLER";
            }
            $cacheIndex = Inflector::classify($options['remoteSource']['controller']);
        }

        $url = Router::url($options['remoteSource']);

        if (!isSet($options['displayField'])) {
            $options['displayField'] = 'name';
        }

        if (!isSet($options['class'])) {
            return "NIE USTAWIONA KLASA";
        }
        
        if (empty($options['addNew'])) {
            $addNewStandardInput = $this->Html->link('Dodaj', array('controller' => $controller, 'action' => 'add'), array('target' => '_blank', 'class' => 'button', 'style' => 'display: none'));
        } elseif ($options['addNew'] === false) {
            $addNewStandardInput = "";
        } else {
             $addNewStandardInput = $options['addNew'];
        }
        
        $uniq = uniqid();
        
        $indexFormName = Inflector::camelize($fieldAutocompleteName);
        
        $script = "<script type=\"text/javascript\"> 
            $(function(){
                autocompleteCache['{$cacheIndex}'] = {};
                initAutocomplete($('.{$options['class']}'), {
                    url: '{$url}',
                    model: '{$cacheIndex}',
                    displayField: '{$options['displayField']}',
                    callback: function(data, tmpinpit) {
                        if(data.length > 0) {
                            $('.{$options['class']}').parent('div').find('a').hide('slow');
                        } else {
                            $('.{$options['class']}').parent('div').find('a').show('slow');
                        }
                    }
                }).bind('autocompleteselect', function(event, ui) {
                    setChangeInput($(this).parent('div').find('input[type=hidden]'), '{$cacheIndex}', ui.item.data.{$cacheIndex}.{$options['displayField']}); 
                    if (typeof(afterSelect{$indexFormName}) == 'function') {
                        afterSelect{$indexFormName}(ui.item.data);
                    };
                }).change(function() {
                        setChangeInput($(this).parent('div').find('input[type=hidden]'), '{$cacheIndex}', $(this).val());
                    if (typeof(afterSelect{$indexFormName}) == 'function') {
                        afterSelect{$indexFormName}($(this).val());
                    };
                });
            });         
        </script>";

        $options['type'] = 'text';

        $hiddenOptions['id'] = false;
        if (isSet($options['hiddenOptions'])) {
            $hiddenOptions = array_merge($hiddenOptions, $options['hiddenOptions']);
        }
        
        if (!empty($options['hiddenValue'])) {
            $hiddenOptions['value'] = $options['hiddenValue'];
        }

        $hiddenId = $this->Form->hidden($fieldName, $hiddenOptions);

        if (!isSet($options['after'])) {
            $options['after'] = "";
        }
        if ($addHiddenInput) {
            $options['after'] = $hiddenId . $options['after'];
        }
        if ($addNewStandardInput) {
            $options['after'] = $addNewStandardInput . $options['after'];
        }
        
        if (!empty($this->data[$model][$fieldAutocompleteName]) && !empty($options['options']) && !is_array($this->data[$model][$fieldAutocompleteName])) {
            $options['value'] = $options['options'][$this->data[$model][$fieldAutocompleteName]];
        }
        
		if (!isSet($options['field'])) {
			$input = $this->Form->input($model . '.' . $options['displayField'], $options);
		} else {
			$field = $options['field'];
			unSet($options['field']);
			$input = $this->Form->input($field, $options);
		}
        $output = $input . $script;
        return $output;
    }

    /**
     * Akcja do wysylania w wersji 1.0 zdjęć
     * 
     * @param type $model
     * @param type $remote_id
     * @param type $initParams
     * @param array $callbacks
     * @version 1.0
     * @return type 
     */
    public function upload($model, $remote_id, $initParams = array(), $callbacks = array(), $uploadUrl = null) {
        //Inicjalizacja skryptu
        $this->Html->script('fileuploader', array('inline' => false));
        $this->Html->css('fileuploader.css?20', null, array('inline' => false));
        //Inicjalizacja opcji
        $callbacks['onComplete'] = isSet($callbacks['onComplete'])?$callbacks['onComplete']:'';
        //$initParams['progresBar'] = isSet($initParams['progresBar'])?$initParams['progresBar']:$this->Html->div('progressbar', '', array('id' => $initParams['progresBarId'] = 'progressbar'));;
        $initParams['fileUploader'] = isSet($initParams['fileUploader'])?$initParams['fileUploader']:$this->Html->div('fileUploader', '', array('id' => $initParams['fileUploaderId'] = 'fileUploader'));
        $initParams['photoSpan'] = isSet($initParams['photoSpan'])?$initParams['photoSpan']:$this->Html->div('photoSpan', $toDisplayPhotos, array('id' => $initParams['photoSpanId'] = 'photoSpan'));

        if(empty($uploadUrl)){
        $uploadUrl = $this->Html->url(array('admin' => false,'controller' => 'photos', 'action' => 'upload', $model, $remote_id));
        }
                
        $initScript = "$(function(){
                //$( '#{$initParams['progresBarId']}' ).progressbar();
                
                new qq.FileUploader({
                        element: document.getElementById('{$initParams['progresBarId']}'),
                        action: '{$uploadUrl}',
                        debug: false,
                        sizeLimit: 3300000,   
                        allowedExtensions: ['jpg', 'png', 'gif', 'psd', 'jpeg'],   
                        onSubmit: function(id, fileName){
                            //$( '#{$initParams['progresBarId']}' ).progressbar('enable').progressbar('value', 0);
                        },
                        onProgress: function(id, fileName, loaded, total){                    
                            //if (loaded/total*100 < 100) {
                            //    $( '#{$initParams['progresBarId']}' ).progressbar('value', loaded/total*100);
                            //}
                        },
                        {$callbacks['onComplete']},
                        onCancel: function(id, fileName){
                            //$( '#{$initParams['progresBarId']}' ).progressbar('value', 0).hide();
                        },
                        messages: {
                            typeError: '{file} posiada nieakceptowalne rozszerzenie. Tylko pliki {extensions} sa akceptowalne.',
                            sizeError: '{file} plik jest za duzy, akceptowalna wielkosc do {sizeLimit}.',
                            minSizeError: '{file} is too small, minimum file size is {minSizeLimit}.',
                            emptyError: '{file} plik nie moze byc pusty.',
                            onLeave: 'Plik jest aktualnie wysylany, wyjscie spowoduje utrate danych.'            
                        }
                    });
            });";
   
        $script = $this->Html->scriptBlock($initScript, array('inline' => true));
                
        return $initParams['progresBar'].$initParams['fileUploader'].$initParams['photoSpan'].$script;
        
    }
    
}


?>
