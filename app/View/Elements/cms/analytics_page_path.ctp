<?php

    $data = $this->requestAction(array('admin' => 'admin','prefix'=>'admin', 'controller' => 'panel', 'action' => 'analytics_page_path'));

?>
<div style="width: 800px;">
<h2><span>Popularne podstrony</span></h2>
<table cellspacing="0" cellpadding="0" style="margin: 10px 0;">
 <tr>
  <th>Strony</th>
  <th>Odsłony</th>
 </tr>
<?php foreach($data AS $key => $row): ?>
<?php $altrow = ($key%2)?' class="altrow"':''; ?>
 <tr<?php echo $altrow;?>>
 
  <td>
<?php 
    echo $this->Html->link(
        $this->Text->truncate($row['GoogleAnalyticsAccount']['dimensions']['value'], 40, array(
            'exact' => true, 'ending' => '…'
        )),
        '#', //FULL_BASE_URL.$row['GoogleAnalyticsAccount']['dimensions']['value'],
        array(
            'target' => '_blank', 
            'title' => $row['GoogleAnalyticsAccount']['dimensions']['value'],
            'onclick' => 'return false'
        )
    );
?>
  </td>
  <td><?php echo $row['GoogleAnalyticsAccount']['metrics']['value']; ?></td>
 </tr>
<?php endforeach; ?>
</table>    
</div>
