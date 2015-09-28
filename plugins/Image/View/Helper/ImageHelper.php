<?php
/**
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

/** /app/View/Helper/image.php */
 

class ImageHelper extends AppHelper {

    var $helpers = array('Html');
    /**
     * Image class holder
     *
     * @var boolean
     * @access public
     * 
     */
    var $image = null;
    var $lastImageSize = null;

    function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
        App::import('Vendor', 'Image.image/Image');
		$this->image=new Image();
	}

    function thumb($file, $imageOptions = null, $options = array(), $forceRefresh = false){
        //$model = strtolower($model);
        $fileNameSrc = str_replace('/',DS,$file);//($model)?$model.DS.$file:$file;
        $fileNameDst = $this->image->getThumbPath($fileNameSrc, $imageOptions);

        $noimage = false;
        if(!empty($options['noimage'])) {
            $noimage = $options['noimage'];
            unset($options['noimage']);
        }
        if($forceRefresh || !$this->image->imageExists($fileNameDst)){
            if($noimage && !$this->image->imageExists($fileNameSrc)){
                return $this->Html->image('stop.jpg', array('alt'=> 'Dostęp zabroniony'));
            } elseif(!$this->image->imageExists($fileNameSrc)) {
                //$fileArray = explode(DS, $fileNameSrc);
                //$fileArray[count($fileArray)-1] = 'brak_zdjecia.png';
                //$fileNameSrc = implode(DS,$fileArray);
                $fileNameSrc  = DS.'image'.DS.'img'.DS.'empty_image.gif';
            }
            $src = $this->image->createThumb($fileNameSrc, $imageOptions);

            if(!empty($options['valign'])){
                $this->lastImageSize = $this->image->lastDstSize;
            } else {
                $this->lastImageSize = null;
            }
        } else {
            $src = $this->image->getImageUrl($fileNameDst);
        // $src = $fileNameDst;
            if(!empty($options['valign'])){
                $this->lastImageSize = $this->image->imageSize($fileNameDst);
            } else {
                $this->lastImageSize = null;
            }
        }
        $class='thumbnail';
        if(empty($options['class'])) {
            $options['class'] = 'thumbnail';
        }
        if(empty($options['alt'])) {
            $options['alt'] = $file;
        }
        
        if(!empty($options['valign'])){
            $vMargin = $imageOptions['height']-(($this->lastImageSize[1])?$this->lastImageSize[1]:$imageOptions['height']);
            if($options['valign'] == 'middle' && $vMargin){
                $options['style'] = empty($options['style'])?'':$options['style'].'; ';
                $vMarginTop = floor($vMargin/2);
                $options['style'] .= 'margin-top:'.$vMarginTop.'px; ';
                $options['style'] .= 'margin-bottom:'.($vMargin-$vMarginTop).'px; ';
            } elseif($options['valign'] == 'bottom' && $vMargin){
                $options['style'] = empty($options['style'])?'':$options['style'].'; ';
                $vMargin = $imageOptions['height']-$this->lastImageSize[1];
                $options['style'] .= 'margin-top:'.$vMargin.'px; ';
            }
            unset($options['valign']);
        }
        $heightImage = isset($this->lastImageSize[3])?' '.$this->lastImageSize[3].' ':'';
        $image = $this->Html->image($src, $options);
//        debug($image);
        return $image;

    }
    
    
   
    
}
 
?>
