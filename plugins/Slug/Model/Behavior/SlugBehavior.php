<?php 
/**
 * Slug Behavior 
 * 
 *
 * @filesource
 * @package    app
 * @subpackage    models.behaviors
 */
 
class SlugBehavior extends ModelBehavior {
     
    var $settings = array();

    var $runtime = array();

    /**
     * Initiate behaviour for the model using settings.
     *
     * @param object $model    Model using the behaviour
     * @param array $settings    Settings to override for model.
     *
     * @access public
     */
    function setup(&$model, $settings = array()) {
        $default = array();
        if (!isset($this->settings[$model->alias])) {
            $this->settings[$model->alias] = $default;
        }
        $settings = is_array($settings)?$settings:array();
        $this->settings[$model->alias] = array_merge($this->settings[$model->alias], $settings);
    }

    /**
     * Bind Slug model if not binded
     *
     * @param object $model    Model using the behaviour
     * @return bolean success of failure
     *
     * @access public
     */
    function bindSlug(&$model) {
        if(!empty($model->Slug) AND is_object($model->Slug)){
            return true;
        }
        
        $model->bindModel(array('hasMany' => array(
            'Slug' => array(
    			'className' => 'Slug.Slug',
    			'foreignKey' => 'row_id',
    			'conditions' => array('Slug.model' => $model->name),
    			'dependent' => true
            )
        )), false);
        
        return true;
    }

    function beforeValidate(&$model){
        return $this->beforeValidateLogic($model);
    }

    function beforeSave(&$model){
        if(!isSet($this->runtime[$model->alias]['beforeValidateLogicDone'])){
            return $this->beforeValidateLogic($model);
        } else {
            unSet($this->runtime[$model->alias]['beforeValidateLogicDone']);
        }
        return true;
    }

    function beforeValidateLogic(&$model){
    
        $this->runtime[$model->alias]['beforeValidateLogicDone'] = true;

        if(method_exists($model, 'slugString')){
            $slug_name = $model->slugString();
            if($slug_name === false){
                return true;
            }
        } else {
            if(empty($model->data[$model->alias][$model->displayField])){
                return true;
            }
            $slug_name = $model->data[$model->alias][$model->displayField];
        }

        $this->bindSlug($model);
        
        $slug_name = $this->_slug($slug_name);
        $model->data[$model->alias]['slug'] = $slug_name;

        $model->Slug->recursive = -1;
        $slug = $model->Slug->find('first', array('conditions' => array(
            'Slug.slug' => $slug_name,
        )));

        $row_id = null;
        if(!empty($model->data[$model->alias][$model->primaryKey])){
            $row_id = $model->data[$model->alias][$model->primaryKey];
        }
        if(empty($row_id) AND !empty($model->{$model->primaryKey})){
            $row_id = $model->{$model->primaryKey};
        }

        //jeśli slug był "historyczny" - można go usunąć i wykorzystać ponownie
        if(!empty($slug) AND $slug['Slug']['deleted_date'] != null){
            $slug = null;
            $model->Slug->delete($slug['Slug']['id']);
        }
        
        if(!empty($slug)){
            if(!empty($row_id) AND $slug['Slug']['model'] == $model->name 
            AND $slug['Slug']['row_id'] == $row_id AND $slug['Slug']['locale'] == $this->getLocale($model)){
                //slug jest bez zmian
                $model->Slug->create();
                return true;
            } elseif(empty($row_id)) {
                //slug nie jest unikalny - dodanie rekordu
                $slug_name = $this->generateNewSlug($model, $slug_name);
                $model->data[$model->alias]['slug'] = $slug_name;
                
            } else {
                //slug nie jest unikalny - aktualizacja rekordu
                $slug_name = $this->generateNewSlug($model, $slug_name, $row_id);
                $model->data[$model->alias]['slug'] = $slug_name;

                $slug = $model->Slug->find('first', array('conditions' => array(
                    'Slug.slug' => $slug_name,
                )));

                if(!empty($slug) AND $slug['Slug']['deleted_date'] != null){
                    //powrót do historycznego
                    $this->runtime[$model->alias]['replaceSlug'] = array($slug['Slug']['id'], $row_id, $model->name, $this->getLocale($model));

                    return true;
                } elseif(!empty($slug)){
                    //slug jest bez zmian
                    $model->Slug->create();
                    return true;
                }
            }
        }

        //nowy slug - nowy rekord
        if (empty($row_id)) {
            $this->runtime[$model->alias]['newRecordData'] = array(
                'Slug' => array(
                    'locale' => $this->getLocale($model),
                    'model' => $model->name,
                    'row_id' => $row_id,
                    'slug' => $slug_name,
                )
            );
            return true;
        }

        //nowy slug - aktualizacja rekordu
        $this->runtime[$model->alias]['setSlugsAsDeleted'] = array($row_id, $model->name, $this->getLocale($model));

        $this->runtime[$model->alias]['newRecordData'] = array(
            'Slug' => array(
                'locale' => $this->getLocale($model),
                'model' => $model->name,
                'row_id' => $row_id,
                'slug' => $slug_name,
            )
        );
        
        return true;

    }

