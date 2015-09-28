<?php
foreach ($baners as $baner){
    if ($baner['Baner']['html_code']) {
        echo $baner['Baner']['html_code'];
    }
    if ($baner['Baner']['tiny']) {
        echo $baner['Baner']['tiny'];
    }
    
    if($baner['Baner']['image']) {
            echo $this->Html->link($this->Html->image('/files/baner/'.$baner['Baner']['image']), array('plugin' => 'baner', 'controller' => 'baners', 'action' => 'rd', $baner['Baner']['id']), array('escape' => false,'target' => '_blank','rel' => 'nofallow')); 
    }
}
?> 
