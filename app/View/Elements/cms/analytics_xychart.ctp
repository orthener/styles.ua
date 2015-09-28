<?php


$xychart = $this->requestAction(array('admin' => 'admin','prefix'=>'admin', 'controller' => 'panel', 'action' => 'chart'));

if(!empty($xychart)){
        
?>
<div>
<h2><span>Użytkownicy i odsłony</span></h2>
<div style="margin: 10px 0;" >
<?php
    
        $views = Set::extract($xychart, '{n}.GoogleAnalyticsAccount.metrics.0.value');
        $viewers = Set::extract($xychart, '{n}.GoogleAnalyticsAccount.metrics.1.value');

        $max = max(array_merge($viewers, $views));
        $min = min(array_merge($viewers, $views));

        $min = $min>0?$min:1;
        $max = $max>0?$max:1;

        $min_log = floor(log10($min));
        
        $max_log = floor(log10($max));

//        round($min, -floor(log10($min)))
        $max = round($max, -$max_log) + pow(10,$max_log);  //

        $min = 10*$min_log; //round($min, -$min_log);
        $scale = pow(10,round(log10($max-$min))) /10;


    
//     for($i=0.15; $i<1000000000; $i*=10){
//         echo log10($i).'<br />';
//     }
//     exit;
    
        $labels = Set::extract($xychart, '{n}.GoogleAnalyticsAccount.dimensions.value');
        foreach($labels AS &$label){
            $labelTime = strtotime($label);
            $label = date('j.m.Y\r', $labelTime);
        }
        
        
        echo $this->FlashChart->begin();
    //    $this->FlashChart->setTitle('Odwiedziny w ostatnim miesiącu','{color:#880a88;font-size:20px;padding-bottom:20px;}');
        $this->FlashChart->setBgColour('#EBEBEB');
    //    $this->FlashChart->setLegend('x','Dato');
    //     $this->FlashChart->setLegend('y','Skritt', '{color:#AA0aFF;font-size:40px;}' );
    
    //    debug($labels); exit;
    
    // to działa tylko na słupkowym:
    //    $this->FlashChart->setToolTip('Cokolwiek #val#', array('colour' => '#6E604F'));
    
        $this->FlashChart->axis('y', array('range'=>array($min, $max, $scale), 'tick_length'=>15));
        $this->FlashChart->setData($views,'{n}', null, 'Views');
        $this->FlashChart->axis('x',array('labels' => $labels),array('rotate' => -45));
     
    //    $this->FlashChart->setLabelsPath('{n}.dimensions.value');
        $this->FlashChart->setData($viewers,'{n}', '{n}.GoogleAnalyticsAccount.dimensions.value', 'Viewers');
        $this->FlashChart->chart('area',array('colour'=>'#4f4f51', 'fill_colour' => '#5A5A5A', 'fill_alpha' => '0.5', 'width' => 4,  'text' => 'Unikalni użytkownicy'),'Viewers');
        echo $this->FlashChart->chart('line',array('colour'=>'#f18e00', 'width' => 4, 'text' => 'Odsłony'),'Views');
    
        echo $this->FlashChart->render();

?>
</div>
</div>
<?php


}

