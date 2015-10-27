<?php
class FilteringComponent extends Component {

	var $controller = null;
        var $slashChar = '%F';
        var $dotChar = '%34';
	
    function startup(&$controller) {
        $this->controller = &$controller;
    }

    function getParams($id = null){
        if(!empty($this->controller->request->data)){
            $params = $this->_data_to_params();
            if (!empty($this->controller->params['pass'])) {
                $params = array_merge($this->controller->params['pass'], $params);
            }
            $redirectUrl = Router::url($params);
            $thisUrl =  (Router::url('/').$this->controller->request->url);
            if($redirectUrl != $thisUrl){
                // fix for admin/static_product/products/index/ when tytul: eith slash
                if(isset($params['tytul']) && strpos($params['tytul'], '/') !== false) {
                    $params['tytul'] = str_replace('/', '', $params['tytul']);
                }
                $this->controller->redirect($params);
            }
        } else {
            $params = $this->_params_from_controller();
        }
        $this->controller->request->data = $this->_params_to_data($params);
        return $params;
    }

    
    function getParamsPollEmployees(){
        if(!empty($this->controller->request->data)){
            
            $params = $this->_data_to_params();
        } else {
            $params = $this->_params_from_controller();
        }
        $this->controller->request->data = $this->_params_to_data($params);
        return $params;
    }
    
    function getParamsTestEmployees(){
        if(!empty($this->controller->request->data)){
            
            $params = $this->_data_to_params();
        } else {
            $params = $this->_params_from_controller();
        }
        $this->controller->request->data = $this->_params_to_data($params);
        return $params;
    }
    
    function _params_from_controller(){
        $params = array();
        foreach($this->controller->filters AS $key => $value){
            $filtersKey = !empty($value['param_name'])?$value['param_name']:$key;
            if(!isSet($this->controller->params['named'][$filtersKey])){
                continue;
            }
            $params[$filtersKey] = $this->controller->params['named'][$filtersKey];
        }
        return $params;
    }

    function _data_to_params(){
        $named_params = array();
        foreach($this->controller->request->data AS $key => $array){
            foreach($array AS $sub_key => $value){

                $data_keys = array_keys($this->controller->filters);
                if(!in_array($key.'.'.$sub_key, $data_keys)){
                    if($key != 'Filter' OR !in_array($sub_key, $data_keys)){
                        continue;
                    } else {
                        $paramsKey = !empty($this->controller->filters[$sub_key]['param_name'])?$this->controller->filters[$sub_key]['param_name']:$sub_key;
                        $default = !empty($this->controller->filters[$sub_key]['default'])?$this->controller->filters[$sub_key]['default']:'';
                    }
                } else {
                    $paramsKey = !empty($this->controller->filters[$key.'.'.$sub_key]['param_name'])?$this->controller->filters[$key.'.'.$sub_key]['param_name']:$key.'.'.$sub_key;
                    $default = !empty($this->controller->filters[$key.'.'.$sub_key]['default'])?$this->controller->filters[$key.'.'.$sub_key]['default']:'';
                }
                if(is_array($value)){
                    //multiple
                    if(!in_array($default, $value)){
                        $named_params[$paramsKey] = implode('|', $value);
                    }
                } elseif ($value != $default) {
                    $named_params[$paramsKey] = str_replace('|', ' ', $value);
                    $named_params[$paramsKey] = str_replace('/', $this->slashChar, $value);
                    $named_params[$paramsKey] = str_replace('.', $this->dotChar, $value);
                }
            }
        }
        return $named_params;
    }

    function _params_to_data($params){

        $data = array();
        
        foreach($this->controller->filters AS $key => $value){
            $filtersKey = !empty($value['param_name'])?$value['param_name']:$key;
            if(!isSet($params[$filtersKey]) AND empty($value['default'])){
                continue;
            }
            $params[$filtersKey] = str_replace($this->slashChar, '/', $params[$filtersKey]);
            $params[$filtersKey] = str_replace($this->dotChar, '.', $params[$filtersKey]);
            
            $dataKey = $key;
            if(strpos($key, '.') === false){
                $dataKey = 'Filter.'.$dataKey;
            }
            $dataKey = explode('.', $dataKey);
            
//            if(!empty($data[$dataKey[0]][$dataKey[1]])){
//                $data[$dataKey[0]][$dataKey[1]] = str_replace('^2F', '/', $data[$dataKey[0]][$dataKey[1]]);
//            }
            
            if(count($dataKey) != 2){
                $this->log('Problem z kluczem: '.$key.' (Component: Filtering::_params_to_data()');
                continue;
            }


            if(!empty($params[$filtersKey]) AND strpos($params[$filtersKey], '|') !== false){
                $data[$dataKey[0]][$dataKey[1]] = explode('|', $params[$filtersKey]);
            } elseif(isSet($params[$filtersKey]) AND (empty($value['default']) OR $params[$filtersKey] != $value['default'])){
                $data[$dataKey[0]][$dataKey[1]] = $params[$filtersKey];
            } elseif(!empty($value['default'])){
                $data[$dataKey[0]][$dataKey[1]] = $value['default'];
            }            
        }
        return $data;
    }


}
?>