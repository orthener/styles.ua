<?php
/**
 * I18n preconfiguration component class
 *
 */
App::uses('I18n', 'I18n');
//App::uses('L10n', 'I18n');
 class FebI18nComponent extends Object {

    /**
     * Other components utilized by PermissionsComponent
     *
     * @var array
     * @access public
     */
	var $components = array('Session');

    /**
     * Initializes I18n for use in the controller
     * called before Controller::beforeFilter()
     *
     * @param object $controller A reference to the instantiating controller object
     * @return void
     * @access public
     */
    function initialize(&$controller, $settings = array()) {
    	// saving the controller reference for later use
    	$this->controller = &$controller;
    	
        if (!class_exists('I18n')) {
			App::import('Core', 'i18n');
		}
		//$this->I18n = I18n::getInstance();
		//$this->controller->I18n =& I18n::getInstance();
    }

    /**
     * Initializes I18n for use in the controller
     * called after Controller::beforeFilter()
     *
     * @param object $controller A reference to the instantiating controller object
     * @return void
     * @access public
     */
	function startup(&$controller) {
        //Configure languages
        $this->controller->loadModel('Lang');
        
        $this->controller->languages = $this->controller->Session->read('_languages');
        
        if (!$this->controller->languages) {
            $this->controller->languages = $this->controller->Lang->find('all', array('conditions' => array('Lang.active' => 1)));
            $this->controller->Session->write('_languages', $this->controller->languages);
        }
        
        $this->controller->set('languages', $this->controller->languages);
        $this->setLanguage();
        $I18n = I18n::getInstance();
	    $I18n->l10n->get(Configure::read('Config.language'));
        //$this->I18n->L10n->get(Configure::read('Config.language'));

        $c2 = $I18n->l10n->lang;
        //$c2 = 'pl';
        if(Configure::read('Config.locales.'.$c2)){
            setlocale(LC_ALL, Configure::read('Config.locales.'.$c2));
        } else {
            $C2 = strtoupper($c2);
            $code3 = $I18n->l10n->locale;
            //$code3 = 'pol';
            $name = explode(' ', $I18n->l10n->language);
            $name = strtolower($name[0]);
            $name = 'polski';
            $NAME = strtoupper($name);
            Configure::write('Config.locale',$c2);
            Configure::write('Config.locales.'.$c2, array(
                "{$c2}-{$C2}.utf8", 
                "{$c2}_{$C2}.UTF8", 
                "{$c2}_{$C2}.utf8", 
                "{$c2}_{$C2}.UTF-8", 
                "{$c2}_{$C2}.utf-8", 
                "{$name}_{$NAME}.UTF8", 
                "{$name}_{$NAME}.utf8", 
                "{$c2}.UTF8", 
                "{$name}.UTF8", 
                "{$name}-{$c2}.UTF8", 
                "{$C2}.UTF8", 
                "{$name}.utf8", 
                "{$name}-{$c2}.utf8", 
                "{$C2}.utf8", $name
            ));
            setlocale(LC_ALL, Configure::read('Config.locales.'.$c2));
        }
        $this->setLanguagesOrder();
	}

    function beforeRender(){
        
    }
    function shutdown(){
        
    }

    /**
     * setLanguagesOrder
     * 
     * method sets the languages array in Configure basing on Config.language key
     * 
     * @access protected
     */
    protected function setLanguagesOrder(){
        $languages = array();
        $i = 0;

        foreach($this->controller->languages AS $lang){
            $key = ($lang['Lang']['code'] == Configure::read('Config.language'))?0:(++$i);
            $languages[$key] = $lang['Lang']['code'];
        }
        ksort($languages);

        Configure::write('Config.languages', $languages);
    }

    /**
     * setLanguage
     * 
     * method sets the language basing on params['lang'] and session Config.language key
     * 
     * @access protected
     */
    protected function setLanguage(){

        $lang = empty($this->controller->params['lang'])?DEFAULT_LANGUAGE:$this->controller->params['lang'];

        if($session_lang = $this->controller->Session->read('Config.language')){
            //$session_lang = $this->Session->read('Config.language');
            if($session_lang != $lang){
                $this->controller->Session->write('Config.language', $lang);
            }
            Configure::write('Config.language', $lang);
        } else {
            
            if($lang == DEFAULT_LANGUAGE AND !empty($this->controller->params['url']) AND $this->controller->params['url'] == '/'){
                $this->determineLanguage();
                $lang = Configure::read('Config.language');
                $this->Session->write('Config.language', $lang);
                
                if($lang != DEFAULT_LANGUAGE){
                    $this->controller->redirect(array('controller' => 'pages', 'action' => 'display', 'index', 'lang' => $lang), 303);
                }
                
            } else {
                $this->controller->Session->write('Config.language', $lang);
                Configure::write('Config.language', $lang);
            }
        }
    }

    /**
     * determineLanguage
     * 
     * method determines the language basing on browser locale settings. 
     * It also groups regions to available locale
     * 
     * TODO: switch logic schould be moved to configuration file
     * 
     * @access protected
     */
    protected function determineLanguage(){
        $lang = Configure::read('Config.language');
        if(empty($lang)){
            $lang = DEFAULT_LANGUAGE;
        }
        $I18n = I18n::getInstance();
        $lang_arr = $I18n->l10n->catalog($lang);
        $lang_fallback = $I18n->l10n->map($lang_arr['localeFallback']);

        switch($lang_fallback){
            case 'de':
                $lang_fallback = 'de';
                break;
            case 'es':
                $lang_fallback = 'es';
                break;
            case 'pl':
                $lang_fallback = 'pl';
                break;
            case 'en': //angielski
//             case 'sk': //słowacki
//             case 'cs': //czeski
//             case 'uk': //ukraiński
//             case 'be': //białoruski
//             case 'ru': //rosyjski
            default:
                $lang_fallback = 'en';
                break;
        }

//         if($lang_fallback != 'pl'){
//             $this->controller->redirect(array('lang' => $lang_fallback));
//         }
        Configure::write('Config.language', $lang_fallback);

        
    }


//     /**
//      * saveAllLanguages
//      * 
//      * method saves all languages i18n data (one record - all languages).
//      * 
//      */
//     function saveAllLanguages($model=null){
//         if(empty($model)){
//             $model=$this->controller->modelNames['0'];
//         }
//         $this->controller->$model->locale ='pol';
//         $this->controller->$model->save($this->data,false);
// 
//         foreach($this->controller->data[$model] as $input => $data){
//             if(!strpos($input,'_lang_')){
//                 continue;
//             }
//             $input=explode('_lang_',$input);
//             $data2[$input['0']][$input['1']]=$data;
//         }
// 
//         $error = $stop = false;
// 
//         foreach($data2 as $lang=>$data){
//             $this->controller->$model->locale = $lang;
//             //debug($data);//exit;
//             if (!$this->controller->$model->save($data)){
//                 $error=true;
//                 foreach ($this->controller->$model->validationErrors as $key=>$value){
//                     $validateErrors[$lang.'_lang_'.$key]=$value;
//                 }
//             }
//         }
// 
//         if($error){
//             $setFlashSession=__d('cms', 'Nie udało się zapisać');
//             foreach($validateErrors as $input => $message){
//                 $setFlashSession.=' ,'.$message;
//                 if(strpos($input,'_lang_')){
//                     $input=explode('_lang_',$input);
//                     $setFlashSession.= __d('cms', ' w języku ').$input[0];
//                 }
//             }
//             $setFlashSession.= ' '.__d('cms', 'sprawdź formularz i spróbuj ponownie');
//             $this->controller->$model->validationErrors=$validateErrors;
//             return $setFlashSession;
// 		}
//         return 0;
// 	}

//     /**
//      * saveAllLanguages
//      * 
//      * method .... TODO: Damian co to robi?
//      * 
//      */
// 	function emptyDataAllLanguages($id=null,$fields=array(),$model=null){
// 	   if(empty($model)){
//             $model=$this->controller->modelNames['0'];
//         }
// 	   foreach ($fields as $field){
// 	      $this->controller->$model->bindTranslation(array ( $field =>'i18n_'.$field ));
// 	   }
// 	   
// 	   $translation= $this->controller->$model->findById($id);
// 
// 	   foreach ($fields as $field){
// 	       foreach($translation['i18n_'.$field] as $data){
// 		      $this->controller->data[$model][$data['locale'].'_lang_'.$data['field']]=$data['content'];
// 		  }
// 		  unset($translation[$model][$field]);
// 	   }
// 	   $this->controller->data[$model]=array_merge($this->controller->data[$model],$translation[$model]);
//         unset($translation); 
// 	}


    //called before Controller::redirect()
    function beforeRedirect(&$controller, $url, $status=null, $exit=true) {

        if(!isset($url['lang']) && isset($controller->params['lang'])) {
          $url['lang'] = $controller->params['lang'];
        }
 
        return array('url' => $url, 'status' => $status, 'exit' => $exit);
    }
    
    function delete($id= null, $all = 0, $model = null){
        $lang = Configure::read('Config.locale');
        $model = empty($model)?$this->controller->modelClass:$model;

        if (empty($id)) {
            throw new NotFoundException(__d('cms', 'Invalid localization'));
        }
        $ile1 = $ile2 = false;
        if(!$all){ 
            $ile1 = $this->controller->$model->query("SELECT COUNT(*) as `ile` FROM `i18n` WHERE `model` = '{$model}' AND locale = '{$lang}' AND foreign_key = {$id}");
            $ile1 = $ile1[0][0]['ile'];
            $ile2 = $this->controller->$model->query("SELECT COUNT(*) as `ile` FROM `i18n` WHERE `model` = '{$model}' AND foreign_key = {$id}");
            $ile2 = $ile2[0][0]['ile'];
        }
        if ($all or (!$all and $ile1 == $ile2)) {
            if($this->controller->$model->delete($id)){
                $this->controller->Session->setFlash(__d('cms', 'Pozycja została usunieta'));
                return true;
            }else{
                $this->controller->Session->setFlash(__d('cms', 'Pozycja nie została usunięta'));
                return false;
            }         
        } else {
            if($this->controller->$model->query("DELETE FROM `i18n` WHERE `model` = '{$model}' AND locale = '{$lang}' AND foreign_key = {$id}")){
                $this->controller->Session->setFlash(__d('cms', 'Język został usunięty'));
                return true;
            }else{
                $this->controller->Session->setFlash(__d('cms', 'Język nie został usunięty'));
                return false;
            }
        }
    }

}
?>