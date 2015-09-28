<?php
/**
* Facebook.Connect
* Uses the Facebook Connect API to log in a user through the Auth Component.
*
* The user MUST create a new field in their user model called 'facebook_id'
*
* @author Nick Baker <nick [at] webtechnick [dot] come>
* @link http://www.webtechnick.com
* @since 2.4.3
* @license MIT
*/


class ConnectComponent extends Component {
	
	/**
	* uid is the Facebook ID of the connected Facebook user, or null if not connected
	*/
	var $uid = null;
	
	/**
	* me is the Facebook user object for the connected Facebook user
	*/
	var $me = null;
	
	/**
	* hasAccount is true if the connected Facebook user has an account in your application
	*/
	var $hasAccount = false;
	
	/**
	* The authenticated User using Auth
	*/
	var $authUser = null;
	
	/**
	* No Auth, if set to true, syncFacebookUser will NOT be called
	*/
	var $noAuth = false;
	
	/**
	* Error log
	*/
	var $errors = array();
	
	/**
	* createUser is true you want the component to attempt to create a CakePHP Auth user
	* account by introspection on the Auth component.  If false, you can use $this->hasAccount
	* as a reference to decide what to do with that user. (default true)
	*/
	var $createUser = false;
	    
	/**
	* Initialize, load the api, decide if we're logged in
	* Sync the connected Facebook user with your application
	* @param Controller object to attach to
	* @param settings for Connect
	* @return void
	* @access public
	*/
	function initialize(&$Controller, $settings = array()){
        
        App::uses('FB', 'Facebook.Lib');
   
		$this->Controller = $Controller;
		$this->_set($settings);
        
        $this->FB = new FB();
		$this->session = $this->FB->getSession();

	}

	/**
	* Read the logged in user
	* @param field key to return (xpath without leading slash)
	* @param mixed return
	*/
	function user($field = null) {
		if(isset($this->session)){
			$this->uid = $this->session['uid'];
			if ($this->Controller->Session->read('FB.Me.email') == null) { // and !$this->Controller->Session->check('FB.Me.email')
				$this->Controller->Session->write('FB.Me', $this->FB->api('/me')); 
			}
			$this->me = $this->Controller->Session->read('FB.Me');
            
		} else {
			$this->Controller->Session->delete('FB');
		}
		
		if(!$this->me){
			return null;
		}
		
		if($field){
			$retval = Set::extract("/$field", $this->me);
			return empty($retval) ? null : $retval[0];
		}
		
		return $this->me;
	}
	
	/**
	* Run the callback if it exists
	* @param string callback
	* @param mixed passed in variable (optional)
	* @return mixed result of the callback function
	*/ 
	function __runCallback($callback, $passedIn = null){
		if(is_callable(array($this->Controller, $callback))){
			return call_user_func_array(array($this->Controller, $callback), array($passedIn));
		}
		return true;
	}
		
	/**
	* Handle errors.
	* @param string of error message
	* @return void
	* @access private
	*/
	function __error($msg){
		$this->errors[] = __d('cms', $msg, true);
	}
}