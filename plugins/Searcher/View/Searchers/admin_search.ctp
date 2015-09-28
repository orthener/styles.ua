<div class="searchers index">
    <?php
    
    if ($isResult) {
        foreach ($searchData as $model => $data) {
            if (!empty($data['data'])) {
                $controllerName = Inflector::pluralize($model);
                $this->request->params['controller'] = strtolower($controllerName);
                $this->request->params['action'] = 'admin_index';
                $this->request->params['paging'][$model] = array('options' => array(), 'paramType' => 'named');
                $plugin = $data['plugin']?$data['plugin'].'.':'';
                $this->request->params['plugin'] = strtolower($data['plugin']);
                echo $this->element($plugin.$controllerName . '/table_index', array('paddingOff' => true, Inflector::variable($controllerName) => $data['data']));
            }
        }
    } else {
        echo __d('cms', "Brak wyników wyszukiwania");
    }
    ?>
</div>