    function afterSave (&$model, $created){

        if(isSet($this->runtime[$model->alias]['replaceSlug'])){
            $data = $this->runtime[$model->alias]['replaceSlug'];
            unSet($this->runtime[$model->alias]['replaceSlug']);

            $model->Slug->replaceSlug($data[0], $data[1], $data[2], $data[3]);
        }

        if(isSet($this->runtime[$model->alias]['setSlugsAsDeleted'])){
            $data = $this->runtime[$model->alias]['setSlugsAsDeleted'];
            unSet($this->runtime[$model->alias]['setSlugsAsDeleted']);
            
            $model->Slug->setSlugsAsDeleted($data[0], $data[1], $data[2]);
        }


        if(isSet($this->runtime[$model->alias]['newRecordData'])){
            $data = $this->runtime[$model->alias]['newRecordData'];
            unSet($this->runtime[$model->alias]['newRecordData']);

            if($data['Slug']['row_id'] == null AND $created){
                $data['Slug']['row_id'] = $model->getInsertID();
            }

            if($data['Slug']['row_id'] != null){
                $model->Slug->create($data);
                $model->Slug->save();
                $model->Slug->create();
            }

        }

        return true;
    }    


    /**
     *         
     * Run before a model is deleted, used to delete slugs
     *
     * @param object $model    Model about to be deleted.
     *
     * @access public
     */
    function beforeDelete(&$model) {

        $this->bindSlug($model);

        return true;
    }

