<div class="clearfix">
<h2>&nbsp;</h2>
<div style="float:left; width: 210px;">
<?php  
    $chart = $this->requestAction(array('admin' => 'admin', 'prefix'=>'admin', 'controller' => 'panel', 'action' => 'chart2'));
    $newchart = array();
    $default = null;
    foreach($chart AS $i => $value){
        $n = $i;
        if(!empty($value['GoogleAnalyticsAccount']['dimensions']['value'])){
            switch($value['GoogleAnalyticsAccount']['dimensions']['value']){
                case '(none)':
                    $value['GoogleAnalyticsAccount']['label'] = __("Odwiedziny bezpośrednie");
                    $newchart[] = $value;
                    break;
                case 'referral':
                    $value['GoogleAnalyticsAccount']['label'] = __("Witryny odsyłające");
                    $newchart[] = $value;
                    break;
                case 'organic':
                default:
                    if(empty($default)){
                        $value['GoogleAnalyticsAccount']['label'] = __("Wyszukiwarki");
                        $default = $i;
                        $newchart[] = $value;
                    } else {
                        $newchart[$default]['GoogleAnalyticsAccount']['metrics']['value'] += $value['GoogleAnalyticsAccount']['metrics']['value'];
                    }
            }
        } else {
            $error = true;
        }
    }
    $chart = $newchart;
//    $labels = Set::extract($chart, '{n}.GoogleAnalyticsAccount.label');

if(empty($error)){
    
    echo $this->FlashChart->begin();

    $this->FlashChart->setToolTip('#label#<br>#val# (#percent#)');
    $this->FlashChart->setBgColour('#EBEBEB');
 
    $colours = array('#5c5c5d', '#f18e00', '#c3c3c3');
 
    $this->FlashChart->setData($chart, '{n}.GoogleAnalyticsAccount.metrics.value', '{n}.GoogleAnalyticsAccount.label', 'To', 'dig');
    echo $this->FlashChart->chart(
        'pie', 
        array('start_angle' => 0, 'no_labels' => true, 'animate' => false, 'colours' => $colours), 
        'To', 'dig'
    );

    echo $this->FlashChart->render(210, 210, 'dig');

?>
</div>
<div class="circle_legend" >
 <ul>
    <?php foreach($colours AS $i => $colour): ?>
        <?php if(!empty($chart[$i])): ?>
        <li>
<div style="background-color:<?php echo $colour; ?>;"></div>
            <strong><?php echo $chart[$i]['GoogleAnalyticsAccount']['label']; ?></strong><br />
            <?php echo $chart[$i]['GoogleAnalyticsAccount']['metrics']['value']; ?>
        </li>
        <?php endif; ?>
    <?php endforeach; ?>
 </ul>
<?php } ?>
</div>
</div>
