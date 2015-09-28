<?php 
/**
 * Model Behavior to support AydFiles from model.
 * 
 *  przykład użycia:
 *  var $actsAs = array(
 *     'Upload'=>array('maxFileSize'=>3145738, 'imageOptions'=>array('size'=>array('width'=>1920, 'height'=>1200))),
 *  );
 *  
 *  Opis: 
 *  maxFileSize - maksymalny rozmiar pliku; jesli nie ustawiony, to brana jest pod uwage opcja konfiguracyjna (bootstrap) UploadMaxFileSize
 *  imageOptions[size] - maksymalny rozmiar pliku; jesli nie ustawiony, to brala jest pod uwage opcja konfiguracyjna (bootstrap) UploadMaxImageDimensions
 *    
 *  przykład walidacji:
 *  var $validate = array(
 *      'photo_img' => array(
 *          'mime'=>array(
 *              'rule'=>array('validateMime','image')
 *          ),
 *          'upload'=>array(
 *              'rule'=>'validateUpload','required'=>true, 'allowEmpty'=>false
 *          )
 *      )
 *  );
 *
 *  Opis: 
 *  'validateMime' - dozwolone typy mime ('image', tablica typów, lub wyrazenie regularne)
 *  'validateUpload' - walidacja uploadu pliku, (opcje jak w standardowej walidacji cake)
 *
 *  dodatkowy wymagany kod:
 *  function save(&$data, $validate = true, $fieldList = array()){
 *      if(parent::save($data, $validate, $fieldList)){
 *          return true;
 *      }
 *      $data = $this->data;
 *      return false;
 *  }
 *
 * @filesource
 * @package    app
 * @subpackage    models.behaviors
 */


 
class UploadBehavior extends ModelBehavior {
     
    var $invalidFields = array();
    var $uploadFields = array();
    var $settings = array();

    /**
     * Initiate behaviour for the model using settings.
     *
     * @param object $model    Model using the behaviour
     * @param array $settings    Settings to override for model.
     *
     * @access public
     */
    function setup(&$model, $settings = array()) {
        $default = array('maxFileSize'=>null, 'imageOptions'=>null);
        if (!isset($this->settings[$model->alias])) {
            $this->settings[$model->alias] = $default;
        }
        $settings = is_array($settings)?$settings:array();
        $this->settings[$model->alias] = array_merge($this->settings[$model->alias], $settings);
        if($this->settings[$model->alias]['maxFileSize'] === null && Configure::read('App.AutoSetUploadMaxFileSize')){
            $this->settings[$model->alias]['maxFileSize'] = Configure::read('App.UploadMaxFileSize');
        }
    }


    //ta funkcja tylko sprawdza wyniki z beforeValidate (prawdziwa walidacja odbwa się tam)
    function validateUpload(&$model, $variable, $params){
        if(!is_array($variable)){
            //$variable powinna byc tablica, ale na wszelki wypadek...
            debug('UploadBehavior->validateUpload()');
            return false;
        }
            
        foreach($variable AS $variableName => $variableValue){
        //jesli w before validate wykrylismy ze pole jest nieprwidlowe, to tu tylko to oglaszamy
            if (in_array($variableName, $this->invalidFields)) {
                if(!empty($model->data[$model->alias][$model->primaryKey])){
                    $data = $model->find('first', array('conditions'=>array($model->alias.'.'.$model->primaryKey => $model->data[$model->alias][$model->primaryKey])));
                    $model->data[$model->alias][$variableName] = $data[$model->alias][$variableName];
                } else {
                    $model->data[$model->alias][$variableName] = '';
                }
                return false;
            }
        }
        return true;
    }

