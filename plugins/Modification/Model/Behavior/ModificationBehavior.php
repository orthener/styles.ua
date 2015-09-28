<?php
/**
 * Modification Behavior 
 * 
 *
 * @filesource
 * @package    app
 * @subpackage    models.behaviors
 */
class ModificationBehavior extends ModelBehavior {

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

    /**
     * Bind Modification model if not binded
     *
     * @param object $model    Model using the behaviour
     * @return bolean success of failure
     *
     * @access public
     */
    function bindModification(&$model) {
        if (!empty($model->Modification) AND is_object($model->Modification)) {
            return true;
        }

        $conditions = array('Modification.model' => $model->name);

        $model->bindModel(array('hasMany' => array(
                'Modification' => array(
                    'className' => 'Modification.Modification',
                    'foreignKey' => 'foreign_key',
                    'conditions' => array('Modification.model' => $model->name),
                    'dependent' => false
                )
                )), false);

        return true;
    }

    function beforeValidate(&$model) {
        return $this->beforeValidateLogic($model);
    }

    function beforeSave(&$model) {
        if (!isSet($this->runtime[$model->alias]['beforeValidateLogicDone'])) {
            return $this->beforeValidateLogic($model);
        } else {
            unSet($this->runtime[$model->alias]['beforeValidateLogicDone']);
        }
        return true;
    }

    function beforeValidateLogic(&$model) {

        $this->runtime[$model->alias]['beforeValidateLogicDone'] = true;

        $this->bindModification($model);

        $row_id = null;
        if (!empty($model->data[$model->alias][$model->primaryKey])) {
            $row_id = $model->data[$model->alias][$model->primaryKey];
        }
        if (empty($row_id) AND !empty($model->{$model->primaryKey})) {
            $row_id = $model->{$model->primaryKey};
        }

        if (!empty($row_id)) {
            $object = $model->find('first', array('conditions' => array($model->alias.'.'.$model->primaryKey => $row_id), 'recursive' => 1));

            if (!empty($object[$model->alias])) {
                //zapis info o modyfikacjach
                $this->runtime[$model->alias]['newRecordData'] = array(
                    'Modification' => array(
                        'user_id' => empty($_SESSION['Auth']['User']['id']) ? null : $_SESSION['Auth']['User']['id'],
                        'model' => $model->name,
                        'foreign_key' => $row_id,
                        'content_before' => $object[$model->alias],
                        'content_after' => $model->data[$model->alias],
                    )
                );
                //zmiana nazwy akcji, jeæli "softdelete":
                if (!empty($model->data[$model->alias]['deleted']) AND $object[$model->alias]['deleted'] == 0) {
                    $this->runtime[$model->alias]['newRecordData']['Modification']['action'] = 'softdelete';
                }
                //zmiana nazwy akcji, jezli "recover":
                if (isSet($model->data[$model->alias]['deleted']) AND $object[$model->alias]['deleted'] == 1 AND $model->data[$model->alias]['deleted'] == 0) {
                    $this->runtime[$model->alias]['newRecordData']['Modification']['action'] = 'undelete';
                }
            }
        } else {

            //zapis info o modyfikacjach
            $this->runtime[$model->alias]['newRecordData'] = array(
                'Modification' => array(
                    'user_id' => empty($_SESSION['Auth']['User']['id']) ? null : $_SESSION['Auth']['User']['id'],
                    'model' => $model->name,
                    'foreign_key' => $row_id,
                    'action' => 'add',
                    'content_before' => array(),
                    'content_after' => $model->data[$model->alias],
                )
            );
        }


        return true;
    }

    function afterSave(&$model, $created) {

        if (isSet($this->runtime[$model->alias]['newRecordData'])) {
            $data = $this->runtime[$model->alias]['newRecordData'];
            unSet($this->runtime[$model->alias]['newRecordData']);

            if ($created) {
                $data['Modification']['foreign_key'] = $model->getInsertID();
                $data['Modification']['content_after']['id'] = $data['Modification']['foreign_key'];
            }
            $user = $model->Modification->User->findById($data['Modification']['user_id']);
            $data['Modification']['user_details'] = json_encode($user['User']);

            if ($data['Modification']['foreign_key'] != null) {
                $data['Modification']['content_after'] = $model->find('first', array(
                    'conditions' => array($model->alias.'.'.$model->primaryKey => $data['Modification']['foreign_key']), 
                    'recursive' => 1)
                );
                $data['Modification']['content_after'] = $data['Modification']['content_after'][$model->alias];
                $data['Modification']['content_before'] = json_encode($data['Modification']['content_before']);
                $data['Modification']['content_after'] = json_encode($data['Modification']['content_after']);

                $model->Modification->create($data);
                $model->Modification->save();
                $model->Modification->create();
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

        $this->bindModification($model);

        $row_id = null;
        if (!empty($model->{$model->primaryKey})) {
            $row_id = $model->{$model->primaryKey};
        }

        if (!empty($row_id)) {
            $object = $model->findById($row_id);

            if (!empty($object[$model->alias])) {
                //zapis info o modyfikacjach
                $this->runtime[$model->alias]['deleteRecordData'] = array(
                    'Modification' => array(
                        'user_id' => empty($_SESSION['Auth']['User']['id']) ? null : $_SESSION['Auth']['User']['id'],
                        'model' => $model->name,
                        'foreign_key' => $row_id,
                        'action' => 'delete',
                        'content_before' => json_encode($object[$model->alias]),
                        'content_after' => json_encode(array()),
                    )
                );
            }

            $user = $model->Modification->User->findById($this->runtime[$model->alias]['deleteRecordData']['Modification']['user_id']);
            if (!empty($user)) {
                $this->runtime[$model->alias]['deleteRecordData']['Modification']['user_details'] = json_encode($user['User']);
            }
        }

        return true;
    }

    function afterDelete(&$model) {
        if (isSet($this->runtime[$model->alias]['deleteRecordData'])) {
            $data = $this->runtime[$model->alias]['deleteRecordData'];
            unSet($this->runtime[$model->alias]['deleteRecordData']);
            $model->Modification->create();
            $model->Modification->save($data);
            $model->Modification->create();
        }
        return true;
    }

}

?>
