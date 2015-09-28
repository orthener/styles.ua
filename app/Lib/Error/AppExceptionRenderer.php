<?php
App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {
    
    
    public function appBadRequest($error) {
		$message = $error->getMessage();
		if (Configure::read('debug') == 0 && $error instanceof CakeException) {
			$message = __d('cake', 'Not Found');
		}
		$url = $this->controller->request->here();
		$this->controller->response->statusCode($error->getCode());
		$this->controller->set(array(
			'name' => $message,
			'url' => h($url),
			'error' => $error, 
			'serialize' => array('name', 'url')
		));
		$this->_outputMessage('app_bad_request');
    }
    
    
    protected function _outputMessage($template) {
        if($this->controller->request->is('ajax')){
            if(file_exists(APP.DS.'View'.DS.'Errors'.DS.'json'.DS.$template)){
                $template = 'json'.DS.$template;
            }
        }
        parent::_outputMessage($template);
    }
}