    function validateMime(&$model, $variable, $params){
        $valid = true;
        if(!is_array($variable)){
            debug('UploadBehavior->validateMime()');
            return false;
        }
        if(is_array($params) && !empty($params['allowType'])){
            $allowType = $params['allowType'];
            $params = null;
        } else {
            $allowType = $params;
        }        
        foreach($variable AS $variableName => $variableValue){
//debug($variableValue['type']);exit;        	
            if(empty($variableValue['type'])){
                //can not read mime type
                //$valid = false;
            } elseif($allowType === 'image' || $allowType === 'images'){
                //dozwolony typ to obrazki - korzystamy z predefiniowanego wyrazenia regularnego
                if(!preg_match('/^image\/(pjpeg|jpeg|jpg|png|gif|x-png)$/', $variableValue['type'])){
                    $valid = false;
                }
            } elseif(is_array($params)){
                //parametr jest tablicą - sprawdzamy czy typ mime pliku sie w niej znajduje
                if(!in_array($variableValue['type'], $params)){
                    $valid = false;
                }
            } else {
                //parametr jest traktowany jako wyrazenie regularne
                if(!preg_match($allowType, $variableValue['type'])){
                    $valid = false;
                }
            }
            if(!$valid){
                //sprawdz, czy to jest edycja istniejacego obiektu, 
                //jesli tak pobierz poprzednie dane, aby nadlisac 
                //tablice danych o pliku (pobrana z $_FILE) poprzednia wartoscia 
                //z bazy danych (do ponownego wyswietlenia podglądu w formularzu)
                if(!empty($model->data[$model->alias][$model->primaryKey])){
                    //$tempModel = new $model->alias();
                    $data = $model->find('first', array('conditions'=>array($model->alias.'.'.$model->primaryKey => $model->data[$model->alias][$model->primaryKey])));
                    $model->data[$model->alias][$variableName] = $data[$model->alias][$variableName];
                } else {
                    $model->data[$model->alias][$variableName] = '';
                }
                return false;
            }
        }
        return true;
    }


    function beforeValidate(&$model){
        if(empty($model->validate)){
            //nie przeprowadzamy walidacji
            return true;
        }
        foreach($model->validate AS $fieldName => $ruleSet){

            //dopasowanie wykonania, do konfiguracji w modelu:
            $singleRule = false;
            if(!is_array($ruleSet) || isset($ruleSet['rule'])) {
                $ruleSet = array($ruleSet);
                $singleRule = true;
            } 

            //wykonanie walidacji dla kazdego pola
            foreach($ruleSet AS $index => $validator){

                //dopasowanie wykonania, do konfiguracji w modelu:
                if (!is_array($validator)) {
                    $validator = array('rule' => $validator);
                }
                if(empty($validator['rule'])){
                    continue;
                }
                if (is_array($validator['rule'])) {
                    $rule = $validator['rule'][0];
                } else {
                    $rule = $validator['rule'];
                }
                if($rule != 'validateUpload'){
                    //jesli to nie jest regula 'validateUpload' - to nie sprawdzamy jej tutaj
                    continue;
                }

                //dodanie sprawdzanego pola do tablicy $this->uploadFields
                $this->uploadFields[] = $fieldName;

                //konfiguracja ustawień walidacji
                $last = (isSet($validator['last']))?$validator['last']:false;
                $required = (isSet($validator['required']))?$validator['required']:false;
                $allowEmpty = null;
                $allowEmpty = (!empty($validator['allowEmpty']))?$validator['allowEmpty']:true;
                $fieldValue = isSet($model->data[$model->alias][$fieldName])?$model->data[$model->alias][$fieldName]:null;
                $maxFileSize = $this->settings[$model->alias]['maxFileSize'];
                $maxImageSize = null;

                $error = false;
                //walidacja poprawności wysłania pliku
                $error = $this->areUploadErrors($fieldValue, $required, $allowEmpty, $maxFileSize);

                if(!$error){
                    if($maxFileSize !== null){
                        //walidacja rozmiaru wg konfiguracji
                        if(isSet($fieldValue['size']) AND $fieldValue['size'] > $maxFileSize){
                            $error = __d('cms', "Tym formularzem nie można wysłać pliku większego niż ".(round($maxFileSize/1024/1024*100)/100)." MB. Zmniejsz plik lub wybierz inny.");
                        }
                    }

                    //czy sprawdzać wymiary pliku
                    if($this->settings[$model->alias]['imageOptions'] or Configure::read('App.AutoSetUploadMaxImageDimensions') && $this->settings[$model->alias]['imageOptions'] !== false){
                        $maxImageSize = empty($this->settings[$model->alias]['imageOptions']['maxImageSize'])?Configure::read('App.UploadMaxImageDimensionsAllowed'):$this->settings[$model->alias]['imageOptions']['maxImageSize'];
                    }

                    if(!$error and $maxImageSize !== null){
                        //sprawdzenie rozmiaru wysyłanego pliku
                        $size = @getimagesize($fieldValue['tmp_name']);
                        //jesli nie udalo sie przeczytac rozmiaru zakładamy, ze to nie jest obrazek i nie wykonujemy sprawdzenia (zeby nie zablokowac przypadkowo pliku innego typu)
                        if(!empty($size) and ($size[0] > $maxImageSize['width'] || $size[1] > $maxImageSize['height'])){
                            $error = __d('cms', "Tym formularzem nie można wysłać obrazka większego niż {$maxImageSize['width']}px x {$maxImageSize['height']}px");
                        }
                    }

                }
                if($error){
                    //jesli walidacja nie powiodla sie
                    $validator['message'] = $error;
                    //dodanie pola do tablicy $this->invalidFields
                    $this->invalidFields[] = $fieldName;
                    if($singleRule){
                        $model->validate[$fieldName] = $validator;
                    } else {
                        $model->validate[$fieldName][$index] = $validator;
                    }
                    if($last){
                        break;
                    }
                }
                continue;
            }
        }
        return true;
    }



