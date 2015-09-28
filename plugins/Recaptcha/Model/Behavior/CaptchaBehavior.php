<?php
class CaptchaBehavior extends ModelBehavior {
    
    public function RecaptchaValidate(&$model, $check = null) {
		App::import('vendor', 'Recaptcha.recaptcha'.DS.'recaptchalib');
		$this->data[$model->name]['recaptcha'] = $_POST['recaptcha_response_field'];
		$resp = recaptcha_check_answer(Configure::read('Recaptcha.private_key'), $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
		$error = $resp->error;
		$return = $resp->is_valid;
		return $return;
	}


  
    
}
?>