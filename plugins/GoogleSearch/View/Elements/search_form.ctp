<?php //echo $this->Html->css(array('search','http://www.google.com/cse/style/look/default.css'),null ,array('inline'=>false)); ?>
<?php 
    echo $this->Html->css('http://www.google.com/cse/style/look/default.css');
    echo $this->Html->css('/search/css/default');
?>
<div id="cse-search-form"></div>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
  google.load('search', '1', {language : 'pl'});
  google.setOnLoadCallback(function() {
    var customSearchControl = new google.search.CustomSearchControl('<?php echo Configure::read('Google.searchId'); ?>');
    customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
    var options = new google.search.DrawOptions();
    options.setSearchFormRoot('cse-search-form');
    customSearchControl.draw('cse', options);
    customSearchControl.setSearchCompleteCallback(window, updateDocTitle);
    
<?php if(!empty($this->params['data']['Search']['query'])){ ?>
    customSearchControl.execute('<?php echo $this->params['data']['Search']['query']; ?>');
<?php } ?>    
  }, true);
</script>