    /**
     *         
     * Generates unique slug name based on $slug_name
     *
     * @param object $model    Model using this behaviour
     * @param string $slug_name - slug witch is not unique
     * @return string unique slug name
     *
     * @access public
     */
    function generateNewSlug(&$model, $slug_name, $row_id = null){
        $i = 2;
        $new_slug_name = $slug_name.'-'.$i;
        
        $params = array('conditions' => array('Slug.slug' => &$new_slug_name));
        if(!empty($row_id)){
            $params['conditions'][] = 'NOT (`Slug`.`model` = \''.$model->alias.'\' AND `Slug`.`row_id` = \''.$row_id.'\' AND Slug.locale = \''.$this->getLocale($model).'\')';
        }

        while($model->Slug->find('count', $params)){
            ++$i;
            $new_slug_name = $slug_name.'-'.$i;
        }

        return $new_slug_name;
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
     
   function _slug($srcName) {
        $srcName = mb_strtolower(strip_tags($srcName));
        $srcName = mb_substr($srcName, 0, 90);
        $srcName = Inflector::slug($srcName, '-');
        $srcName = str_replace(array('--', '---', '----'), array('-', '-', '-'), $srcName);
        $trans = array('ª' => 'a', 'º' => 'o', 'µ' => 'u', 'À' => 'A', 'Á' => 'A', 'Â' => 'A',
            'Ä' => 'A', 'Ą' => 'A', 'Ç' => 'C', 'Ć' => 'C', 'È' => 'E', 'É' => 'E',
            'Ë' => 'E', 'Ę' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'I' => 'I',
            'Ł' => 'L', 'Ñ' => 'N', 'Ń' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Ö' => 'O', 'Ś' => 'S', 'Ù' => 'U', 'Ú' => 'U', 'Ü' => 'U', 'Ý' => 'Y',
            'Ż' => 'Z', 'Ź' => 'Z', 'ß' => 'ss', 'à' => 'a', 'á' => 'a', 'â' => 'a',
            'ä' => 'a', 'ą' => 'a', 'ç' => 'c', 'ć' => 'c', 'è' => 'e', 'é' => 'e',
            'ë' => 'e', 'ę' => 'e', 'í' => 'i', 'î' => 'i', 'i' => 'i', 'ł' => 'l',
            'ñ' => 'n', 'ń' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
            'ś' => 's', 'ù' => 'u', 'ú' => 'u', 'ü' => 'u', 'ý' => 'y', 'ż' => 'z',
            'ź' => 'z',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', // konwersja cyrylicy na znaki łacińskie
            'Ё' => 'E', 'Ж' => 'J', 'З' => 'Z', 'И' => 'I', 'Й' => 'I', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
            'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z',
            'и' => 'i', 'й' => 'i', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
        );

        
        $srcName = strtr($srcName, $trans);
        return $srcName;
    }

    /**
     *         
     * Funkcja zwraca aktualną lokalizację bazując na ustawieniu modelu, lub opcjonalnie na ustawieniu konfigracyjnym
     * @param object $model Aktualny model
     * @return string locale
     *      
     */
    function getLocale(&$model){
		if (!isset($model->locale) || is_null($model->locale)) {
			if (!class_exists('I18n')) {
				App::import('Core', 'i18n');
			}
			$I18n =& I18n::getInstance();
			$I18n->l10n->get(Configure::read('Config.language'));
			$model->locale = $I18n->l10n->locale;
		}

		return $model->locale;
    }

    function getIdBySlug(&$model=null,$slug=null){
        $this->bindSlug($model);
        $params = array(
            'conditions' => array(
                'Slug.slug' => $slug, 
                'Slug.model' => $model->alias, 
                'Slug.deleted_date IS NULL'
            ), 
            'order' => 'Slug.created DESC',
            'fields' => array('Slug.row_id')
        );
        
        if(!empty($model->Behaviors->Translate) AND $model->Behaviors->Translate instanceof ModelBehavior){
            $params['conditions']['Slug.locale'] = $this->getLocale($model); 
        }
        
        $data = $model->Slug->find('first',$params);
        
        return empty($data)?null:$data['Slug']['row_id'];
    }

    function getDataByPrevSlug(&$model=null,$slug=null){
        $this->bindSlug($model);
        $slug_data = $model->Slug->find('first', array('conditions' => array('Slug.slug' => $slug)));
        if(empty($slug_data) OR $slug_data['Slug']['model'] != $model->alias){
            return false;
        }
        
        $data = $model->find('first', array('conditions' => array($model->alias.'.'.$model->primaryKey => $slug_data['Slug']['row_id']), 'recursive' => -1));
        
        if(empty($data[$model->alias]['slug'])){
            return false;
        }

        return $data;
    }

    function isSlug(&$model=null,$slug=null){

        $id = $this->getIdBySlug($model, $slug);

        if(!empty($id)){
            return array('slug' => $slug, 'id' => $id, 'error' => null);
        }
        $data = $this->getDataByPrevSlug($model, $slug);

        if(!empty($data[$model->alias]['slug'])){
            $return = array(
                'slug' => $data[$model->alias]['slug'], 
                'id' => $data[$model->alias]['id'],
                'error' => 301 
            );
            if(!empty($model->Behaviors->Translate) AND $model->Behaviors->Translate instanceof ModelBehavior){
                $return['locale'] = $data[$model->alias]['locale'] != DEFAULT_LANGUAGE?$data[$model->alias]['locale']:false;
            }
            return $return;
        }
        return false;
    }
    
    public function languagesLinks(&$model=null){
        
        $locale = $model->locale;
        
        $model->locale = Configure::read('Config.languages');
        
        $this->__unbindAll($model);
        $model->bindTranslation(array('slug' => 'Slugs'));
        
        $results = $model->find('first', array(
            'recursive' => 1, 
            'fields' => array($model->primaryKey) , 
            'conditions' => array(
                $model->alias.'.'.$model->primaryKey => $model->id
            )
        ));

        $model->locale = $locale;
        
        $slugs = Set::combine($results, "Slugs.{n}.locale", "Slugs.{n}.content");
        
        return $slugs;
    }
    
    private function __unbindAll(&$model){
        $types = array('hasMany', 'belongsTo', 'hasOne', 'hasAndBelongsToMany');
        
        foreach($types AS $type){
            if(!empty($model->$type)){
                $model->unbindModel(array($type => array_keys($model->$type)));
            }
        }
    }
    
    
    
}
?>