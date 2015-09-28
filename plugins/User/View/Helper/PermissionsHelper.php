<?php

/**
 * Permissions control helper class
 *
 * Provides permissions control logic for views (checks permissions for hyperlinks)
 * 
 * Permissions types:
 *    * - superuser full access  
 *    controller_name:* - per controller full access
 *    controller_name:action_name - per action access
 *    controller_name:action_name:record_id - per action, per record_id access (for ex. pages:edit:25)
 *    model_name:record_id - per record_id access (for ex. page:25 - user has full access to record: edit, delete, etc.)
 * 
 */
class PermissionsHelper extends AppHelper {

    /**
     * Other components utilized by PermissionsComponent
     *
     * @var array
     * @access public
     */
    var $helpers = array('Session', 'Html', 'Form');

    /**
     * Loggedin user permissions
     * 
     * Retrived from session
     *
     * @var array
     * @access private
     */
    var $_permissions = false;

    function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);

        $this->component = ClassRegistry::getObject('permissions_component');
        if (!is_object($this->component)) {
            die("Error: PermissionsComponent is required by PermissionsHelper (Load PermissionsComponent in Controller to resolve)");
        }
    }

    /**
     * $options = array(['authorize']=>array(),['outter']=>'%s') Creates an HTML link, if user is authorized to its action
     *

     * @param string $title The content to be wrapped by <a> tags.
     * @param mixed $url Cake-relative URL or array of URL parameters, or external URL (starts with http://)
     * @param array $options Array of HTML attributes. 
     * @param array $options authorize set of params to use in PermissionsHelper::isAuthorized.
     * @param string $options outter defaults to '%s' where %s is a Html::link output
     * @param string $confirmMessage JavaScript confirmation message.
     * @return string An `<a />` element or empty string.
     * @access public
     * @link http://book.cakephp.org/view/1442/link
     */
    function link($title, $url = null, $options = array(), $confirmMessage = false) {
        $outter_string = '%s';
        if (is_array($options)) {
            $authorize = isset($options['authorize']) ? $options['authorize'] : '';
            $outter_string = isset($options['outter']) ? $options['outter'] : '%s';
            unset($options['authorize'], $options['outter']);
        }

        //return sprintf($outter_string,$this->Permissions->link($title, $url, $options, $confirmMessage));
        $record_id = null;
        //zamienia url na authorize
        if (empty($authorize)) {
            $authorize = $url;
        } elseif (!empty($authorize['model']) AND !empty($authorize['record_id'])) {
            $record_id = $authorize['record_id'];
            $authorize = $authorize['model'];
        }

        $this->component->flatCheck = true;
        
        if ($this->component->isAuthorized($authorize, $record_id)) {
            $this->component->flatCheck = false;
            return sprintf($outter_string, $this->Html->link($title, $url, $options, $confirmMessage));
        }

        return '';
    }
    
    /**
     * Metoda autoryazacyjna dla formularzy linkowych
     */
    public function postLink($title, $url = null, $options = array(), $confirmMessage = false) {
        if ($this->component->isAuthorized($url)) {
            $this->component->flatCheck = false;
            if (isSet($options['outter'])) {
                return sprintf($options['outter'], $this->Form->postLink($title, $url, $options, $confirmMessage));
            } else {
                return $this->Form->postLink($title, $url, $options, $confirmMessage);
            }
        }
        return '';
    }
    

    /**
     * isAuthorized
     * 
     * Helper function returns true if the currently authenticated user has permission 
     * to access the controller:action specified by $controllerName:$actionName
     * @return boolean isAuthorized
     * @param $controllerName Object
     * @param $actionName Object
     */
    function isAuthorized($authorize, $record_id = null) {
        return $this->component->isAuthorized($authorize, $record_id);
    }

}

?>