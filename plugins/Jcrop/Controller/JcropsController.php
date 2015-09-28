<?php

class JcropsController extends AppController {

    var $uses = null;

    function update($model = null, $id = null) {

        $this->loadModel($model);

        $this->$model->id = $id;
        $this->$model->saveField('x', $this->data['x']);
        $this->$model->saveField('y', $this->data['y']);

        $this->render(false);
    }

    function edit($model = null, $field = null, $id = null) {

        $this->loadModel($model);
        
        $this->$model->id = $id;
        $data['x'] = $this->$model->field('x');
        $data['y'] = $this->$model->field('y');
        $data['name'] = $this->$model->field($field);

        $this->set(compact('model', 'data', 'id'));
        $this->render('/Elements/jcrop');
    }

}