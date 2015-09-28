<?php
/**
 * Created: Thu Jan 10 10:00:49 GMT 2008
 * 
 * PHP versions 4 and 5
 *
 * Copyright (c) Aydmultimedia <adziki@aydmultimedia.com>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 *
 * @copyright        Copyright (c) 2008, Aydmultimedia
 * @link            http://aydmultimedia.com/
 * @link            http://dziki.eu/
 * @license            http://www.opensource.org/licenses/mit-license.php The MIT License
 */

class Image extends Object{

    /**
     * Maintain aspect ratio (default: true)
     *
     * @var boolean
     * @access public
     * 
     */
    var $maintainAspectRatio = true;

    /**
     * Crop to fit in new aspect ratio (default: false)
     *
     * @var boolean
     * @access public
     * 
     */
    var $crop = true;

    /**
     * Background color
     *
     * @var array
     * @access public
     * 
     */
    var $backgroundColor = array();

    /**
     * Determines whether or not rescale image to higher size than original size
     *
     * @var bool
     * @access public
     * 
     */
    var $rescaleUp = false;

    /**
     * The quality of created JPEG file. Allowed values: 0 - 100
     *
     * @var int
     * @access public
     * 
     */
    var $jpgQuality = 100;

    /**
     * PNG Compression level: from 0 (no compression) to 9.
     *
     * @var int
     * @access public
     * 
     */
    var $pngCompression = null;

    /**
     * Bitmask field which may be set to any combination of the PNG_FILTER_XXX constants.
     *
     * @var int
     * @access public
     * 
     */
    var $pngFilter = null;
 
    /**
     * Default model name
     *
     * @var int
     * @access public
     * 
     */
    var $model = null;

    /**
     * Default size for rescale
     *
     * @var array
     * @access public
     * 
     */
    var $size = array('width'=>96, 'height'=>96);


    var $lastDstSize = null;

    /**
     * Creates thumbnail from selected image and saves it in file returned by function {@link getThumbPath()}
     * 
     * @param string $fileNameSrc Source file name relative to WWW_ROOT."files"
     * @param mixed $size array containing min one value for one of keys named 'width' or 'height', or null in order to use default values 
     * @param mixed $params array containing options
     * @return mixed url relative to WEBROOT on success, or false on failure
     */

    function createThumb($fileNameSrc, $size = null, $params = null){
        if($size === null){
            $size = $this->size;
        }
        $fileNameDst = $this->getThumbPath($fileNameSrc, $size);
        return $this->resizeImage($fileNameSrc, $size, $params, $fileNameDst);
    }

    /**
     * Creates thumbnail from selected image and saves it in selected location, or overwrite source (default)
     * 
     * @param string $fileNameSrc Source file name relative to WWW_ROOT."files"
     * @param mixed $size array containing min one value for one of keys named 'width' or 'height', or null in order to use default values 
     * @param mixed $params array containing options
     * @param string $fileNameDst Destination file name relative to WWW_ROOT."files" - if not set, uses $fileNameSrc
     * @return mixed url relative to WEBROOT on success, or false on failure
     */

