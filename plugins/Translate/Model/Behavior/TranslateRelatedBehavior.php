<?php
/**
 * Modification Behavior 
 * 
 *
 * @filesource
 * @package    app
 * @subpackage    models.behaviors
 */
class TranslateRelatedBehavior extends ModelBehavior {

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

        $this->settings[$model->alias] = array_merge($this->settings[$model->alias], is_array($settings) ? $settings : array());
    }

    
    function beforeFind(Model $model, $queryData) {
//        parent::beforeFind($model, $queryData);
        
        $recursive = $model->recursive;
        if(!empty($queryData['recursive'])){
            $recursive = $queryData['recursive'];
        }
        
        if($recursive > -1){
            $model->translateAfter = true;
            foreach($model->belongsTo AS $key => $value){
                if(!empty($model->$key->Behaviors->Translate)){
                    $queryData = $model->$key->Behaviors->Translate->beforeFind($model->$key, $queryData);
                }
            }
        }
        
        foreach($queryData['joins'] AS &$join){
            if(!empty($join['type']) AND $join['type'] == "INNER"){
                if(!empty($join['alias']) AND stripos($join['alias'], 'I18n') === 0 AND stripos($join['alias'], 'I18n__'.$model->alias) === false){
                    $join['type'] = "LEFT";
                }
            }
        }
        
        return $queryData;
        
    }

    function afterFind(Model $model, $results, $primary) {
        //parent::afterFind($model, $results, $primary);
        
        if(!empty($model->translateAfter)){
            foreach($model->belongsTo AS $key => $value){
                if(!empty($model->$key->Behaviors->Translate)){
                    $results = $model->$key->Behaviors->Translate->afterFind($model->$key, $results, $primary);
                }
            }
            unSet($model->translateAfter);
        }
        return $results;
    }
    
    
}

?>
