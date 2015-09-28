<?php

class Slug extends AppModel {

    var $name = 'Slug';
    var $displayField = 'slug';

    function replaceSlug($id, $row_id, $model_name, $locale) {

        $this->setSlugsAsDeleted($row_id, $model_name, $locale);
        $this->id = $id;
        $this->saveField('deleted_date', null);
        $this->create();
    }

    function setSlugsAsDeleted($row_id, $model_name, $locale) {
        $this->updateAll(
                array('Slug.deleted_date' => "'" . date('Y-m-d H:i:s') . "'"), //fields array
                array(
                    'Slug.locale' => $locale,
                    'Slug.model' => $model_name,
                    'Slug.row_id' => $row_id,
                    'Slug.deleted_date IS NULL',
                ) //conditions array
        );
    }
    
//    function langSlug

}

?>