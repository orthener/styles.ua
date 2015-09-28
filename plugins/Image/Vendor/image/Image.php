<?php
define('ASIDO_GD_JPEG_QUALITY', 95);

require('class.asido.php');

Asido::driver('gd');		
Asido::driver('gd_hack');
		
class Image {
    
    
     /**
     * Maintain aspect ratio (default: true)
     *
     * @var boolean
     * @access public
     * 
     */
    var $maintainAspectRatio = true;

    /**
     * Default size for rescale
     *
     * @var array
     * @access public
     * 
     */
    var $imageOptions = array('width'=>96, 'height'=>96);


    var $lastDstSize = null;

    /**
     * Creates thumbnail from selected image and saves it in file returned by function {@link getThumbPath()}
     * 
     * @param string $fileNameSrc Source file name relative to WWW_ROOT."files"
     * @param mixed $imageOptions array containing min one value for one of keys named 'width' or 'height', or null in order to use default values 
     * @param mixed $params array containing options
     * @return mixed url relative to WEBROOT on success, or false on failure
     */

    function createThumb($fileNameSrc, $imageOptions = null, $params = null){
        if($imageOptions === null){
            $imageOptions = $this->size;
        }
        $fileNameDst = $this->getThumbPath($fileNameSrc, $imageOptions);

        return $this->resizeImage($fileNameSrc, $imageOptions, $params, $fileNameDst);
    }

    /**
     * Creates thumbnail from selected image and saves it in selected location, or overwrite source (default)
     * 
     * @param string $fileNameSrc Source file name relative to WWW_ROOT."files"
     * @param mixed $imageOptions array containing min one value for one of keys named 'width' or 'height', or null in order to use default values 
     * @param mixed $params array containing options
     * @param string $fileNameDst Destination file name relative to WWW_ROOT."files" - if not set, uses $fileNameSrc
     * @return mixed url relative to WEBROOT on success, or false on failure
     */

