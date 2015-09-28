<?php
/**
 * CaptchaComponent
 * 
 * CaptchaComponent and CaptchaToolHelper allow the easy use of reCaptcha.net's captcha library.
 * @link http://recaptcha.net
 * 
 * Usage: (in the controller)
 * 	var $components = array(array('Recaptcha.Captcha', array(
 *					'private_key' => PRIVATE_KEY_FROM_RECAPTCHA_DOT_NET, 
 *					'public_key' => PUBLIC_KEY_FROM_RECAPTCHA_DOT_NET)));
 *  var $helpers = array('Recaptcha.CaptchaTool');
 * 
 * Usage: (in the view)
 * 	$captchaTool->show();
 * 
 * Requires:
 * - CakePHP 1.2
 * - PHP >= 5.2
 * - PECL json >= 1.2.0 (to use reCaptcha configuration options)
 * - Keys from reCaptcha.net
 * 
 * @author Jason Burgess <jason@holostek.net>
 * @version 0.8.0
 * @copyright (c) 2009 Jason Burgess
 * @license MIT/X
 */
class CaptchaComponent extends Component {

	/**
	 * Initialize the component 
	 * 
	 * @param $controller reference to the controller
	 * @param $settings Settings for the component:
	 * 					- private_key: (required) Private key from reCaptcha.net
	 * 					- public_key: (required) Public key from reCaptcha.net
	 * 					- config: (optional) Array of configuration options to pass to the reCaptcha library
	 * @access public
	 * @internal
	 * @since 0.1.0
	 */
	 
	public function __construct($View, $settings = array()){	
	    
	    $config  = array(
                        'theme' => 'clean',
                            'custom_translations' => array(
                                'instructions_visual'=>'Przepisz dwa słowa',
                                'instructions_audio' =>'Napisz co usłyszysz',
                                'play_again' => 'Powtórz',
                                'cant_hear_this' => 'Pobierz mp3',
                                'visual_challenge' => 'Tryb wizualny',
                                'audio_challenge' => 'Tryb fonetyczny',
                                'refresh_btn' => 'Odśwież',
                                'help_btn' => 'Pomoc',
                                'incorrect_try_again' => 'Nie poprawnie, spróbuj ponnownie'
                            )
                      );
                      
        $settings['config'] = empty($settings['config'])?$config:array_unique(array_merge($settings['config'],$config));
        
		if (!empty($settings['private_key'])) {
			Configure::write('Recaptcha.private_key', $settings['private_key']);
		}
		
		if (!empty($settings['public_key'])) {
			Configure::write('Recaptcha.public_key', $settings['public_key']);
		}
		
		if (!empty($settings['config'])) {
			Configure::write('Recaptcha.configuration', $settings['config']);
		}
		//$this->controller = &$controller;
	    //$this->controller->helpers[] = 'Recaptcha.CaptchaTool';
	}

}
?>