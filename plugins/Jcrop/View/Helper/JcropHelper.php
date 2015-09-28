<?php
/**
 * CakePHP Jcrop Plugin
 *

 *
 * @copyright 2011 - 2011, Cake Development Corporation (http://cakedc.com)
 * @link      http//feb.net.pl
 * @package   plugins.jcrop
 * @license   FEB
 */

/**
 * Short description for class.
 *
 * @package  plugins.jcrop.views.helpers
 */

class JcropHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 * @access public
 */
	public $helpers = array('Html','Js');

 

    public function edit($model = null, $field = null, $id = false) { ?>
		 
        <div id="editCrop"></div>
        
        <script type="text/javascript">
            function editCrop(){
              <?php 
              echo $this->Js->request(
                    array('controller'=>'jcrops','action'=>'edit','plugin'=>'jcrop','admin'=>false, $model, $field, $id), 
                    array('update'=>'#editCrop',
                        'complete'=>'jQuery("#editCrop").dialog({width:800, height:500});'
                    )
              ); 
              ?>;  
            }	
        </script>
<?php	}

/**
 * beforeRender callback
 *
 * @return void
 * @access public
 */
	public function beforeRender() {
		$this->Html->script('/jcrop/js/jquery.Jcrop.min', array('inline'=>false));
		$this->Html->css('/jcrop/css/jquery.Jcrop',null, array('inline'=>false));
		$this->Html->css('/jcrop/css/jcrop',null, array('inline'=>false));
	}
}
?>