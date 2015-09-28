<?php

    $data = $this->requestAction(array('admin' => 'admin','prefix'=>'admin', 'controller' => 'panel', 'action' => 'analytics_sources'));

?>
<div>
<h2><span>Źródła odwiedzin</span></h2>
<table cellspacing="0" cellpadding="0" style="width:400px; margin: 10px 0;">
 <tr>
  <th>Źródła</th>
  <th>Odwiedziny</th>
 </tr>
<?php foreach($data AS $key => $row): ?>
<?php if(!empty($row['GoogleAnalyticsAccount']['dimensions']['value'])){ ?>
<?php $altrow = ($key%2)?' class="altrow"':''; ?>
 <tr<?php echo $altrow;?>>
  <td title="<?php echo $row['GoogleAnalyticsAccount']['dimensions']['value']; ?>" >
<?php 
    echo $this->Text->truncate(
        $row['GoogleAnalyticsAccount']['dimensions']['value'], 40,
        array('exact' => true, 'ending' => '…')
    );
?>
  </td>
  <td><?php echo $row['GoogleAnalyticsAccount']['metrics']['value']; ?></td>
 </tr>
<?php } ?>
<?php endforeach; ?>
</table>    
</div>