    function resizeImage($fileNameSrc, $size = null, $params = null, $fileNameDst = null){
        if($size === null){
            $size = $this->size;
        }
        
        //jesli nie podano pliku przeznaczenia - przeskaluj zrodlo
        $fileNameDst = ($fileNameDst)?$fileNameDst:$fileNameSrc;
        
        $absolutePath = (!empty($params['absolutePath']))?true:false;
        $jpgQuality = (!empty($params['quality']))?$params['quality']:$this->jpgQuality;
        $jpgQuality = (!empty($params['jpgQuality']))?$params['jpgQuality']:$jpgQuality;
        
        $urlDst = $this->getImageUrl($fileNameDst);
        
        if(!$absolutePath){
            //create full path
            $fileNameSrc = WWW_ROOT."files".DS.$fileNameSrc;
            $fileNameDst = WWW_ROOT."files".DS.$fileNameDst;
        }

        //debug($fileNameSrc);

        //check if the src file exists
        if (!file_exists($fileNameSrc) || !is_file($fileNameSrc) || !is_readable($fileNameSrc)){ 
            $tempArray = explode('webroot'.DS.'files'.DS,$fileNameSrc);
            $tempArray = explode(DS,$tempArray[1]);
            //debug($tempArray);
            $fileNameSrc = WWW_ROOT."files".DS.$tempArray[0].DS.'brak_zdjecia.png';
            
            if (!file_exists($fileNameSrc) || !is_file($fileNameSrc) || !is_readable($fileNameSrc)){ 
                //debug('Source file not exist, or is not readable.');
                $this->log("IMAGE VENDOR: Source file ".$fileNameSrc." not exist, or is not readable.");
                return false; 
            }
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

        $destX = 0;
        $destY = 0;
        $srcX = 0;
        $srcY = 0;
        if(empty($size['width']) || empty($size['height'])){
            //Simple resample. One dimension is computed from other.
            if(empty($size['width'])){
                $destHeight = $size['height'];
                $destWidth = number_format(($srcWidth/$srcHeight)*$size['height'],0,',','');
            } elseif(empty($size['height'])){
                $destWidth = $size['width'];
                $destHeight = number_format(($srcHeight/$srcWidth)*$size['width'],0,',','');
            }
        } elseif(!$this->maintainAspectRatio) {
            $destWidth = $size['width'];
            $destHeight = $size['height'];
        }
        
        elseif($this->crop) {
            list($srcX, $srcY, $destWidth, $destHeight, $srcWidth, $srcHeight) = $this->cropCords($size,$srcData);
            
        } elseif(empty($this->backgroundColor)){
            $destWidth = $size['width'];
            $destHeight = $size['height'];

            $ratioX = $size['width']/$srcWidth;
            $ratioY = $size['height']/$srcHeight;

//             $co_x = $max_width/$width;
//             $co_y = $max_height/$height;
            
            if ( ($srcWidth<=$destWidth) && ($srcHeight<=$destHeight) && $this->rescaleUp == false){
                $destWidth = $srcWidth;
                $destHeight = $srcHeight;
            }
            elseif (($ratioX * $srcHeight)< $destHeight){
                $destHeight = ceil($ratioX * $srcHeight);
            }
            else {
                $destWidth = ceil($ratioY * $srcWidth);
            }
        }

        $dest = imagecreatetruecolor($destWidth, $destHeight);
        $this->lastDstSize = array(0=>$destWidth, 1=>$destHeight, 2=>$srcImageType, 3=>' height="'.$destHeight.'" width="'.$destWidth.'" ');
//        imageantialias($dest, TRUE);

        switch($srcImageType) {
            case IMAGETYPE_GIF:
                $src = imagecreatefromgif($fileNameSrc);
                break;
            case IMAGETYPE_JPEG:
                $src = imagecreatefromjpeg($fileNameSrc);
                break;
            case IMAGETYPE_PNG:
                imagealphablending($dest, false); // setting alpha blending on
                imagesavealpha($dest, true);
                $src = imagecreatefrompng($fileNameSrc);
                break;
            default:
                $this->log('IMAGE VENDOR: Not supported image type: "'.$srcImageType.'".');
                return false;
                break;
        }
//      imagecopyresampled(  dst,  src,  dst_x,  dst_y, src_x, src_y,      dst_w,   int dst_h, int src_w, int src_h )
        if(!imagecopyresampled($dest, $src, $destX, $destY, $srcX, $srcY, $destWidth, $destHeight, $srcWidth, $srcHeight)){
            $this->log('IMAGE VENDOR: Resampling failed: imagecopyresampled($dest, $src, $destX, $destY, $srcX, $srcY, $destWidth, $destHeight, $srcWidth, $srcHeight)');
            $this->log("IMAGE VENDOR: With this  params: imagecopyresampled(dest, src, $destX, $destY, $srcX, $srcY, $destWidth, $destHeight, $srcWidth, $srcHeight)");
            return false;
        }
        imagedestroy($src);
        
        switch($srcImageType) {
            case IMAGETYPE_GIF:
                $result = imagegif($dest,$fileNameDst);
                break;
            case IMAGETYPE_JPEG:
                $result = imagejpeg($dest,$fileNameDst, $jpgQuality);
                break;
            case IMAGETYPE_PNG:
                $result = imagepng($dest,$fileNameDst);
        }

        imagedestroy($dest);
        
        if(!$result){
            $this->log('IMAGE VENDOR: Saving file '.$fileNameDst.' failed.');
            return false;
        }

        @chmod($fileNameDst, 0777); 


        return $urlDst;
    }

    /**
     * Builds default path to thumbnail
     * 
     * Thumbs are in default saved in subfolder of folder containing original file. 
     * This subfolder is named thumbsAAxBB where AA is width, and BB is height. 
     * If width or height is not specified, is ommited in folder name.
     * 
     * @param string $fileNameSrc Source file name relative to WWW_ROOT."files/"
     * @param array $size array containing min one value for one of keys named 'width' or 'height'
     * @return mixed String containing path relative to WWW_ROOT."files/" on success, or boolean false on failure
     */
    function getThumbPath($fileNameSrc, $size){
        if(empty($size['width']) && empty($size['height'])){
            return false;
        }
        $srcFile = basename($fileNameSrc);
        $srcDir = dirname($fileNameSrc);
        $folder = 'thumbs';
        $folder .= (empty($size['width']))?'':$size['width'];
        $folder .= 'x';
        $folder .= (empty($size['height']))?'':$size['height'];
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
        return Router::url('/files/'.str_replace(DS, '/', $fileNameDst), false);
    }

    /**
     * Check if defined thumbnail is present in given location
     * 
     * @param string $fileNameDst returned by {@link getThumbPath()}
     * @return boolean Return true if file exists.
     */
    function imageExists($fileNameDst){
        $fileNameDst = WWW_ROOT."files".DS.$fileNameDst;
        //check if the src file exists
        if (!file_exists($fileNameDst) || !is_file($fileNameDst) || !is_readable($fileNameDst)){ 
            return false; 
        }
        return true;
    }

    function imageSize($fileName){
        $fileName = WWW_ROOT."files".DS.$fileName;
        return @getimagesize($fileName);
    }
    
    function cropCords($size = array(), $srcData = array()){
        
        $destWidth = $size['width'];
        $destHeight = $size['height'];
        
        $srcX = $srcY = 0;
        
        list($srcWidth, $srcHeight) = $srcData;
        
        $ratioX = $size['width']/$srcWidth;
        $ratioY = $size['height']/$srcHeight;
        
        (int)$newSrcHeight = ceil($size['height']/$ratioY);
        (int)$newSrcWidth = ceil($size['width']/$ratioX);
        
        
        if ($ratioX > $ratioY){  
            $srcY = ceil(($srcHeight - $newSrcHeight)/2);
        } else {
            $srcX = ceil(($srcWidth - $newSrcWidth)/2);
        }
        
        if($this->crop == 'top'){
           $srcY = 0;
        }
        if($this->crop == 'bottom'){
           $srcY = ($srcHeight - $newSrcHeight);
        }
        if($this->crop == 'left'){
           $srcX = 0; 
        }
        if($this->crop == 'right'){
           $srcX = ceil($srcWidth - $newSrcWidth);
        }
        
        if(!empty($size['x'])){
            $srcX = ceil($size['x']/(1+$ratioX));
        }
        debug($size);
        if(!empty($size['y'])){
            $srcY = ceil($size['y']/(1+$ratioY));
        }
        
        $srcWidth = $newSrcWidth;
        $srcHeight = $newSrcHeight;
        $srcWidth = $srcHeight = min($newSrcWidth, $newSrcHeight);
        
        return array($srcX, $srcY, $destWidth, $destHeight, $srcWidth, $srcHeight);
    }
        
}
?>