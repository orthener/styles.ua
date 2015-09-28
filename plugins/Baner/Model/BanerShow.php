<?php
App::uses('AppModel', 'Model');

class BanerShow extends AppModel {
	public $name = 'BanerShow';
	public $displayField = 'name';
    
    public function filterParams($data) {
        $params = array();
//        if (!empty($data['Trainer']['fullname'])) {
//            $params['conditions']['Trainer.fullname LIKE'] = '%' . $data['Trainer']['fullname'] . '%';
//        }
        return $params;
    }

    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
        if (!empty($extra['group'])) {
            $field = $extra['group'];
            unSet($extra['group']);
            $params = array_merge(
                    array('conditions' => $conditions), array('fields' => array("COUNT(DISTINCT {$field}) AS count")), $extra
            );
            $results = $this->find('all', $params);
            return $results[0][0]['count'];
        }

        $params = array_merge(array('conditions' => $conditions), array());

        return $this->find('count', $params);
    }

}