    function beforeSave(&$model){
            //    debug($model->data); 
        //sprawdz, czy to jest edycja istniejacego obiektu, 
        //jesli tak pobierz poprzednie dane
        if(!empty($model->data[$model->alias][$model->primaryKey])){
            $primaryKey = $model->data[$model->alias][$model->primaryKey];
            $tempModelData = $model->find('first', array('conditions'=> array($model->alias.'.'.$model->primaryKey => $primaryKey)));
        }

        //wykonane dla kazdego pola w modelu
        foreach($model->data[$model->alias] AS $field => $value){
            if(!empty($this->uploadFields)){
                //jesli tablica $this->uploadFields istnieje - pomin pola spoza tablicy
                if(!in_array($field, $this->uploadFields)){
                    continue;
                }
            } elseif(!isSet($model->_schema[$field]['type']) || $model->_schema[$field]['type'] != 'string' || !is_array($value) || !isSet($value['name'])){
                //w przeciwnym razie pomin pole jesli: pole modelu nie jest typu string, lub dane aktualne to nie tablica
                continue;
            }
            //sprawdz czy byly bledy wysylania pliku
            $uploadErrors = ($this->areUploadErrors($value, true))?true:false;
            if(!$uploadErrors){
                //jesli nie, zapisz plik
                $model->data[$model->alias][$field] = $this->_saveFile($value, $model->alias);
                if($model->data[$model->alias][$field] == false && !empty($tempModelData[$model->alias][$field])){
                    unset($model->data[$model->alias][$field]);
                }
            } else {
                    unset($model->data[$model->alias][$field]);
            }
            //debug($model->data); exit;
            
            //jesli w tym polu wczesniej istnial plik i: aktualnie wysylany idzie bez bledow, albo zostalo wyznaczone pole usunięcia pliku - usun go;
            
            if(!empty($tempModelData[$model->alias][$field]) && (!$uploadErrors || (!empty($model->data[$model->alias][$field.'_delete']) && $model->data[$model->alias][$field.'_delete'] == 1))){
                $deleted = $this->_deleteFile($tempModelData[$model->alias][$field], $model->alias);
                //jesli usunie
                if($deleted && (!empty($model->data[$model->alias][$field.'_delete']) && $model->data[$model->alias][$field.'_delete'] == 1) && $uploadErrors){
                    $model->data[$model->alias][$field] = '';
                }
            }
        }
        
        return true;
    }

