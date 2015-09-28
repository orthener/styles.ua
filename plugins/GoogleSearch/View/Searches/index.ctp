<?php 
$titleForLay = 'Wyszukiwarka';
$this->set('title_for_layout', $titleForLay);
$this->set('search_page', true);

if(!empty($this->params['data']['Search']['query'])){
?>
<script type="text/javascript">
<!-- //<![CDATA[
var title = document.title.substring(<?php echo strlen($titleForLay); ?>);

function updateDocTitle(customSearchControl){
    document.title = "Wyszukiwanie: " + customSearchControl.input.value + title;
    return true;
}

//]]> -->
</script>
<?php
}
?>
<div class="clearfix white">
    <h1><?php echo  __d('cms', 'Wyniki wyszukiwania'); ?></h1>
    <div id="cse" >
    </div>
</div>
