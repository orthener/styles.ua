<?php
/**
 * Umożliwia ładowanie sterowników, które udostępniają funkcje do obróbki grafiki. Dostępne są GD2, Magick Wand, Image Magick.
 * Biblioteka Asido
Dostępne są funkcje:

    resize – skalowanie proporcjonalne
    width – dopasowanie do szerokości
    height – dopasowanie do wysokości
    stretch – rozciąganie
    zoom – dopasowanie do podanych rozmiarów, przez obcięcie wystających boków
    fit – skalowanie, gdy obrazek „zmieści” się w podanych wymiarach
    frame – skalowanie z efektem ramki (wypełnienie kolorem, gdy obrazek się nie mieści)
    convert – zmiana formatu
    watermark – znak wodny
    grayscale – zmiana kolorów do odcieni szarości
    rotate – rotacja
    copy – kopiowanie podanego obrazu do załadowanego
    crop – kadrowanie
    flip – odbicie w pionie
    flop – odbicie w poziomie
    save – zapisanie obrazka
    image – załadowanie obrazu
    load – również załadowanie obrazu, opisane poniżej

Dodatkowo mamy również dostęp do pól:

    width – szerokość załadowanego obrazka
    height – wysokość obrazka
*/

class ImageComponent  extends Object  {
    
	var $controller;
	var $image;
			
	function initialize(){
	   
	}
	function beforeRender(){
	   
	}
	function shutdown(){
	}
	function beforeRedirect(){
	   
	}
	
    function startup(&$controller, $settings = array()) 
    { 
        $this->controller = $controller; 
		App::import('Vendor', 'Image.image/Image');
		$this->image=new Image();
    } 

	function load($source=null, $target=null) 
	{
		return $this->image->load($source, $target);
	}

	function image($source=null, $target=null) 
	{
		return $this->image->image($source, $target);
	}
	
	function save($overwrite_mode = ASIDO_OVERWRITE_ENABLED) 
	{
		return $this->image->save($overwrite_mode);
	}

	function resize($width, $height, $mode=ASIDO_RESIZE_PROPORTIONAL) 
	{
		return $this->image->resize($width, $height, $mode=ASIDO_RESIZE_PROPORTIONAL);
	}

	function width($width) 
	{
		return $this->image->width($width);
	}

	function height($height) 
	{
		return $this->image->height($height);
	}

	function stretch($width, $height) 
	{
		return $this->image->stretch($width, $height);
	}

	function fit($width, $height) 
	{
		return $this->image->fit($width, $height) ;
	}

	function frame($width, $height, $color=null) 
	{
		return $this->image->frame($width, $height, $color);
	}
	
	function convert($mime_type) 
	{
		return $this->image->convert($mime_type) ;
	}
	
	function watermark($watermark_image,
			$position = ASIDO_WATERMARK_BOTTOM_RIGHT,
			$scalable = ASIDO_WATERMARK_SCALABLE_ENABLED,
			$scalable_factor = ASIDO_WATERMARK_SCALABLE_FACTOR
			)
	{
		return $this->image->watermark($watermark_image,$position,$scalable,$scalable_factor);
	}

	function grayscale() 
	{
		return $this->image->grayscale();
	}

	function rotate($angle, $color=null) 
	{
		return $this->image->rotate($angle, $color) ;
	}

	function color($red, $green, $blue) 
	{
		return $this->image->color($red, $green, $blue) ;
	}

	function copy($applied_image, $x, $y) 
	{
		return $this->image->copy($applied_image, $x, $y);
	}
	
	function crop($x, $y, $width, $height)
	{
		return $this->image->crop($x, $y, $width, $height);
	}

	function flip()
	{
		return $this->image->flip();
	}

	function flop() 
	{
		return $this->image->flop() ;
	}

	function zoom($new_width,$new_height) 
	{
		return $this->image->zoom($new_width,$new_height);
	}
	
	function min($width, $height)
	{
		return $this->image->min($width, $height);
	}
}
?>