    /**
     *         
     * Run before a model is deleted, used to delete files while model deleting.
     *
     * @param object $model    Model about to be deleted.
     *
     * @access public
     */
    function beforeDelete(&$model) {
        $primaryKey = $model->primaryKey;
        $model->data = $model->find('first', array('conditions'=> array($model->alias.'.'.$primaryKey => $model->$primaryKey)));

        $return = true;

        //wywołanie kodu usunięcia plików dla każdego pola które potencjalnie może przechowywać dane o pliku
        foreach($model->data[$model->alias] AS $field => $value){
            if(isSet($model->_schema[$field]['type']) && $model->_schema[$field]['type']=='string'){
                $return = $return & $this->_deleteFile($value, $model->alias);
            }
        }
        
        //czy powstrzymywac usuniecie rekordu, jesni nie udalo sie usunac jednego z plikow (co jesli inne udalo sie usunac)?
        //return $return;
        return true;
    }


    /**
     *         
     * Funkcja zapisuje uploadowany plik do właściwego dla modelu katalogu
     *
     * @param object $array        Dane o pliku do zapisania
     *      
     * @param object $modelName    Nazwa modelu
     */
    function _saveFile($array, $modelName){
        $destDir = WWW_ROOT.'files'.DS.strtolower($modelName);
        if(!file_exists($destDir)){
            @mkdir($destDir, 0777);
            @chmod($destDir, 0777);
        }
        if(!is_writable($destDir) || !is_dir($destDir)){
            debug("Error: $destDir is not writable or is not a dir.");
            return false;
        }
        
        $array['name'] = $this->_normalizeFileName($array['name']);

        $destPath = $this->_getUniqueFileName($destDir.DS.$array['name']);
        
        if(move_uploaded_file($array['tmp_name'], $destPath)){
            @chmod($destPath, 0666);
            $pathinfo = pathinfo($destPath);
            return $pathinfo['basename'];
        }
        return false;
    }

    /**
     *         
     * Funkcja usuwa plik właściwy dla danego pola modelu
     *
     * @param object $name        Potencjalna nazwa pliku
     *      
     * @param object $modelName    Nazwa modelu
     */
    function _deleteFile($name, $modelName){
        $destDir = WWW_ROOT.'files'.DS.strtolower($modelName);
        $filePath = $destDir.DS.$name;

        if (!file_exists($filePath)){ return true; }
        if (!is_file($filePath)){ return false; }
        
        // check folders with thumbs
        $readed = scandir($destDir);
        
        // delete thumbs from folders
        foreach($readed as $dir) {
            if(!is_dir($destDir.DS.$dir)){
                continue;
            }
            $thumbPath = $destDir.DS.$dir.DS.$name;    

            @chmod ($thumbPath, 0666);
            @unlink($thumbPath);
            @passthru("del $thumbPath /q");
        }
        
        $delete = false;
        $delete = $delete | @chmod ($filePath, 0666);
        $delete = $delete | @unlink($filePath);
        $delete = $delete | @passthru("del $filePath /q");
        
        return $delete;
    }


    function error($message, $file = '' , $line = ''){
        echo "<h3>Error</h3><p>Error in file <strong>$file</strong> (line <strong>$line</strong>).\n<br />Details: $message</p>";
    }