    function resizeImage($fileNameSrc, $imageOptions = null, $params = null, $fileNameDst = null){
        if($imageOptions === null){
            $imageOptions = $this->size;
        }
        
        //jesli nie podano pliku przeznaczenia - przeskaluj zrodlo
        $fileNameDst = ($fileNameDst)?$fileNameDst:$fileNameSrc;
        
        $absolutePath = (!empty($params['absolutePath']))?true:false;

        $urlDst = $this->getImageUrl($fileNameDst);
        
        if(!$absolutePath){
            //create full path
            $fileNameSrc = WWW_ROOT.$fileNameSrc;
            $fileNameDst = WWW_ROOT.$fileNameDst;
        }
        //check if the src file exists
        if (!is_array($imageOptions)){ 
            $this->log("IMAGE VENDOR: Options is not array: ".$imageOptions.".");
            return false; 
        }


        //check if the src file exists
        if (!file_exists($fileNameSrc) || !is_file($fileNameSrc) || !is_readable($fileNameSrc)){ 
                //debug('Source file not exist, or is not readable.');
                //debug($fileNameSrc);
                $this->log("IMAGE VENDOR: Source file ".$fileNameSrc." not exist, or is not readable.");
                return false; 
        }
        //check if the dest dir is writable;
        $destDir = dirname($fileNameDst);
        if (!is_writeable($destDir)) {
            $result = @mkdir($destDir, 0777) | @chmod($destDir, 0777);
            if (!$result) {
//                debug('Destination dir is not writable.');
                $this->log('IMAGE VENDOR: Destination dir '.$destDir.' is not writable.');
                return false;
            }
        }

        $srcData = list($srcWidth, $srcHeight, $srcImageType) = getimagesize($fileNameSrc);

        if($srcImageType != IMAGETYPE_GIF && $srcImageType != IMAGETYPE_JPEG && $srcImageType != IMAGETYPE_PNG){
            $this->log('IMAGE VENDOR: Not supported image type: "'.$srcImageType.'".');
            return false;
        }

       $result = $this->image($fileNameSrc, $fileNameDst);
       
       
       if(!empty($imageOptions['watermark'])){
            if($this->imageExists($imageOptions['watermark'])){
                $fileWatermark = WWW_ROOT.$imageOptions['watermark'];
                $fileWatermark = str_replace(array('/','//','\\','\\\\'),DS,$fileWatermark);
                $this->watermark($fileWatermark); 
            }
	   } 
       if(!empty($imageOptions['grayscale'])){
            $this->grayscale();
       }
       
       if(!empty($imageOptions['frame'])){
            $color = $this->hex2RGB($imageOptions['frame']);
            
            $this->frame($imageOptions['width'], $imageOptions['height'], $color);
       }
       
       if(!empty($imageOptions['crop']) or isset($imageOptions['x']) or isset($imageOptions['y'])){
            list($srcX, $srcY, $destWidth, $destHeight) = $this->cropCords($imageOptions,$srcData);
            $this->crop($srcX, $srcY, $destWidth, $destHeight);
       }
       
	   $this->resize($imageOptions['width'],$imageOptions['height']);
	   
	   $this->save();

       
        if(!$result){
            $this->log('IMAGE VENDOR: Saving file '.$fileNameDst.' failed.');
            return false;
        }

        @chmod($fileNameDst, 0777); 


        return $urlDst;
    }
    function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
        $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
        $rgbArray = array();
        if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
            $colorVal = hexdec($hexStr);
            $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
            $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
            $rgbArray['blue'] = 0xFF & $colorVal;
        } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
            $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
            $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
            $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
        } else {
            return false; //Invalid hex color code
        }
        $color =  $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
        return $this->Color($color['red'],$color['green'],$color['blue']);
    } 
    
    

    /**
     * Builds default path to thumbnail
     * 
     * Thumbs are in default saved in subfolder of folder containing original file. 
     * This subfolder is named thumbsAAxBB where AA is width, and BB is height. 
     * If width or height is not specified, is ommited in folder name.
     * 
     * @param string $fileNameSrc Source file name relative to WWW_ROOT."files/"
     * @param array $imageOptions array containing min one value for one of keys named 'width' or 'height'
     * @return mixed String containing path relative to WWW_ROOT."files/" on success, or boolean false on failure
     */
    function getThumbPath($fileNameSrc, $imageOptions){
        if(empty($imageOptions['width']) && empty($imageOptions['height'])){
            return false;
        }
        
        if(!empty($imageOptions['crop']) or isset($imageOptions['x']) or isset($imageOptions['y'])){
            
            $cropName = !isset($imageOptions['x'])?'':'x'.$imageOptions['x'];
            $cropName .= !isset($imageOptions['y'])?'':'y'.$imageOptions['y'];
            
            if(!isset($imageOptions['x']) and !isset($imageOptions['y'])){
                $cropName = empty($imageOptions['crop'])?'':'c_'.$imageOptions['crop'];
            }
        }
        
        $srcFile = basename($fileNameSrc);
        $srcDir = dirname($fileNameSrc);
        
        $folder = 'thumbs_';
        $folder .= (empty($imageOptions['width']))?'':'w'.$imageOptions['width'];
        $folder .= (empty($imageOptions['height']))?'':'h'.$imageOptions['height'];
        $folder .= (empty($imageOptions['frame']))?'':'f'.substr($imageOptions['frame'],1);
        $folder .= (empty($cropName))?'':$cropName;
        $fileNameDest = $srcDir.DS.$folder.DS.$srcFile;
        return $fileNameDest;
    }

    /**
     * Return thumbnail URL
     * 
     * @param string $fileNameDst returned by {@link getThumbPath()}
     * @return boolean Return thumbnail URL
     */
    function getImageUrl($fileNameDst){
        return str_replace(DS, '/', $fileNameDst);
    }

    /**
     * Check if defined thumbnail is present in given location
     * 
     * @param string $fileNameDst returned by {@link getThumbPath()}
     * @return boolean Return true if file exists.
     */
    function imageExists($fileNameDst){
        $fileNameDst = WWW_ROOT.$fileNameDst;
        //check if the src file exists
        if (!file_exists($fileNameDst) || !is_file($fileNameDst) || !is_readable($fileNameDst)){ 
            return false; 
        }
        return true;
    }

    function imageSize($fileName){
        $fileName = WWW_ROOT.$fileName;
        return @getimagesize($fileName);
    }
    
    function cropCords($imageOptions = array(), $srcData = array()){
        
        $srcX = $srcY = 0;
        
        list($srcWidth, $srcHeight) = $srcData;
        
        $ratioX = $imageOptions['width']/$srcWidth;
        $ratioY = $imageOptions['height']/$srcHeight;
        
        
        
        $ratio = max($ratioX, $ratioY);
        (int)$newSrcHeight = ceil($imageOptions['height']/$ratio);
        (int)$newSrcWidth = ceil($imageOptions['width']/$ratio);

        if ($ratioX > $ratioY){  
            $srcY = ceil(($srcHeight - $newSrcHeight)/2);
        } else {
            $srcX = ceil(($srcWidth - $newSrcWidth)/2);
        }

        if(!empty($imageOptions['crop']) and $imageOptions['crop'] === 'top'){
           $srcY = 0;
        }
        if(!empty($imageOptions['crop']) and $imageOptions['crop'] === 'bottom'){
           $srcY = abs(ceil($srcHeight - $newSrcHeight));
        }
        
        if(!empty($imageOptions['crop']) and $imageOptions['crop'] === 'left'){
           $srcX = 0; 
        }
        
        if(!empty($imageOptions['crop']) and $imageOptions['crop'] === 'right'){
           $srcX = abs(ceil($srcWidth - $newSrcWidth));
        }
        if(isset($imageOptions['x'])){
            $srcX = $imageOptions['x'];
        }

        if(isset($imageOptions['y'])){
            $srcY = $imageOptions['y'];
        }

        //zabezpieczenie przed przekroczeniem zakresu
        $srcX = ($newSrcWidth + $srcX > $srcWidth)?$srcWidth-$newSrcWidth:$srcX;
        $srcY = ($newSrcHeight + $srcY > $srcHeight)?$srcHeight-$newSrcHeight:$srcY;
  
        return array($srcX, $srcY, $newSrcWidth, $newSrcHeight);
    }
    
    function log($message){
        CakeLog::write('pluginImage', $message."\n");
    }
    
    
 /** nowy helper*/   
    
	public $res=false;
	public $width=0;
	public $height=0;
	
	function load($source=null, $target=null) 
	{
		if (!file_exists($source))
			return false;
		else
		{
			$a=getimagesize($source);
			$this->width=$a['0'];
			$this->height=$a['1'];			
			return $this->image($source, $target);
		}
	}

	function image($source=null, $target=null) 
	{
		$this->res=Asido::image($source, $target);
		return $this->res;
	}
	
	function save($overwrite_mode = ASIDO_OVERWRITE_ENABLED) 
	{
		return $this->res->save($overwrite_mode);
	}

	function resize($width, $height, $mode=ASIDO_RESIZE_PROPORTIONAL) 
	{
		return Asido::resize($this->res, $width, $height, $mode);
	}

	function width($width) 
	{
		return Asido::width($this->res, $width);
	}

	function height($height) 
	{
		return Asido::height($this->res, $height);
	}

	function stretch($width, $height) 
	{
		return Asido::stretch($this->res, $width, $height);
	}

	function fit($width, $height) 
	{
		return Asido::fit($this->res, $width, $height);
	}

	function frame($width, $height, $color=null) 
	{
		return Asido::frame($this->res, $width, $height, $color);
	}
	
	function convert($mime_type) 
	{
		return Asido::convert($this->res, $mime_type);
	}
	
	function watermark($watermark_image,
			$position = ASIDO_WATERMARK_BOTTOM_RIGHT,
			$scalable = ASIDO_WATERMARK_SCALABLE_ENABLED,
			$scalable_factor = ASIDO_WATERMARK_SCALABLE_FACTOR
			)
	{
		return Asido::watermark($this->res, $watermark_image, $position, $scalable, $scalable_factor);
	}

	function grayscale() 
	{
		return Asido::grayscale($this->res);
	}

	function rotate($angle, $color=null) 
	{
		return Asido::rotate($this->res, $angle, $color);
	}

	function color($red, $green, $blue) 
	{
		return Asido::color($red, $green, $blue);
	}

	function copy($applied_image, $x, $y) 
	{
		return Asido::copy($this->res, $applied_image, $x, $y);
	}
	
	function crop($x, $y, $width, $height)
	{
		return Asido::crop($this->res, $x, $y, $width, $height);
	}

	function flip()
	{
		return Asido::flip($this->res);
	}

	function flop() 
	{
		return Asido::flop($this->res);
	}
	
	function zoom($new_width,$new_height ) 
	{
		$width = $this->width;
		$height = $this->height;
		$cmp_x = $width  / $new_width;
		$cmp_y = $height / $new_height;
		if ( $cmp_x > $cmp_y ) {
			$this->height($new_height);
			$t_new_width=round($width*$new_height/$height);			
			$src_x = round( ($t_new_width - $new_width) / 2 );
			$this->crop($src_x, 0, $new_width, $new_height);
		}
		elseif ( $cmp_y > $cmp_x ) {
			$this->width($new_width);
			$t_new_height=round($height*$new_width/$width);			
			$src_y = round( ($t_new_height - $new_height) / 2 );
			$this->crop(0, $src_y, $new_width, $new_height);
		}
		else $this->resize($new_width,$new_height);
	}
	
	function min($width, $height)
	{
		if ($this->width<$width)
			return false;
		if ($this->height<$height)
			return false;
		return true;
	}
}
?>