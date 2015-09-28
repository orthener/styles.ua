<?php

/**
 * CakePHP Fancybox Plugin
 *

 *
 * @copyright 2009 - 2010, Cake Development Corporation (http://cakedc.com)
 * @link      http//feb.net.pl
 * @package   plugins.fancybox
 * @license   FEB
 */

/**
 * Short description for class.
 *
 * @package  plugins.fancybox.views.helpers
 */
class FancyboxHelper extends AppHelper {

    /**
     * Other helpers used by FormHelper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html', 'Js');

    /**
     * 
     *
     * @var array
     * @access public
     */
    public $configs = array();

    /**
     * 
     *
     * @var array
     * @access protected
     */
    protected $_defaults = array('transitionIn' => 'elastic',
        'transitionOut' => 'elastic',);

    public function init($element, $options = array(''), $inline = false) {
        if (is_string($options)) {
            if (isset($this->configs[$options])) {
                $options = $this->configs[$options];
            }
        }
        $options = array_merge($this->_defaults, $options);

        $lines = $this->Js->object($options);

        echo $this->Html->scriptBlock('jQuery(document).ready(function() {' . $element . '.fancybox(' . $lines . ');});' . "\n", array('inline' => $inline));
    }

    /**
     * beforeRender callback
     *
     * @return void
     * @access public
     */
    public function beforeRender() {
//		$this->Html->script('/js/jquery.fancybox-1.3.4.pack', array('inline'=>false));
        $this->Html->script('jquery.fancybox', array('inline' => false));
        $this->Html->script('jquery.fancybox.pack', array('inline' => false));
        $this->Html->css('jquery.fancybox', null, array('inline' => false));
//		$this->Html->css('/css/jquery.fancybox-1.3.4.css',null, array('inline'=>false));
    }

}

?>