    /**
     *         
     * Funkcja zwraca łańcuch $srcName pozbawiony znaków, 
     * które mogłyby nie zostać zakceptowane przez system plików, 
     * lub sprawiać trudność przy wysyłaniu do przeglądarki
     *
     * @param object $srcName     Potencjalna nazwa pliku
     *      
     */
    function _normalizeFileName($srcName) {
        $srcName = substr($srcName, 0, 250);

        $trans = array('ª'=>'a', 'º'=>'o', 'µ'=>'u', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 
                       'Ä'=>'A', 'Ą'=>'A', 'Ç'=>'C', 'Ć'=>'C', 'È'=>'E', 'É'=>'E', 
                       'Ë'=>'E', 'Ę'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'I'=>'I', 
                       'Ł'=>'L', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 
                       'Ö'=>'O', 'Ś'=>'S', 'Ù'=>'U', 'Ú'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 
                       'Ż'=>'Z', 'Ź'=>'Z', 'ß'=>'ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 
                       'ä'=>'a', 'ą'=>'a', 'ç'=>'c', 'ć'=>'c', 'è'=>'e', 'é'=>'e', 
                       'ë'=>'e', 'ę'=>'e', 'í'=>'i', 'î'=>'i', 'i'=>'i', 'ł'=>'l',
                       'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'ö'=>'o', 
                       'ś'=>'s', 'ù'=>'u', 'ú'=>'u', 'ü'=>'u', 'ý'=>'y', 'ż'=>'z', 
                       'ź'=>'z', ' ');
        /*
        $srcName=strtr( $srcName,
            "ªºµÀÁÂÄÇÈÉËÌÍÎIÑÒÓÔÖÙÚÜÝßàáâäçèéëíîiñòóôöùúüý",
            "aouAAAACEEEIIIINOOOOUUUYsàaaaceeeiiinoooouuuy"); 
        /**/
                        
        $srcName = strtr($srcName, $trans);
        //taken from moodle
        $srcName = preg_replace('/\.\.+/','.', $srcName);

        //$string = preg_replace('/[^\.a-zA-Z\d\_-]/','_', $string ); // only allowed chars
        $srcName = preg_replace('/[^[:alnum:]\.-]/','_', $srcName ); // only allowed chars **but not only english**

        //$srcName = eregi_replace(_+, _, $string);
        $srcName = strtolower($srcName);
    
        return $srcName; 
    }


    /**
     *         
     * Funkcja sprawdza czy łańcuch $destPath jest unikalną ścieżką w systemie plików
     * i zwraca inną wolną nazwę, jeśli podana jest zajęta
     *
     * @param object $destPath     Potencjalna scieżka do pliku
     *      
     */
    function _getUniqueFileName($destPath) {
        $pathinfo = $this->pathinfo($destPath);
        
        $i = 1;
        while(file_exists($destPath)){
            $destPath = $pathinfo['dirname'].DS.$pathinfo['filename'].'_'.($i++).'.'.$pathinfo['extension'];
        }
        return $destPath;
    }
    
    /**
     * Get full pathInfo array: dirname, basename, extension, filename
     * 
     * @param object $path    Path to extract.
     *
     * @access public
     */
    function pathinfo($path){
        $pathinfo = pathinfo($path);
        if(!isSet($pathinfo['filename'])){
            // before PHP 5.2.0
            $extLen = strlen($pathinfo['extension']);
            $pathinfo['filename'] = substr($pathinfo['basename'], 0, -($extLen+1));
        }
        return $pathinfo;
    }

