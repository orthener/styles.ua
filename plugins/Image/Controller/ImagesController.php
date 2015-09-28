<?php
class ImagesController extends AppController {

	public $layout = 'admin';
	public $components = array('Image.Image');
    public $helpers = array('Image.Image');
    
	function admin_index(){   
	   
	   $basePath = APP.'webroot'.DS.'img'.DS;
	   $imageLoad = $basePath.'test.png';
	   $imageResult = $basePath.'test2.png';
	   
	   $this->Image->image($imageLoad, $imageResult);
	   $this->Image->grayscale();
	   $this->Image->save();
	   $test = scandir($basePath);
	   foreach($test as $file){
	       //debug($file);
	   }
	}
}
?>