    /**
     *         
     * Funkcja sprawdza czy plik został poprawnie wysłany na serwer.
     *
     * @param array $array - tablica danych o pliku (jak w $_FILES)
     * 
     * @param boolean $required - czy obecność pliku jest wymagana
     * 
     * @param boolean $allowEmpty - czy wysłany plik może być pusty
     * 
     * @param int $maxFileSize - maksymalny rozmiar pliku w bajtach, 
     *      (ta sama wartość jaka została ustawiona w formularzu wysyłania pliku
     *      - zmienna podawana tylko do tresci komunikatu błedu, w przypadku UPLOAD_ERR_FORM_SIZE)
     * 
     * @return : 
     *      boolean false - jeśli nie znalezino błędu,
     *      string - komunikat błędu, jeśli został wykryty błąd
     * 
     */
    function areUploadErrors($array, $required = false, $allowEmpty = true, $maxFileSize = null){
        if(!$required){
            if(empty($array)){
                if($allowEmpty){
                    return false;
                }
            } elseif(empty($array['name']) && empty($array['tmp_name']) && isSet($array['error']) && $array['error'] == UPLOAD_ERR_NO_FILE){
                if($allowEmpty){
                    return false;
                }
            }
        
        }
        if($required && (empty($array['name']) || empty($array['tmp_name'])) && (!isSet($array['error']) || $array['error'] == UPLOAD_ERR_OK)){
            return __d('cms', "Nie wysłano pliku.");
        } elseif(isSet($array['size']) && $array['size'] == 0 && !$allowEmpty) {
            return __d('cms', "Wysyłany plik nie może być pusty");
        } else {
            switch($array['error']){
                //// TODO:
                // Uczynić informacje bardziej przyjaznymi
                case UPLOAD_ERR_OK:
                    return false;
                case UPLOAD_ERR_INI_SIZE:
                    return __d('cms', "Maksymalny dopuszczalny rozmiar pliku na tym serwerze to ".ini_get('upload_max_filesize'));
//                    return __d('cms', "The uploaded file exceeds the upload_max_filesize directive in php.ini.");
                case UPLOAD_ERR_FORM_SIZE:
                    //return __d('cms', "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.");
//                    debug(MAX_FILE_SIZE); exit; //{$this->settings[$model->alias]['maxFileSize']}
                    return ($maxFileSize)?__d('cms', "Tym formularzem nie można wysłać pliku większego niż ".(round($maxFileSize/1024/1024*100)/100)." MB. Zmniejsz plik lub wybierz inny."):__d('cms', "Tym formularzem nie można wysłać pliku tej wielkości");
                case UPLOAD_ERR_PARTIAL:
                    return __d('cms', "The uploaded file was only partially uploaded.");
                case UPLOAD_ERR_NO_FILE:
                    return __d('cms', "Nie wysłano pliku.");
                case UPLOAD_ERR_NO_TMP_DIR:
                    return __d('cms', "Missing a temporary folder.");
                case UPLOAD_ERR_CANT_WRITE:
                    return __d('cms', "Failed to write file to disk.");
                case UPLOAD_ERR_EXTENSION:
                    return __d('cms', "File upload stopped by extension.");
                default:
                    return __d('cms', "Unknown exception while file upload");
            }
        }
    }

    function afterSave (&$model, $created){

        //przeskalowanie pliku po zapisaniu wg konfiguracji w bootstrap.php lub w modelu

        if($this->settings[$model->alias]['imageOptions'] or Configure::read('App.AutoSetUploadMaxImageDimensions') && $this->settings[$model->alias]['imageOptions'] !== false){
            $size = isSet($this->settings[$model->alias]['imageOptions']['size'])?$this->settings[$model->alias]['imageOptions']['size']:Configure::read('App.UploadMaxImageDimensions');
            unSet($this->settings[$model->alias]['imageOptions']['size']);
            $params = $this->settings[$model->alias]['imageOptions'];
            $params = is_array($params)?$params:null;
            if(!isSet($this->image)){
                App::import('Vendor','Image.image/Image');
                $this->image = new Image();
            }
            foreach($this->uploadFields AS $fieldName){
                if(!empty($model->data[$model->alias][$fieldName])) {
                    $fileNameSrc = strtolower($model->alias).DS.$model->data[$model->alias][$fieldName];
                    $this->image->resizeImage($fileNameSrc, $size, $params);
                }
            }
        }
    }    
    
}
?>